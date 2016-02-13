<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tags');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <?= Html::a(Yii::t('app', 'Create Tag'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-bordered table-hover', 'id' => 'topic-table'],
                    'options' => ['class' => 'grid-view box-body'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        'tag',
                        'alias',
                        ['label' => Yii::t('app', 'Active'),
                         'format'=>'text',
                         'value' => function($model){
                             return $model->active ? Yii::t('app','Active') : Yii::t('app','NoActive');
                         }
                        ],
                        ['class' => 'common\grid\ActionColumn'],
                    ],
                ]); ?>
        </div>
    </div>
</div>
