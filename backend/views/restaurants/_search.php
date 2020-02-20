<?php

use common\models\RestaurantType;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="restaurants-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    /*'options' => [
'data-pjax' => 1
],*/
]);?>
        <?php //echo $form->field($model, 'id')?>

    <div class="row">

    <div class="span3"><?=$form->field($model, 'name')?></div>

    <div class="span3"><?=$form->field($model, 'description')?></div>

     <div class="span3"><?=$form->field($model, 'restaurant_type')->dropDownList(array("" => "") + RestaurantType::RestaurantTypesDropdown());?></div>
</div>

    <div class="row">
    <div class="span3"><?=$form->field($model, 'address')?></div>

    <?php // echo $form->field($model, 'lattitude') ?>

    <?php // echo $form->field($model, 'longitude') ?>

   <div class="span3"> <?php echo $form->field($model, 'website') ?></div>

    <div class="span3"><?php echo $form->field($model, 'contact_no') ?></div>
</div>
    <?php // echo $form->field($model, 'photo') ?>
 <div class="row">
    <div class="span3"><?php echo $form->field($model, 'avg_cost_for_two') ?></div>

     <div class="span3"><?php echo $form->field($model, 'status') ?></div>
 </div>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'email') ?>

   <div class="form-group">
        <?=Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
        <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['restaurants/index', "temp" => "clear"]), ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
