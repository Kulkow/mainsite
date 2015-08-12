<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "topic_tags".
 *
 * @property integer $id
 * @property integer $topic_id
 * @property integer $tag_id
 *
 * @property Tag $tag
 * @property Topic $topic
 */
class TopicTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topic_tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topic_id', 'tag_id'], 'required'],
            [['topic_id', 'tag_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'topic_id' => Yii::t('app', 'Topic ID'),
            'tag_id' => Yii::t('app', 'Tag ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }
}
