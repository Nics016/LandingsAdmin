<?php

namespace app\models;

use yii\base\Model;

	class AskPlaces extends Model
	{
		public $numPlaces;

		public function rules()
		{
			return [
			    ['numPlaces', 'number'],
			    ['numPlaces', 'required'],
		    ];
		}

		public function attributeLabels()
		{
			return [
				'numPlaces' => 'Количество площадок',
			];
		}
	}
?>