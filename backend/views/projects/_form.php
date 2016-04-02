<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="box-body">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_about" data-toggle="tab"><? echo Yii::t("app","About")?></a></li>
            <li><a href="#tab_category" data-toggle="tab"><? echo Yii::t("app","Category")?></a></li>
            <li><a href="#tab_picture" data-toggle="tab"><? echo Yii::t("app","Picture")?></a></li>
            <li><a href="#tab_company" data-toggle="tab"><? echo Yii::t("app","Company")?></a></li>
            <li><a href="#tab_history" data-toggle="tab"><? echo Yii::t("app","History")?></a></li>
            <li><a href="#tab_seo" data-toggle="tab"><? echo Yii::t("app","Seo")?></a></li>
            <?php if(! $model->isNewRecord): ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <? echo Yii::t("app","Actions")?><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $model->url('delete') ?>"><? echo Yii::t("app","Delete")?></a></li>
                    </ul>
                </li>
            <? endif?>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_about">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'announce')->textarea(['rows' => 3]) ?>
                <?= yii\imperavi\Widget::widget([
                    'model' => $model,
                    'attribute' => 'content',
                ]);?>
            </div>
            <div class="tab-pane" id="tab_category">
            </div>
            <div class="tab-pane" id="tab_picture">
                <? if($model->preview): ?>
                    <?= Html::img($model->getThumbUploadUrl('preview', 'small'), ['class' => 'img-thumbnail']) ?>
                <?php endif ?>
                <?= $form->field($model, 'preview')->fileInput(['accept' => 'image/*']) ?>
            </div>
            <div class="tab-pane" id="tab_company">
            </div>
            <div class="tab-pane" id="tab_history">
            </div>
            <div class="tab-pane" id="tab_seo">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

