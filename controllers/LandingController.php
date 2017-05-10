<?php

namespace app\controllers;

use Yii;
use app\models\Landing;
use app\models\Place;
use app\models\AskPlaces;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\components\AccessRule;
use yii\filters\AccessControl;
use app\models\User;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * LandingController implements the CRUD actions for Landing model.
 */
class LandingController extends Controller
{
    public $layout = 'adminPanel';
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST', 'GET'],
                ],
            ],

            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['update', 'view'],
                        'allow' => true,
                        // Allow only admin
                        'roles' => [
                            User::ROLE_MANAGER
                        ],
                    ],
                    [
                        'actions' => ['create', 'index', 'update', 'view', 'delete',
                            'ask-places', 'ask-places-update'],
                        'allow' => true,
                        // Allow only admin
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Landing models.
     * @return mixed
     */
    public function actionIndex()
    {
        // return $this->renderContent(Url::base(true));
        $dataProvider = new ActiveDataProvider([
            'query' => Landing::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Landing model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Page which is shown before 'update'
     * to ask how many places should there be.
     */
    public function actionAskPlacesUpdate($land_id)
    {
        $model = new AskPlaces();

        $numPlaces = count(Place::findPlacesByLanding($land_id));

        if ($model->load(Yii::$app->request->post())) {
                return $this->redirect([
                    'update', 
                    'id' => $land_id,
                    'numPlaces' => $model->numPlaces
                ]);
        } else {
            return $this->render('ask-places-update', [
                'model' => $model,
                'numPlaces' => $numPlaces,
            ]);
        }
    }
    /**
     * Page which is shown before 'create'
     * to ask how many places should there be.
     */
    public function actionAskPlaces()
    {
        $model = new AskPlaces();

        if ($model->load(Yii::$app->request->post())) {
                return $this->redirect(['create', 'numPlaces' => $model->numPlaces]);
        } else {
            return $this->render('ask-places', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new Landing model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($numPlaces)
    {
        $model = new Landing();

        if ($model->load(Yii::$app->request->post())) {
            // Uploading files for places

            $model->convertFilesArrayToJson(
                $model,
                'object_photos_files',
                'object_photos',
                $numPlaces
            );
            $model->convertFilesToJson(
                $model,
                'photos_files',
                'photos'                
            );
            $model->convertFilesToJson(
                $model,
                'arendator_photos_files',
                'arendator_photos'
            );

            if ($model->save(false)){
                // saving files on server
                for($i = 0; $i < $numPlaces; $i++){
                    $model->object_photos[$i] = $model->saveFilesByJsonArray($model->object_photos_files[$i], $model->object_photos[$i]);
                }
                $model->photos = $model->saveFilesByJsonArray($model->photos_files, $model->photos);
                $model->arendator_photos = $model->saveFilesByJsonArray($model->arendator_photos_files, $model->arendator_photos);

                $model->createPlaces($model, $numPlaces);

                // saving updated absolute urls
                $model->save(false);
                
                return $this->redirect(['view', 'id' => $model->landing_id]);
            }
            else 
                print_r($model->getErrors());        
            
        } else {
            return $this->render('create', [
                'model' => $model,
                'numPlaces' => $numPlaces,
            ]);
        }
    }

    /**
     * Updates an existing Landing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $numPlaces)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // Uploading files for places

            $model->convertFilesArrayToJson(
                $model,
                'object_photos_files',
                'object_photos',
                $numPlaces
            );
            $model->convertFilesToJson(
                $model,
                'photos_files',
                'photos'                
            );
            $model->convertFilesToJson(
                $model,
                'arendator_photos_files',
                'arendator_photos'
            );

            if ($model->save(false)){
                // saving files on server
                for($i = 0; $i < $numPlaces; $i++){
                    if (array_key_exists($i, $model->object_photos))
                        $model->saveFilesByJsonArray($model->object_photos_files[$i], $model->object_photos[$i]);
                }
                $model->saveFilesByJsonArray($model->photos_files, $model->photos);
                $model->saveFilesByJsonArray($model->arendator_photos_files, $model->arendator_photos);

                $model->createPlaces($model, $numPlaces);

                return $this->redirect(['view', 'id' => $model->landing_id]);
            }
            else 
                print_r($model->getErrors());        
            
        } else {
            $existingPlaces = Place::findPlacesByLanding($model->landing_id);
            return $this->render('update', [
                'model' => $model,
                'numPlaces' => $numPlaces,
                'existingPlaces' => $existingPlaces,
            ]);
        }
    }

    /**
     * Deletes an existing Landing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Landing model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Landing the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Landing::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
