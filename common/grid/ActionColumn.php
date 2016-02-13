<?php
/**
 * Created by PhpStorm.
 * User: Игорёк
 * Date: 13.02.2016
 * Time: 0:06
 */
namespace common\grid;
use yii;
use Closure;
use yii\helpers\Html;
use yii\helpers\Url;

class ActionColumn extends yii\grid\ActionColumn
{
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => Yii::t('yii', 'View'),
                    'aria-label' => Yii::t('yii', 'View'),
                    'data-pjax' => '0',
                    'class' => 'fa fa-fw fa-eye'
                ], $this->buttonOptions);
                return Html::a('', $url, $options);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => Yii::t('yii', 'Update'),
                    'aria-label' => Yii::t('yii', 'Update'),
                    'data-pjax' => '0',
                    'class' => 'fa fa-fw fa-edit'
                ], $this->buttonOptions);
                return Html::a('', $url, $options);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => Yii::t('yii', 'Delete'),
                    'aria-label' => Yii::t('yii', 'Delete'),
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                    'class' => 'fa fa-fw fa-remove'
                ], $this->buttonOptions);
                return Html::a('', $url, $options);
            };
        }
    }
}