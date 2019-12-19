<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantType */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
    </div>
    <div class="block-content collapse in">
<div class="restaurant-type-form span12 common_search">

    <?php $form = ActiveForm::begin();?>

    <div class="row">
    <div class="span3"><?=$form->field($model, 'type')->textInput(['maxlength' => true])?></div>
</div>
    <div class="row">
    <div class="span3"><?=$form->field($model, 'description')->textInput(['maxlength' => true])?></div>
</div>

    <div class="form-group form-actions">
        <?=Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
          <?=Html::a(Yii::t('app', 'Cancel'), Yii::$app->urlManager->createUrl(['restaurant-type/index']), ['class' => 'btn default'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
    </div>
</div>
