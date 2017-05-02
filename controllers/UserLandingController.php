<?php

namespace app\controllers;

use Yii;
use app\models\UserLanding;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\components\AccessRule;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Landing;

/**
 * UserLandingController implements the CRUD actions for UserLanding model.
 */
class UserLandingController extends Controller
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
     * Lists all UserLanding models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => UserLanding::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserLanding model.
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
     * Creates a new UserLanding model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserLanding();

        if ($model->load(Yii::$app->request->post())) {
            // Firstly check whether there's the same record
            $relationship = UserLanding::find()
                ->where('landing_id=' . $model->landing_id 
                    . ' AND user_id=' . $model->user_id)
                ->all();
            if ($relationship)
                return $this->renderContent('<h1>Данный пользователь уже имеет доступ к этому сайту</h1>');
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            // Receiving list of landings and users into array
            // to use them in dropdownlist
            $users = $this->getAllActiveUsers();
            $landings = $this->getAllLandings();
            return $this->render('create', [
                'model' => $model,
                'users' => $users,
                'landings' => $landings,
            ]);
        }
    }

    /**
     * Finds all users with role = manager and status = active
     * and returns them in format [id => username, ...]
     * @return array $users
     */
    public function getAllActiveUsers()
    {
        $users = User::find()
            ->where('role=' . User::ROLE_MANAGER . ' AND status=' . User::STATUS_ACTIVE)
            ->all();
        $returnUsers = [];
        foreach($users as $u){
            $returnUsers[$u->id] = $u->username;
        }
        return $returnUsers;
    }

    /**
     * Finds all landings and returns them
     * in format [id => name, ...]
     * @return array $landings
     */
    public function getAllLandings()
    {
        $landings = Landing::find()
            ->all();
        $returnLandings = [];
        foreach ($landings as $land){
            $returnLandings[$land->landing_id] = $land->title;
        }
        return $returnLandings;
    }

    /**
     * Updates an existing UserLanding model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UserLanding model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        $model = new UserLanding();

        if ($model->load(Yii::$app->request->post())) {
            // Firstly check whether there's the same record
            $relationship = UserLanding::find()
                ->where('landing_id=' . $model->landing_id 
                    . ' AND user_id=' . $model->user_id)
                ->all();
            if (!$relationship)
                return $this->renderContent('<h1>Данный пользователь не имеет доступа к этому сайту</h1>');
            $relationship[0]->delete();

            return $this->renderContent('<h1>Вы успешно лишили менеджера доступа к сайту</h1>');
        } else {
            // Receiving list of landings and users into array
            // to use them in dropdownlist
            $users = $this->getAllActiveUsers();
            $landings = $this->getAllLandings();
            return $this->render('delete', [
                'model' => $model,
                'users' => $users,
                'landings' => $landings,
            ]);
        }
    }

    /**
     * Finds the UserLanding model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserLanding the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserLanding::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
