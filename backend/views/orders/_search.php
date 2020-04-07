<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrdersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]);?>

    <?php //$form->field($model, 'id')?>
<div class="row">

    <div class="span3">
    <?=$form->field($model, 'user_id')?>
</div>
</div>
<div class="row">

    <div class="span3">
    <?=$form->field($model, 'payment_type')->dropDownList(Yii::$app->params['payment_type_value']);?>
</div>
</div>
<div class="row">

    <div class="span3">
    <?=$form->field($model, 'total_amount')?>
</div>
</div>
<div class="row">

    <div class="span3">
    <?=$form->field($model, 'delivery_person')?>
</div>
</div>

    <?php //$form->field($model, 'delivery_charges')?>

    <?php // echo $form->field($model, 'other_charges') ?>

    <?php // echo $form->field($model, 'user_address_id') ?>
<div class="row">

    <div class="span3">
    <?php echo $form->field($model, 'status')->dropDownList(array("" => "") + Yii::$app->params['order_status_value']); ?>
</div>
</div>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

   <div class="form-group">
        <?=Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
        <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['orders/index', "temp" => "clear"]), ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
