<?php


/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = Yii::t('app/project', 'Update {modelClass}: ', [
    'modelClass' => 'Project',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/project', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app/project', 'Update');
?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
