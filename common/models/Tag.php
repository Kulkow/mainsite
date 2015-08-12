<?php

namespace common\models;

use Yii;
use common\helpers;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $tag
 * @property integer $count
 * @property integer $topics
 * @property integer $shares
 * @property integer $labels
 * @property integer $created
 * @property integer $updated
 * @property integer $active
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag'], 'required'],
            [['count', 'topics', 'shares', 'labels', 'created', 'updated', 'active'], 'integer'],
            [['tag','alias'], 'string', 'max' => 255]
        ];
    }
    
    public function behaviors()
    {
        return [
            'alias' => [
                'class' => 'common\behaviors\Alias',
                'in_attribute' => 'tag',
                'out_attribute' => 'alias',
                'translit' => true
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tag' => Yii::t('app', 'Tag'),
            'alias' => Yii::t('app', 'Alias'),
            'count' => Yii::t('app', 'Count'),
            'topics' => Yii::t('app', 'Topics'),
            'shares' => Yii::t('app', 'Shares'),
            'labels' => Yii::t('app', 'Labels'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'active' => Yii::t('app', 'Active'),
        ];
    }
    
    public function beforeSave($insert)
    {
        if (!isset($this->created)) {
            $this->created = time();
        }
        $this->updated = time();
        return parent::beforeSave($insert);
    }
}
