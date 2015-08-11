<?php

namespace common\behaviors;

//use dosamigos\helpers\TransliteratorHelper;
use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;


class Alias extends Behavior
{
    public $in_attribute = 'name';
    public $out_attribute = 'alias';
    public $translit = true;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'getAlias'
        ];
    }
    
    public function getAlias( $event )
    {
        if ( empty( $this->owner->{$this->out_attribute} ) ) {
            $this->owner->{$this->out_attribute} = $this->generateAlias( $this->owner->{$this->in_attribute} );
        } else {
            $this->owner->{$this->out_attribute} = $this->generateAlias( $this->owner->{$this->out_attribute} );
        }
    }
    
    private function generateAlias( $alias )
    {
        $alias = $this->slugify( $alias );
        if ( $this->checkUniqueAlias( $alias ) ) {
            return $alias;
        } else {
            for ( $suffix = 2; !$this->checkUniqueAlias( $new_alias = $alias . '-' . $suffix ); $suffix++ ) {}
            return $new_alias;
        }
    }
    
    private function slugify( $alias )
    {
        if ( $this->translit ) {
            //return yii\helpers\Inflector::slug( TransliteratorHelper::progress( $alias ), '-', true );
            //return yii\helpers\Inflector::slug( yii\helpers\Inflector::transliterate( $alias ), '-', true );
            return Inflector::slug($alias);
        } else {
            return $this->alias( $alias, '-', true );
        }
    }
    
    private function alias( $string, $replacement = '-', $lowercase = true )
    {
        $string = preg_replace( '/[^\p{L}\p{Nd}]+/u', $replacement, $string );
        $string = trim( $string, $replacement );
        return $lowercase ? strtolower( $string ) : $string;
    }
    
    private function checkUniqueAlias( $alias )
    {
        $pk = $this->owner->primaryKey();
        $pk = $pk[0];
    
        $condition = $this->out_attribute . ' = :out_attribute';
        $params = [ ':out_attribute' => $alias ];
        if ( !$this->owner->isNewRecord ) {
            $condition .= ' and ' . $pk . ' != :pk';
            $params[':pk'] = $this->owner->{$pk};
        }
    
        return !$this->owner->find()
            ->where( $condition, $params )
            ->one();
    }
}