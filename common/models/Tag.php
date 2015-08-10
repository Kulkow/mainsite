<?php

namespace common\models;

use Yii;

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
            [['tag', 'count', 'topics', 'shares', 'labels', 'created', 'updated'], 'required'],
            [['count', 'topics', 'shares', 'labels', 'created', 'updated', 'active'], 'integer'],
            [['tag'], 'string', 'max' => 255]
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
            'count' => Yii::t('app', 'Count'),
            'topics' => Yii::t('app', 'Topics'),
            'shares' => Yii::t('app', 'Shares'),
            'labels' => Yii::t('app', 'Labels'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'active' => Yii::t('app', 'Active'),
        ];
    }
}
