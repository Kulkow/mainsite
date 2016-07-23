<?php
namespace frontend\controllers;

use Yii;
use yii\base\Model;
use yii\caching\TagDependency;
use frontend\models\Cache;
use yii\data\Pagination;
use yii\web\Controller;
use yii\helpers\ArrayHelper;


/**
 * Layout controller
 */
class LayoutController extends Controller
{
    protected $paginate = ['per_page' => 2];
    protected $sorting = ['field' => 'created', 'direction' => 'asc'];
    protected $clear_request_key = 'cache_clear'; //ключ по которому удаляется кеш

    protected function getCache($key = null){

        if(Yii::$app->request->get($this->clear_request_key)){
            Yii::$app->cache->delete($key);
            return false;
        }
        return Yii::$app->cache->get($key);
    }

    protected function setCache($key, $data, $config = NULL, $tags = []){
        $expiration = Cache::EXPIRES_CACHE;
        if($config){
            if(! is_array($config)){
                $model_option = explode('_', $config);
                list($m, $option) = $model_option;
                $config = Cache::factory($m, $option);
            }else{
                $expiration = ArrayHelper::getValue($config, 'expires', $expiration);
            }
        }
        Yii::$app->cache->set($key,$data,$expiration, new TagDependency(['tags' =>  $tags]));
    }

    protected function cacheKeyPaginate(Pagination $paginate){
        $keys = [
            'page' => $paginate->getPage(),
            'per_page' => $paginate->getPageSize(),
        ];
        return md5(serialize($keys));
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