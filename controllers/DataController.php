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
                        'actions' => ['get-landing-data'],
                        'allow' => true,
                        // Allow only admin
                        'roles' => [
                            User::ROLE_MANAGER
                        ],
                    ],
                    [
                        'actions' => ['create', 'index', 'update', 'view', 'delete', 'get-landing-data'],
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

		public function actionGetLandingData($id)
		{
			// firstly chech whether user has access to this landing
			$u_id = Yii::$app->user->identity->id;
			if (UserLanding::userHasAccessToLanding($u_id, $id)){
				$data = Landing::findOne($id);
			}
			else
				return "У вас нет доступа к этому сайту";
			
			return $data;
		}
	}
 ?>