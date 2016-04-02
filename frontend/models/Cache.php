<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Cache use controller.
 */
class Cache extends Model
{
    const EXPIRES_CACHE = 3600;

    public static function factory($model = NULL, $option){
        $model = 'common\models\\'.$model;
        $new = new $model();
        $default = [
            'expires' => self::EXPIRES_CACHE,
        ];
        if(method_exists($new, 'cache_option')){
            $config = $new->cache_option();
            return  ArrayHelper::merge($config, $default);
        }
        return null;
    }
}