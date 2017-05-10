<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "place".
 *
 * @property integer $place_id
 * @property integer $landing_id
 * @property string $meters
 * @property string $floor
 * @property integer $state
 * @property integer $planning
 * @property integer $price
 * @property integer $price_sign
 * @property string $object_photos
 */
class Place extends \yii\db\ActiveRecord
{
    ///////////////
    // Константы //
    ///////////////
    const STATE = 1;
    const STATE_READY = 10;
    const STATE_OTDELKA = 20;
    const STATE_CLEAR_OTDELKA = 30;
    const STATE_SELLING = 40;

    const PLANNING = 2;
    const PLANNING_OPEN = 10;
    const PLANNING_MIXED = 20;
    const PLANNING_CABINET = 30;

    const PRICE_SIGN = 3;
    const PRICE_SIGN_RUB = 10;
    const PRICE_SIGN_DOL = 20;
    const PRICE_SIGN_EUR = 30;

    ////////////////
    // Properties //
    ////////////////
    /**
     * Used for files
     */
    public $object_photos_files;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'place';
    }

    public function findPlacesByLanding($landing_id)
    {
        $landings = Place::find()
            ->where('landing_id=' . $landing_id)
            ->all();

        return $landings;
    }

    public function generateLi($model)
    {
        $state = '';
        $planning = '';
        $price_sign = '';
        switch($model['state']){
            case $model::STATE_READY:
                $state = "готово к въезду";
                break;

            case $model::STATE_OTDELKA:
                $state = "под отделку";
                break;

            case $model::STATE_CLEAR_OTDELKA:
                $state = "под чистовую отделку";
                break;

            case $model::STATE_SELLING:
                $state = "продажа";
                break;

        }

        switch($model['planning']){
            case $model::PLANNING_OPEN:
                $planning = "открытая";
                break;

            case $model::PLANNING_MIXED:
                $planning = "смешанная";
                break;

            case $model::PLANNING_CABINET:
                $planning = "кабинетная";
                break;
        }

        switch($model['price_sign']){
            case $model::PRICE_SIGN_RUB:
                $price_sign = "Руб";
                break;

            case $model::PRICE_SIGN_DOL:
                $price_sign = "$";
                break;

            case $model::PRICE_SIGN_EUR:
                $price_sign = "€";
                break;
        }

        $object_photos = json_decode($model->object_photos);
        if ($object_photos){
            $photos = '';
            foreach ($object_photos as $photo){
                $photos .= Html::img($photo, ['style' => 'max-width: 600px']).'<br>'.'<br>';
            }
        } else {
            $photos = 'нет';
        }

        $answ = '<li>';
            $answ .= 'Метраж: ' . $model['meters'];
        $answ .= '</li>';
        $answ .= '<li>';
            $answ .= 'Этаж: ' . $model['floor'];
        $answ .= '</li>';
        $answ .= '<li>';
            $answ .= 'Состояние: ' . $state;
        $answ .= '</li>';
        $answ .= '<li>';
            $answ .= 'Планировка: ' . $planning;
        $answ .= '</li>';
        $answ .= '<li>';
            $answ .= 'Ставка: ' . $model['price'] . ' ' . $price_sign;
        $answ .= '</li>';
        $answ .= '<li>';
            $answ .= 'Фотографии: ' . $photos;
        $answ .= '</li>';

        return $answ;
    }

    public function getDdlText($val, $ddl_id)
    {
        $ddlText = [
            Place::STATE => [
                Place::STATE_READY => 'готово к въезду',
                Place::STATE_OTDELKA => 'под отделку',
                Place::STATE_CLEAR_OTDELKA => 'под чистовую отделку',
                Place::STATE_SELLING => 'продажа',
            ],
            Place::PLANNING => [
                Place::PLANNING_OPEN => 'открытая',
                Place::PLANNING_MIXED => 'смешанная',
                Place::PLANNING_CABINET => 'кабинетная',
            ],
            Place::PRICE_SIGN => [
                Place::PRICE_SIGN_RUB => 'Руб.',
                Place::PRICE_SIGN_DOL => '$',
                Place::PRICE_SIGN_EUR => '€',
            ],
        ];

        return $ddlText[$ddl_id][$val];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['meters'], 'each', 'rule'=>['double']],
            [['floor', 'meters'], 'required'],
            [['state', 'planning', 'price', 'price_sign'], 'integer'],
            [['object_photos'], 'string'],
            [['floor'], 'string', 'max' => 32],
            [
                'object_photos_files', // variable name
                'file', // type
                'skipOnEmpty' => true,
                'extensions' => ['png', 'jpg', 'gif', 'svg', 'jpeg'],
                'maxFiles' => 10,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'place_id' => 'Place ID',
            'meters' => 'Метраж',
            'floor' => 'Этаж',
            'state' => 'Состояние',
            'planning' => 'Планировка',
            'price' => 'Ставка',
            'price_sign' => 'Валюта',
            'object_photos' => 'Фотографии объекта',
            'object_photo_file' => 'Фотографии объекта',
        ];
    }
}
