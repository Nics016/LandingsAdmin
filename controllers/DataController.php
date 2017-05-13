<?php 
	namespace app\controllers;

	use yii\rest\ActiveController;
	use app\models\User;
	use app\models\Landing;
	use app\models\UserLanding;
	use Yii;
	use yii\helpers\ArrayHelper;
	use yii\filters\auth\HttpBasicAuth;
	use app\components\AccessRule;
	use yii\filters\AccessControl;

	class DataController extends ActiveController
	{
		public $modelClass = 'app\models\Landing';

		public function behaviors()
		{
			return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
				'authenticator' => [
					'authMethods' => [
						'basicAuth' => [
							'class' => HttpBasicAuth::className(),
							'auth' => function($username, $password){
								$user = User::findByUsername($username);
								if ($user !== null && $user->validatePassword($password)){
									return $user;
								}

								return null;
							},
						],
					],
				],
				'corsFilter' => [
					'class' => \yii\filters\Cors::className(),
				],
				'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['get-landing-data', 'send-email'],
                        'allow' => true,
                        // Allow only admin
                        'roles' => [
                            User::ROLE_MANAGER
                        ],
                    ],
                    [
                        'actions' => ['create', 'index', 'update', 'view', 'delete', 'get-landing-data', 'send-email'],
                        'allow' => true,
                        // Allow only admin
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ],
                ],
            ],
			]);
		}

		public function actionSendEmail($id, $msg, $topic, $email)
		{
			// firstly chech whether user has access to this landing
			$u_id = Yii::$app->user->identity->id;
			if (UserLanding::userHasAccessToLanding($u_id, $id)){
				$landing = Landing::findOne($id);
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				// $msg = wordwrap($msg,70);
				mail($email, $topic, $msg, $headers);
				return "good";
			}
			else
				return "У вас нет доступа к этому сайту";
		}

		/**
		 * Возвращает данные о лэндинге и его площадках
		 * с авторизацией.		
		 * 
		 * @param integer $id - landing id
		 * @return array - array with two keys - 'landing', 'places'
		 */
		public function actionGetLandingData($id)
		{
			// firstly chech whether user has access to this landing
			$u_id = Yii::$app->user->identity->id;
			if (UserLanding::userHasAccessToLanding($u_id, $id)){
				$landing = Landing::findOne($id);
				$data = [];
				$data['landing'] = $landing;
				$data['places'] = Landing::getLandingPlaces($id);
				$data['status'] = 'ok';
			}
			else
				return "У вас нет доступа к этому сайту";
			
			return $data;
		}
	}
 ?>