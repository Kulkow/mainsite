<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app/user', 'Update {modelClass}: ', [
    'modelClass' => 'User',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app/user', 'Update');
?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <?= $this->render('_form', [
                'model' => $model,
                'profile' => $profile
            ]) ?>
        </div>
    </div>
</div>
