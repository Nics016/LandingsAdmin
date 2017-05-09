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
                    'delete' => ['POST'],
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
                        'actions' => ['ask-places', 'create', 'index', 'update', 'view', 'delete'],
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
            // $model->object_photos_files = UploadedFile::getInstances($model, 'object_photos_files[1]');
            // return $this->renderContent(print_r($model->object_photos_files));

            $model->convertFilesArrayToJson(
                $model,
                'object_photos_files',
                'object_photos',
                $numPlaces
            );
            $model->photos = $model->convertFilesToJson(
                $model,
                'photos_files'                
            );
            $model->arendator_photos = $model->convertFilesToJson(
                $model,
                'arendator_photos_files'
            );

            if ($model->save(false)){
                // saving files on server
                for($i = 0; $i < $numPlaces; $i++){
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            // getting paths for files
            // $model->object_photos_files = UploadedFile::getInstance($model, 'object_photos_files');
            // if ($model->object_photo_file !== null)
                // $model->object_photo = $model->generateFileName($model->object_photo_file);

            $model->photos_files = UploadedFile::getInstances($model, 'photos_files');
            if (count($model->photos_files) > 0)
                $model->photos = $model->generateJsonArray($model->photos_files);
            $model->arendator_photos_files = UploadedFile::getInstances($model, 'arendator_photos_files');
            if (count($model->arendator_photos_files) > 0)
                $model->arendator_photos = $model->generateJsonArray($model->arendator_photos_files);

            if ($model->save()){
                // saving files on server
                // if ($model->object_photo_file)
                    // $model->object_photo_file->saveAs($model->object_photo);
                if (count($model->photos_files) > 0)
                    $model->saveFilesByJsonArray($model->photos_files, $model->photos);
                if (count($model->arendator_photos_files) > 0)
                    $model->saveFilesByJsonArray($model->arendator_photos_files, $model->arendator_photos);

                return $this->redirect(['view', 'id' => $model->landing_id]);
            }
            else 
                print_r($model->getErrors());        
            
        } else {
            return $this->render('update', [
                'model' => $model,
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
