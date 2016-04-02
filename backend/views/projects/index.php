<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/project', 'Projects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <?= Html::a(Yii::t('app/project', 'Create Project'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-bordered table-hover', 'id' => 'topic-table'],
                'options' => ['class' => 'grid-view box-body'],
                'columns' => [
                    ['label' => Yii::t('app', 'Picture'),
                        'format' => 'raw',
                        'value' => function($model){
                            if(! empty($model->preview)) {
                                return Html::img($model->getThumbUploadUrl('preview', 'small'), ['class' => 'img-thumbnail', 'style' => 'width:50px']);
                            }
                        },
                    ],
                    'name',
                    'alias',
                    ['class' => 'common\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
