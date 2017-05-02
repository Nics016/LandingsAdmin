<?php

namespace app\models;

use Yii;

use app\models\User;
use app\models\Landing;
use app\models\UserLanding;

/**
 * This is the model class for table "user_landing".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $landing_id
 */
class UserLanding extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_landing';
    }

    /**
     * Finds all managers who can control current
     * landing and return them into array.
     * @param  integer $land_id landing's id to be checked
     * @return \app\models\UserLanding          $managers
     */
    public function findManagersByLanding($land_id)
    {
        $usersLandings = UserLanding::find()
            ->where('landing_id=' . $land_id)
            ->all();
        $managers = [];
        foreach($usersLandings as $ul){
            $managers[] = User::findOne($ul->user_id);
        }
        return $managers;
    }

    /**
     * Finds all landings which can be controlled by current
     * manager and return them into array.
     * @param  integer $user_id manager's id to be checked
     * @return \app\models\UserLanding          $landings
     */
    public function findLandingsByManager($u_id)
    {
        $usersLandings = UserLanding::find()
            ->where('user_id=' . $u_id)
            ->all();
        $landings = [];
        foreach($usersLandings as $ul){
            $landings[] = Landing::findOne($ul->landing_id);
        }
        return $landings;
    }

    /**
     * Проверяет, имеет ли пользователь доступ к сайту.
     * Возвращает true, если да, false - если нет.  
     * @param  integer $uId  user
     * @param  integer $landId landing
     * @return boolean         $hasAccess
     */
    public function userHasAccessToLanding($uId, $landId)
    {
        if (Yii::$app->user->identity->role === User::ROLE_ADMIN)
            return true;

        $relationship = UserLanding::find()
                ->where('landing_id=' . $landId
                    . ' AND user_id=' . $uId)
                ->all();
        if ($relationship)
            return true;
        
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'landing_id'], 'required'],
            [['user_id', 'landing_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Менеджер',
            'landing_id' => 'Сайт',
        ];
    }
}
