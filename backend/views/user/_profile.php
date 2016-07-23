<?php $form = ActiveForm::begin(['action' => $model->url('update'),'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); ?>
<?= $form->field($model, 'username', $horizontalOptions)->textInput() ?>
<?= $form->field($model, 'email',$horizontalOptions)->textInput() ?>
<?= $form->field($model, 'preview', $horizontalOptions)->fileInput(['accept' => 'image/*']) ?>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton(Yii::t('app/user', 'Update'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>