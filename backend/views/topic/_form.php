<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\tree\TreeViewInput;
use common\models\Category;


/* @var $this yii\web\View */
/* @var $model common\models\Topic */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="box-body">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_about" data-toggle="tab"><? echo Yii::t("app","About")?></a></li>
            <li><a href="#tab_picture" data-toggle="tab"><? echo Yii::t("app","Picture")?></a></li>
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
                <?= $form->field($model, 'h1')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'announce')->textarea(['rows' => 6]) ?>
                <?
                echo yii\imperavi\Widget::widget([
                'model' => $model,
                'attribute' => 'content',
                ]);
                ?>
                <?= TreeViewInput::widget([
                    'query' => Category::find()->addOrderBy('root, lft'),
                    'model' => $model,
                    'attribute' => 'category_id',
                    'headingOptions'=>['label'=> Yii::t('app','Category')],
                    'asDropdown' => true,   // will render the tree input widget as a dropdown.
                    'multiple' => false,     // set to false if you do not need multiple selection
                    'fontAwesome' => true,  // render font awesome icons
                    'rootOptions' => [
                    'label'=>'<i class="fa fa-tree"></i>',  // custom root label
                    'class'=>'text-success'
                    ],
                ]); ?>
                <?= $form->field($model, 'tags')->listBox(
                    ArrayHelper::map($tags, 'id', 'tag'),['multiple' => true]
                ) ?>
                <?= $form->field($model, 'active')->checkbox() ?>
            </div>
            <div class="tab-pane" id="tab_picture">
                <? if($model->preview): ?>
                    <?= Html::img($model->getThumbUploadUrl('preview', 'small'), ['class' => 'img-thumbnail']) ?>
                <?php endif ?>
                <?= $form->field($model, 'preview')->fileInput(['accept' => 'image/*']) ?>
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
<?php ActiveForm::end(); ?>

