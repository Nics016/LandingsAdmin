<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

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
 */
class Landing extends \yii\db\ActiveRecord
{
    ///////////////
    // Константы //
    ///////////////
    const STATE_READY = 10;
    const STATE_OTDELKA = 20;
    const STATE_CLEAR_OTDELKA = 30;
    const STATE_SELLING = 40;

    const PLANNING_OPEN = 10;
    const PLANNING_MIXED = 20;
    const PLANNING_CABINET = 30;

    const PRICE_SIGN_RUB = 10;
    const PRICE_SIGN_DOL = 20;
    const PRICE_SIGN_EUR = 30;

    ////////////////
    // Properties //
    ////////////////
    public $object_photo_file;
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
            [['meters', 'state', 'planning', 'price', 'price_sign'], 'integer'],
            [['floor', 'about_text', 'characteristics_text', 'news_text', 'infostructure_text', 'location_text', 'contacts_text'], 'required'],
            [['about_text', 'characteristics_text', 'news_text', 'infostructure_text', 'location_text', 'contacts_text'], 'string'],
            [['title', 'floor'], 'string', 'max' => 32],
            [
                'object_photo_file', // variable name
                'file', // type
                'skipOnEmpty' => true,
                'extensions' => ['png', 'jpg', 'gif', 'svg', 'jpeg'],
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
     * Генерирует имя файла из переменной файла
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
        if ($files){
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
            'meters' => 'Метраж',
            'floor' => 'Этаж',
            'state' => 'Состояние',
            'planning' => 'Планировка',
            'price' => 'Ставка',
            'price_sign' => 'Валюта',
            'about_text' => 'Об объекте',
            'characteristics_text' => 'Характеристики',
            'news_text' => 'Новости',
            'infostructure_text' => 'Инфраструктура',
            'location_text' => 'Расположение',
            'contacts_text' => 'Контакты',
            'object_photo_file' => 'Фотография объекта',
            'object_photo' => 'Фотография объекта',
            'photos_files' => 'Фотографии (можно выбрать несколько файлов)',
            'arendator_photos_files' => 'Арендаторы (можно выбрать несколько файлов)',
        ];
    }
}
