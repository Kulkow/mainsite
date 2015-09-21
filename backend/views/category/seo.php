<?
use kartik\form\ActiveForm;
use kartik\tree\Module;
use kartik\tree\TreeView;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\Select2;
?>
<div class="row">
    <div class="col-sm-4">
        <?=$form->field($node, 'alias')->textInput() ?>
        <?=$form->field($node, 'h1')->textInput() ?>
    </div>
    <div class="col-sm-8">
        
        <?=$form->field($node, 'title')->textInput() ?>
        <?=$form->field($node, 'description')->textInput() ?>
        <?=$form->field($node, 'keywords')->textInput() ?>
    </div>
</div>