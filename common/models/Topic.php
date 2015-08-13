<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

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
 * @property integer $image
 * @property integer $created
 * @property integer $updated
 * @property integer $active
 *
 * @property TagTopic[] $tagTopics
 * @property User $owner0
 */
class Topic extends \yii\db\ActiveRecord
{
    
     /**
     * Список тэгов, закреплённых за постом.
     * @var array
     */
    protected $tags = [];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topic';
    }

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
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['h1', 'alias', 'title'], 'required'],
            [['announce', 'content'], 'string'],
            [['owner', 'image', 'created', 'updated', 'active'], 'integer'],
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
            'image' => Yii::t('app', 'Image'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'active' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagTopics()
    {
        return $this->hasMany(TagTopic::className(), ['topic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner0()
    {
        return $this->hasOne(User::className(), ['id' => 'owner']);
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
            $this->getTagTopics()->all(), 'tag_id'
        );
    }
    
    	public function beforeSave($insert)
        {
            if(parent::beforeSave($insert)) {
                // Проверяем если это новая запись.
                if ($this->isNewRecord) {
                    // Определяем автора в случае его отсутсвия.
                    if (!$this->owner) {
                        $this->owner = Yii::$app->user->identity->id;
                    }
                    if (!$this->title) {
                        $this->title = $this->h1;
                    }
                }
                return true;
            }
            return false;
        }
    
    
    public function afterSave($insert, $changedAttributes)
    {
        TagTopic::deleteAll(['topic_id' => $this->id]);
        if (is_array($this->tags) && !empty($this->tags)) {
            $values = [];
            foreach ($this->tags as $id) {
                $values[] = [$this->id, $id];
            }
            self::getDb()->createCommand()
            ->batchInsert(TagTopic::tableName(), ['topic_id', 'tag_id'], $values)->execute();
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
