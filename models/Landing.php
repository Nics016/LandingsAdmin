<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use app\models\Place;
use app\models\PlaceLanding;

/**
 * This is the model class for table "landing".
 *
 * @property integer $landing_id
 * @property string $title
 * @property integer $meters
 * @property string $floor
 * @property integer $state
 * @property integer $planning
 * @property integer $price
 * @property integer $price_sign
 * @property string $about_text
 * @property string $characteristics_text
 * @property string $news_text
 * @property string $infostructure_text
 * @property string $location_text
 * @property string $contacts_text
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property decimal $latitude
 * @property decimal $longitude
 */
class Landing extends \yii\db\ActiveRecord
{
    ////////////////
    // Properties //
    ////////////////
    /**
     * Used for places
     */
    public $meters;
    public $floor;
    public $state;
    public $planning;
    public $price;
    public $price_sign;

    /**
     * Used for files
     */
    public $object_photos;
    public $object_photos_files;
    public $photos_files;
    public $arendator_photos_files;
    

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'landing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['meters', 'latitude', 'longitude'], 'number'],
            [['state', 'planning', 'price', 'price_sign'], 'integer'],
            [['floor', 'about_text', 'characteristics_text', 'news_text', 'infostructure_text', 'location_text', 'contacts_text', 'latitude', 'longitude'], 'required'],
            [['about_text', 'characteristics_text', 'news_text', 'infostructure_text', 'location_text', 'contacts_text'], 'string'],
            [['title', 'floor'], 'string', 'max' => 32],
            [
                'object_photos_files', // variable name
                'file', // type
                'skipOnEmpty' => true,
                'extensions' => ['png', 'jpg', 'gif', 'svg', 'jpeg'],
                'maxFiles' => 10,
            ],
            [
                ['photos', 'arendator_photos'],
                'file', 
                'skipOnEmpty' => true,
                'extensions' => ['png', 'jpg', 'gif', 'svg', 'jpeg'],
                'maxFiles' => 5,
            ],
        ];
    }

    /**
     * На основе данных модели Лэндинга создает записи 
     * в таблицах Place и PlaceLanding.
     *
     * @param $model app\models\Landing
     * @param $numPlaces integer количество создаваемых площадок
     */
    public function createPlaces($model, $numPlaces)
    {
        // update existing
        $placesExist = Place::find()
            ->where('landing_id=' . $model->landing_id)
            ->all();
        for($i = 0; $i < count($placesExist); $i++){
            $modelPlace = $placesExist[$i];
            $modelPlace->meters = $model->meters[$i];
            $modelPlace->floor = $model->floor[$i];
            $modelPlace->state = $model->state[$i];
            $modelPlace->planning = $model->planning[$i];
            $modelPlace->price = $model->price[$i];
            $modelPlace->price_sign = $model->price_sign[$i];
            if (array_key_exists($i, $model->object_photos)
                && array_key_exists($i, $model->object_photos_files)
                && count($model->object_photos_files[$i] > 0))
                $modelPlace->object_photos = $model->object_photos[$i];
            $modelPlace->save(false);
        }

        // create new
        for($i = count($placesExist); $i < $numPlaces; $i++){
            $modelPlace = new Place();
            $modelPlace->landing_id = $model->landing_id;
            $modelPlace->meters = $model->meters[$i];
            $modelPlace->floor = $model->floor[$i];
            $modelPlace->state = $model->state[$i];
            $modelPlace->planning = $model->planning[$i];
            $modelPlace->price = $model->price[$i];
            $modelPlace->price_sign = $model->price_sign[$i];
            if (array_key_exists($i, $model->object_photos))
                $modelPlace->object_photos = $model->object_photos[$i];
            else
                $modelPlace->object_photos = '';
            $modelPlace->save(false);
        }
    }

    /**
     * Генерирует имя файла из переменной файла.
     * 
     * @param  yii\web\UploadedFile $file файл
     * @return string       имя файла, которое будет в БД
     */
    public function generateFileName($file)
    {
        $answ = '';
        if ($file){
            $answ = 'uploads/' 
                . Yii::$app->getSecurity()->generateRandomString() . '_'
                . $file->baseName . '.' . $file->extension;
        }
        return $answ;
    }

    /**
     * Функция создана для уменьшения количества повторяемого кода.
     *
     * Из экземпляров загруженных файлов генерирует массив JSON
     * и возвращает его.
     * 
     * @param $model app\models\Landing
     * @param  string $attrName аттрибут файлов
     * @return JsonArrayString        возвращаемая строка - json
     */
    public function convertFilesToJson(&$model, $attrName, $attrNameJson)
    {
        $model[$attrName] = UploadedFile::getInstances($model, $attrName);
        if (count($model[$attrName]) > 0)
            $model[$attrNameJson] = $this->generateJsonArray($model[$attrName]);
    }

    /**
     * Версия предыдущей функции для случая, когда необходимо
     * обработать массив файлов (массив массивов файлов).
     * 
     * @param  app\models\Landing &$model   
     * @param  string $attrName аттрибут файлов
     * @param  string $attrJson аттрибут JSON
     * @param  integer $num     количество массивов файлов
     */
    public function convertFilesArrayToJson(&$model, $attrName, $attrJson, $num)
    {
        $newAttrNameArray = [];
        $newAttrNameJsonArray = [];
        for ($i = 0; $i < $num; $i++){
            $newAttrNameArray[$i] = UploadedFile::getInstances(
                $model, $attrName . '[' . $i . ']');

            if (count($newAttrNameArray[$i]) > 0)
                $newAttrNameJsonArray[$i] = $this->generateJsonArray($newAttrNameArray[$i]);
        }
        $model[$attrName] = $newAttrNameArray;
        $model[$attrJson] = $newAttrNameJsonArray;
    }

    /**
     * Генерирует массив имен файлов и переводит его в формат JSON
     * @param  yii\web\UploadedFile $files файлы
     * @return JsonArrayString        возвращаемая строка - json
     */
    public function generateJsonArray($files)
    {
        $fileNameArray = [];
        foreach ($files as $file){
            $fileNameArray[] = $this->generateFileName($file);
        }
        $jsonArray = json_encode($fileNameArray);
        return $jsonArray;
    }

    /**
     * Сохраняет файлы первого массива по путям второго массива
     * @param  yii\web\UploadedFile $files             файлы
     * @param  JsonArrayString $fileNameArrayJson массив в формате Json путей файлов
     * @return boolean                    результат
     */
    public function saveFilesByJsonArray($files, $fileNameArrayJson)
    {
        if (count($files) > 0){
            $fileNameArray = json_decode($fileNameArrayJson);
            for ($i = 0; $i < count($fileNameArray); $i++){
                if ($files[$i]){
                    $result = $files[$i]->saveAs($fileNameArray[$i]);
                    if (!$result)
                        return false;
                }
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'landing_id' => 'Landing ID',
            'title' => 'Название',
            'about_text' => 'Об объекте',
            'characteristics_text' => 'Характеристики',
            'news_text' => 'Новости',
            'infostructure_text' => 'Инфраструктура',
            'location_text' => 'Расположение',
            'contacts_text' => 'Контакты',
            'photos_files' => 'Фотографии (можно выбрать несколько файлов)',
            'arendator_photos_files' => 'Арендаторы (можно выбрать несколько файлов)',
            'latitude' => 'Широта (для Google Maps)',
            'longitude' => 'Долгота (для Google Maps)',
        ];
    }
}
