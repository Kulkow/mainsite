<?php
/*
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\behaviors\SeoBehavior;
use yii\helpers\ArrayHelper;*/
/*use yii\db\ActiveRecord;*/
namespace common\models;
 
use Yii;
use common\models\User;
 
class Category extends \kartik\tree\models\Tree
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }    
    
    /**
     * Override isDisabled method if you need as shown in the  
     * example below. You can override similarly other methods
     * like isActive, isMovable etc.
     */
    public function isDisabled()
    {
        /*
        if (Yii::$app->user->role !== User::ROLE_ADMIN) {
            return true;
        }
        */
        return parent::isDisabled();
    }
}


?>