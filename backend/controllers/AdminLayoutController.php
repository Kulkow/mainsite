<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;


/**
 * AdminLayoutController controller
 */
class AdminLayoutController extends Controller
{
    public $auth_user = null;
    public function init(){
        parent::init();
        if($user = Yii::$app->getUser()){
            $this->auth_user = $user->identity;
            //Yii::$app->view->params['auth_user'] = $user->identity;
        }
    }
    public function error($key, $message = NULL){
        if(is_numeric($key)){
            switch($key){
                case 404:
                    throw new \yii\web\NotFoundHttpException($message);
                    break;
                case 403:
                    throw new \yii\web\ForbiddenHttpException($message);
                    break;
                case 405:
                    throw new \yii\web\MethodNotAllowedHttpException($message);
                    break;
                case 500:
                    break;
                case 501:
                    break;
                case 502:
                    break;
            }
        }
    }
}