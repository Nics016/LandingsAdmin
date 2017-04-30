<?php

namespace app\controllers;

use Yii;
use app\models\Landing;
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
                        'actions' => ['create', 'index', 'update', 'view', 'delete'],
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
     * Creates a new Landing model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // return $this->renderContent($_SERVER['DOCUMENT_ROOT'].'/landigs/web/uploads');
        $model = new Landing();

        if ($model->load(Yii::$app->request->post())) {
            // getting paths for files
            $model->object_photo_file = UploadedFile::getInstance($model, 'object_photo_file');
            $model->object_photo = $model->generateFileName($model->object_photo_file);

            $model->photos_files = UploadedFile::getInstances($model, 'photos_files');
            $model->photos = $model->generateJsonArray($model->photos_files);
            $model->arendator_photos_files = UploadedFile::getInstances($model, 'arendator_photos_files');
            $model->arendator_photos = $model->generateJsonArray($model->arendator_photos_files);

            if ($model->save()){
                // saving files on server
                if ($model->object_photo)
                    $model->object_photo_file->saveAs($model->object_photo);
                $model->saveFilesByJsonArray($model->photos_files, $model->photos);
                $model->saveFilesByJsonArray($model->arendator_photos_files, $model->arendator_photos);

                return $this->redirect(['view', 'id' => $model->landing_id]);
            }
            else 
                print_r($model->getErrors());        
            
        } else {
            return $this->render('create', [
                'model' => $model,
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
            $model->object_photo_file = UploadedFile::getInstance($model, 'object_photo_file');
            if ($model->object_photo_file !== null)
                $model->object_photo = $model->generateFileName($model->object_photo_file);

            $model->photos_files = UploadedFile::getInstances($model, 'photos_files');
            if (count($model->photos_files) > 0)
                $model->photos = $model->generateJsonArray($model->photos_files);
            $model->arendator_photos_files = UploadedFile::getInstances($model, 'arendator_photos_files');
            if (count($model->arendator_photos_files) > 0)
                $model->arendator_photos = $model->generateJsonArray($model->arendator_photos_files);

            if ($model->save()){
                // saving files on server
                if ($model->object_photo_file)
                    $model->object_photo_file->saveAs($model->object_photo);
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
