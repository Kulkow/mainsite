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
use yii\behaviors\AttributeBehavior;

class SeoBehavior extends AttributeBehavior
{
    
    /*
    * от куда берються все значения
    **/
    public $SourceAttribute = 'h1';
    
    public $TitleAttribute = 'title';
    
    public $DescriptionAttribute = 'description';
    
    public $KeywordsAttribute = 'keywords';
    
    /**
     * @var callable|Expression The expression that will be used for generating the timestamp.
     * This can be either an anonymous function that returns the timestamp value,
     * or an [[Expression]] object representing a DB expression (e.g. `new Expression('NOW()')`).
     * If not set, it will use the value of `time()` to set the attributes.
     */
    public $value;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->TitleAttribute, $this->DescriptionAttribute, $this->KeywordsAttribute],
                BaseActiveRecord::EVENT_BEFORE_UPDATE => [$this->TitleAttribute, $this->DescriptionAttribute, $this->KeywordsAttribute],
            ];
        }
    }

    /**
     * @inheritdoc
     */
    protected function getValue($event)
    {
        print_R($event);
        print_R($this);
        exit();
        if ($this->value === null) {
            return $this->owner->{$this->SourceAttribute};
        } else {
            return call_user_func($this->value, $event);
        }
    }

}
