<?php

/* @var $this yii\web\View */
/* @var $model common\models\Topic */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Topic',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/topic', 'Topics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
        <?= $this->render('_form', [
            'model' => $model,
            'tags' => $tags,
        ]) ?>
        </div>
    </div>
</div>
