<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "topic".
 *
 * @property integer $id
 * @property string $h1
 * @property string $alias
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $announce
 * @property string $content
 * @property integer $owner
 * @property integer $created
 * @property integer $updated
 * @property integer $active
 *
 * @property User $owner0
 * @property TopicTags[] $topicTags
 */
class Topic extends \yii\db\ActiveRecord
{
    protected $tags = [];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['h1', 'alias', 'title', 'keywords', 'description', 'owner', 'created', 'updated'], 'required'],
            [['announce', 'content'], 'string'],
            [['owner', 'created', 'updated', 'active'], 'integer'],
            [['h1', 'alias', 'keywords', 'description'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 90],
            [['alias'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'h1' => Yii::t('app', 'H1'),
            'alias' => Yii::t('app', 'Alias'),
            'title' => Yii::t('app', 'Title'),
            'keywords' => Yii::t('app', 'Keywords'),
            'description' => Yii::t('app', 'Description'),
            'announce' => Yii::t('app', 'Announce'),
            'content' => Yii::t('app', 'Content'),
            'owner' => Yii::t('app', 'Owner'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'active' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner0()
    {
        return $this->hasOne(User::className(), ['id' => 'owner']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopicTags()
    {
        return $this->hasMany(TopicTags::className(), ['topic_id' => 'id']);
    }
    
    /**
    * Устанавлиает тэги поста.
    * @param $tagsId
    */
   public function setTags($tagsId)
   {
       $this->tags = (array) $tagsId;
   }
    
   /**
    * Возвращает массив идентификаторов тэгов.
    */
   public function getTags()
   {
       return ArrayHelper::getColumn(
           $this->getTopicTags()->all(), 'tag_id'
       );
   }
   
   /**
    * @inheritdoc
    */
   public function afterSave($insert, $changedAttributes)
   {
        TopicTags::deleteAll(['topic_id' => $this->id]);
        $values = [];
        foreach ($this->tags as $id) {
            $values[] = [$this->id, $id];
        }
        self::getDb()->createCommand()
            ->batchInsert(TopicTags::tableName(), ['topic_id', 'tag_id'], $values)->execute();
     
        parent::afterSave($insert, $changedAttributes);
   }
}
