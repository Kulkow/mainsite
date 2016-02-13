<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel common\models\TopicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/topic', 'Topics');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <?= Html::a(Yii::t('app/topic', 'Create Topic'), ['create'], ['class' => 'btn btn-success']) ?>
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
                'h1',
                'alias',
                ['attribute'=>'category_id',
                'label'=> Yii::t('app', 'Category'),
                'format'=>'text',
                'content' => function($model){
                    $category = $model->category;
                    return $category->title;
                },
                ],
                ['class' => 'common\grid\ActionColumn'],
            ],
        ]); ?>
        </div>
    </div>
</div>

