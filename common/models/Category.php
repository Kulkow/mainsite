<?php

/*use yii\db\ActiveRecord;*/
namespace common\models;
 
use Yii;
use common\models\User;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use common\behaviors\SeoBehavior;
use yii\helpers\ArrayHelper;
 
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
    
    public function behaviors()
    {
        $behaviors = parent::behaviors() + [
                    'alias' => [
                        'class' => 'common\behaviors\Alias',
                        'in_attribute' => 'name',
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
                    'ownerBehavior'  => [
                        'class' => BlameableBehavior::className(),
                        'createdByAttribute' => 'owner',
                        'updatedByAttribute' => 'editor',
                    ],
                    'SeoBehavior'  =>[
                        'class' => SeoBehavior::className(),
                        'SourceAttribute' => 'name'
                    ],
        ];
        return $behaviors;
    }
    
    public function rules()
    {
        $rule = parent::rules();
        $rule[] = [['alias','keywords','description','title','h1'], 'string', 'max' => 255];
        $rule[] = [['title'], 'string', 'max' => 90];
        $rule[] = [['alias'], 'unique'];
        $rule[] = [['created','updated','owner','editor'], 'integer'];
        return $rule;
    }
    
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        return $attributeLabels + ['alias' => Yii::t('app', 'Alias'),
                                   'created' => Yii::t('app', 'Created'),
                                   'updated' => Yii::t('app', 'Updated'),
                                   'owner' => Yii::t('app', 'Owner'),
                                   'editor' => Yii::t('app', 'Editor'),
                                   'h1' => Yii::t('app', 'H1'),
                                   'title' => Yii::t('app', 'Title'),
                                   'keywords' => Yii::t('app', 'Keywords'),
                                   'description' => Yii::t('app', 'Keywords'),
                                   ];
    }
}


?>