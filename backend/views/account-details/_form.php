<?php

use common\components\Common;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AccountDetails */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
    </div>
    <div class="block-content collapse in">
<div class="account-details-form span12 common_search">

    <?php $form = ActiveForm::begin();?>

     <div class="row">
    <div class="span3">
    <?=$form->field($model, 'restaurant_id')->textInput(["value" => Common::get_name_by_id($_GET['rid'], "Restaurants"), 'disabled' => 'true'])?>
</div>
</div>
 <div class="row">
    <div class="span3">
    <?=$form->field($model, 'paypal_email')->textInput(['maxlength' => true])?>
</div>
</div>
 <div class="row">
    <div class="span3">
    <?=$form->field($model, 'stripe_bank_account_holder_name')->textInput(['maxlength' => true])?>
    </div>
</div>
 <div class="row">
    <div class="span3">
    <?=$form->field($model, 'stripe_bank_account_holder_type')->textInput(['maxlength' => true])?>
    </div>
</div>
 <div class="row">
    <div class="span3">
    <?=$form->field($model, 'stripe_bank_routing_number')->textInput()?>
    </div>
</div>
 <div class="row">
    <div class="span3">
    <?=$form->field($model, 'stripe_bank_account_number')->textInput()?>
    </div>
</div>
    <div class="form-group">
        <?=Html::submitButton('Save', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end();?>
</div>
    </div>
</div>
