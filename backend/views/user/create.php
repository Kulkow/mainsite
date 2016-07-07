<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app/user', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <?php $form = ActiveForm::begin(); ?>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <?= $form->field($model, 'username')->textInput() ?>
                    <?= $form->field($model, 'email')->textInput() ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <?php //= $form->field($model, 'role')->dropDownList($roles) ?>
                    <?php //= $form->field($model, 'status')->dropDownList($statuses) ?>
                    <div class="box-footer">
                        <?= Html::submitButton(Yii::t('app/user', 'Create'), ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
