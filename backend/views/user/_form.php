<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="box-body">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_about" data-toggle="tab"><?php echo Yii::t("app","About")?></a>
            </li>
            <li>
                <a href="#tab_profile" data-toggle="tab"><?php echo Yii::t("app","Profile")?></a>
            </li>
            <li>
                <a href="#tab_picture" data-toggle="tab"><?php echo Yii::t("app","Picture")?></a>
            </li>
            <?php if(! $model->isNewRecord): ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php echo Yii::t("app","Actions")?><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?php echo $model->url('delete') ?>"><?php echo Yii::t("app","Delete")?></a>
                        </li>
                    </ul>
                </li>
            <?php endif?>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_about">
                <?php echo $form->field($model, 'username')->textInput() ?>
                <?php echo $form->field($model, 'email')->textInput() ?>
                <?php //= $form->field($model, 'role')->dropDownList($roles) ?>
                <?php //= $form->field($model, 'status')->dropDownList($statuses) ?>
            </div>
            <div class="tab-pane" id="tab_profile">
                <?php  echo $form->field($profile, 'fio')->textInput() ?>
                <?php  echo $form->field($profile, 'profile')->textarea() ?>
                <?php  echo $form->field($profile, 'gender')->dropDownList([1 => 'M', 2 => 'W']) ?>
            </div>
            <div class="tab-pane" id="tab_picture">
                <?php if($model->preview): ?>
                    <?= Html::img($model->getThumbUploadUrl('preview', 'small'), ['class' => 'img-thumbnail']) ?>
                <?php endif ?>
                <?= $form->field($model, 'preview')->fileInput(['accept' => 'image/*']) ?>
            </div>
        </div>
        <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app/user', 'Create') : Yii::t('app/user', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
