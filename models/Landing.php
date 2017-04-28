<?php

namespace app\models;

use Yii;

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
 * @property string $characterstics_text
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
            [['floor', 'about_text', 'characterstics_text', 'news_text', 'infostructure_text', 'location_text', 'contacts_text'], 'required'],
            [['about_text', 'characterstics_text', 'news_text', 'infostructure_text', 'location_text', 'contacts_text'], 'string'],
            [['title', 'floor'], 'string', 'max' => 32],
        ];
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
            'characterstics_text' => 'Характеристики',
            'news_text' => 'Новости',
            'infostructure_text' => 'Инфраструктура',
            'location_text' => 'Расположение',
            'contacts_text' => 'Контакты',
        ];
    }
}
