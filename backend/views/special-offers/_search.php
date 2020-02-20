<?php

use common\models\Restaurants;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\SpecialOffersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="special-offers-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]);?>
<div class="row">

    <div class="span3">
    <?=$form->field($model, 'restaurant_id')->dropDownList(array("" => "") + Restaurants::RestaurantsDropdown());?>
    </div>
<div class="span3">
    <?=$form->field($model, 'discount')?>
</div>
    <div class="span3">
    <?=$form->field($model, 'coupan_code')?>
</div>
</div>
<div class="row">
<div class="span3">
      <?=$form->field($model, 'from_date')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'from_date']/*, 'clientOptions' => ['minDate'=>'0']*/])?>
</div>
<div class="span3">
     <?=$form->field($model, 'to_date')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'to_date']/*, 'clientOptions' => ['minDate'=>'0']*/])?>
</div>
</div>
    <?php //echo $form->field($model, 'photo')?>



    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

     <div class="form-group">
        <?=Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
        <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['special-offers/index', "temp" => "clear"]), ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
