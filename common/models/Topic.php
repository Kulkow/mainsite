<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\behaviors\SeoBehavior;
use common\behaviors\UploadImage;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\helpers\Url;

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
    const STATUS_ACTIVE = 1;
    const STATUS_HIDE = 0;
     /**
     * Список тэгов, закреплённых за постом.
     * @var array
     */
    protected $tags = [];

    protected $category = NULL;
    
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
            'ownerBehavior'  =>[
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'owner',
                'updatedByAttribute' => 'editor',
            ],
            'SeoBehavior'  =>[
                'class' => SeoBehavior::className(),
            ],
            'UploadImage' => [
                'class' => UploadImage::className(),
                'attribute' => 'preview',
                'scenarios' => ['insert', 'update'],
                'path' => '@uploadroot/topic/{id}',
                'url' => '@upload/topic/{id}',
                'thumbPath' => '@uploadroot/topic/{id}/thumb',
                'thumbUrl' => '@upload/topic/{id}/thumb',
                'thumbs' => [
                    'big' => ['width' => 400, 'quality' => 90],
                    'small' => ['width' => 200, 'height' => 200],
                ],
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['h1'], 'required'],
            [['announce', 'content'], 'string'],
            [['owner','editor', 'image', 'created', 'updated', 'active', 'category_id'], 'integer'],
            [['h1', 'alias', 'keywords', 'description'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 90],
            [['alias'], 'unique'],
            [['tags'], 'safe'],
            [['preview'], 'file', 'extensions' => 'jpeg, jpg, bmp, png', 'on' => ['insert', 'update']],
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
            'preview' => Yii::t('app', 'Preview'),
            'category_id' => Yii::t('app', 'Category'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id' => 'id',
            'h1' => 'h1',
            'alias' => 'alias',
            'title' => 'title',
            'keywords' => 'keywords',
            'description' => 'description',
            'announce' => 'announce',
            'content' => 'content',
            'owner' => 'owner',
            'image' => 'image',
            'created' => 'created',
            'updated' => 'updated',
            'active' => 'active',
            'category_id' => 'category_id',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagTopics()
    {
        //return $this->hasMany(TagTopic::className(), ['topic_id' => 'id']);
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('tag_topic', ['topic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner']);
    }
    
    public function getEditor()
    {
        return $this->hasOne(User::className(), ['id' => 'editor']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }


    /**
     * @param null $action
     * @return string
     */
    public function url($action = null)
    {
        $action = 'topic'.($action ? '/'.$action : '');
        return Url::to([$action, 'id' => $this->id, 'alias' => $this->alias]);
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
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('tag_topic', ['topic_id' => 'id']);
    }
    
    /**
    * @ return array
    **/
    public function getTagsArray()
    {
        $sql = "SELECT
                tg.*,t.topic_id
                FROM tag as tg
                LEFT JOIN tag_topic as t ON t.tag_id=tg.id
                WHERE t.topic_id='".$this->id."'";
        return self::findBySql($sql)->asArray()->all();
    }
    
    public function getTopic($alias = null)
    {
        $topic = $this->findOne(['alias' => $alias]);
        if(null === $topic){
            return false;
        }
        $topic->tags;
        return $topic;
    }
    
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            // Проверяем если это новая запись.
            if ($this->isNewRecord) {
                // Определяем автора в случае его отсутсвия.
                //if (!$this->owner) {
                //    $this->owner = Yii::$app->user->identity->id;
                //}
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
