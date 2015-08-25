<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\behaviors;

use yii\base\InvalidCallException;
use yii\db\BaseActiveRecord;
use yii\db\Expression;
use yii\base\Behavior;

class SeoBehavior extends Behavior
{
    
    /*
    * от куда берються все значения
    **/
    public $SourceAttribute = 'h1';
    public $TitleAttribute = 'title';
    public $DescriptionAttribute = 'description';
    public $KeywordsAttribute = 'keywords';
    
    
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'BeforeInsert',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'BeforeUpdate'
        ];
    }
    
    public function BeforeInsert($event)
    {
        if (empty($this->owner->{$this->TitleAttribute})) {
            $this->owner->{$this->TitleAttribute} = $this->owner->{$this->SourceAttribute};
        }
        if (empty($this->owner->{$this->DescriptionAttribute})) {
            $this->owner->{$this->DescriptionAttribute} = $this->owner->{$this->SourceAttribute};
        }
        if (empty($this->owner->{$this->KeywordsAttribute})) {
            $this->owner->{$this->KeywordsAttribute} = $this->owner->{$this->SourceAttribute};
        }
    }

    public function BeforeUpdate($event)
    {
        if (empty($this->owner->{$this->TitleAttribute})) {
            $this->owner->{$this->TitleAttribute} = $this->owner->{$this->SourceAttribute};
        }
        if (empty($this->owner->{$this->DescriptionAttribute})) {
            $this->owner->{$this->DescriptionAttribute} = $this->owner->{$this->SourceAttribute};
        }
        if (empty($this->owner->{$this->KeywordsAttribute})) {
            $this->owner->{$this->KeywordsAttribute} = $this->owner->{$this->SourceAttribute};
        }
    }
    

}
