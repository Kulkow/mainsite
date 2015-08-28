<?php
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\behaviors\SeoBehavior;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

class Category extends \kartik\tree\models\Tree
{
    public function behaviors()
    {
        return [
            'alias' => [
                'class' => 'common\behaviors\Alias',
                'in_attribute' => 'h1',
                'out_attribute' => 'alias',
                'translit' => true
            ],
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated',
                ]
            ],
            'ownerBehavior'  =>[
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'owner',
                'updatedByAttribute' => 'editor',
            ],
            'SeoBehavior'  =>[
                'class' => SeoBehavior::className(),
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }    
}
?>