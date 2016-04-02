<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\behaviors\SeoBehavior;
use common\behaviors\UploadImage;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property integer $created
 * @property integer $updated
 * @property integer $owner
 * @property string $announce
 * @property string $content
 *
 * @property User $owner0
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }

    public function behaviors()
    {
        return [
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
            ],/*
            'ownerBehavior'  =>[
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'owner',
                'updatedByAttribute' => 'owner',
            ],*/
            'SeoBehavior'  =>[
                'class' => SeoBehavior::className(),
                'SourceAttribute' => 'name'
            ],
            'UploadImage' => [
                'class' => UploadImage::className(),
                'attribute' => 'preview',
                'scenarios' => ['insert', 'update'],
                'path' => '@uploadroot/project/{id}',
                'url' => '@upload/project/{id}',
                'thumbPath' => '@uploadroot/project/{id}/thumb',
                'thumbUrl' => '@upload/project/{id}/thumb',
                'thumbs' => [
                    'big' => ['width' => 600, 'quality' => 90],
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
            [['name'], 'required'],
            [['announce', 'content'], 'string'],
            [['owner', 'created', 'updated', 'active', 'category_id', 'company_id'], 'integer'],
            [['name', 'alias', 'keywords', 'description'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 90],
            [['alias'], 'unique'],
            [['preview'], 'file', 'extensions' => 'jpeg, jpg, bmp, png', 'on' => ['insert', 'update']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'alias' => 'alias',
            'title' => 'title',
            'keywords' => 'keywords',
            'description' => 'description',
            'announce' => 'announce',
            'content' => 'content',
            'owner' => 'owner',
            'preview' => 'preview',
            'created' => 'created',
            'updated' => 'updated',
            'active' => 'active',
            'category_id' => 'category_id',
            'company_id' => 'company_id',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app/project', 'Name'),
            'alias' => Yii::t('app', 'Alias'),
            'title' => Yii::t('app', 'Title'),
            'keywords' => Yii::t('app', 'Keywords'),
            'description' => Yii::t('app', 'Description'),
            'announce' => Yii::t('app/project', 'Announce'),
            'content' => Yii::t('app/project', 'Content'),
            'owner' => Yii::t('app/project', 'Owner'),
            'image' => Yii::t('app/project', 'Image'),
            'created' => Yii::t('app/project', 'Created'),
            'updated' => Yii::t('app/project', 'Updated'),
            'active' => Yii::t('app/project', 'Active'),
            'preview' => Yii::t('app/project', 'Preview'),
            'category_id' => Yii::t('app', 'Category'),
        ];
    }

    /**
     * @param null $action
     * @return string
     */
    public function url($action = null)
    {
        $action = 'project'.($action ? '/'.$action : '');
        return Url::to([$action, 'id' => $this->id, 'alias' => $this->alias]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner']);
    }
}
