<?php

/* @var $this yii\web\View */
/* @var $model common\models\Topic */

$this->title = Yii::t('app/topic', 'Create Topic');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/topic', 'Topics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
