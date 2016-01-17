<?php
namespace common\components\rbac;
use Yii;
use yii\rbac\Rule;
use yii\helpers\ArrayHelper;
use common\models\User;
use yii\web\NotFoundHttpException;
class UserRoleRule extends Rule
{
    public $name = 'userRole';
    public function execute($user, $item, $params)
    {
        //Получаем массив пользователя из базы
        $cacheUser = 'User_role:'.Yii::$app->user->id;
        if (false === $_user = Yii::$app->cache->get($cacheUser)) {
            if (null === $_user = User::findOne($user)) {
                throw new NotFoundHttpException;
            }
            Yii::$app->cache->set(
                $cacheUser,
                $_user,
                86400
            );
        }
        $user = ArrayHelper::getValue($params, 'user', $_user);
        if ($user) {
            $role = $user->role; //Значение из поля role базы данных
            if ($item->name === 'admin') {
                return $role == User::ROLE_ADMIN;
            } elseif ($item->name === 'moder') {
                //moder является потомком admin, который получает его права
                return $role == User::ROLE_ADMIN || $role == User::ROLE_MODER;
            } 
            elseif ($item->name === 'user') {
                return $role == User::ROLE_ADMIN || $role == User::ROLE_MODER
                || $role == User::ROLE_USER;
            }
        }
        return false;
    }
}