<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Topic */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Topics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'h1',
            'alias',
            'title',
            'keywords',
            'description',
            'announce:ntext',
            'content:ntext',
            'owner',
            'created',
            'updated',
            'active',
        ],
    ]) ?>
    <div class="tags">
        Тэги: <?php foreach($model->getTopicTags()->all() as $post) : ?>
            <?= $post->getTag()->one()->title ?>
        <?php endforeach; ?>
    </div>

</div>
