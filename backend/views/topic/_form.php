<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model common\models\Topic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="topic-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'h1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'announce')->textarea(['rows' => 6]) ?>

    <?//= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    <?
    echo yii\imperavi\Widget::widget([
    'model' => $model,
    'attribute' => 'content',

    // or just for input field
    //'name' => 'content',

    // Some options, see http://imperavi.com/redactor/docs/
    /*'options' => [
        'toolbar' => false,
        'css' => 'wym.css',
    ],*/
]);
    ?>

    <?= $form->field($model, 'active')->checkbox() ?>
    
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'tags')->listBox(
        ArrayHelper::map($tags, 'id', 'tag'),
        [
                'multiple' => true
        ]
    ) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
