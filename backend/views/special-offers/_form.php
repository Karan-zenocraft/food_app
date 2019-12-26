<?php

use common\models\Restaurants;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SpecialOffers */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
    </div>
    <div class="block-content collapse in">
<div class="special-offers-form span12 common_search">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>
<div class="row">
    <div class="span3">
        <?php $restaurants = ArrayHelper::map(Restaurants::find()->orderBy('name')->asArray()->all(), 'id', 'name');?>
      <?php
//$val = explode(",", $model->restaurant_id);
/*p($restaurants, 0);
p($val);*/
$model->restaurant_id = explode(",", $model->restaurant_id);
echo $form->field($model, 'restaurant_id')->widget(Select2::classname(), [
    'value' => ['2' => 'american', '3' => 'asian', '4' => 'belgian'],
    'data' => $restaurants,
    'name' => 'restaurant_id',
    'options' => ['placeholder' => 'Choose Type', 'multiple' => true],
    'pluginOptions' => [
        'tags' => false,
        'tokenSeparators' => [',', ' '],
        'maximumInputLength' => 10,
    ],
]);?>
</div>
 <div class="span3">
    <?=$form->field($model, 'discount')->textInput()?>
</div>
</div>
<div class="row">
    <div class="span3">
    <?=$form->field($model, 'coupan_code')->textInput(['maxlength' => true])?>
</div>
<div class="span3 style_input_width">
    <?php $model->photo = Yii::$app->params['root_url'] . '/' . "uploads/restaurants_offers/" . $model->photo;?>
      <?=$form->field($model, 'photo')->fileInput(['id' => 'photo']);?>
</div>
</div>
<div class="row">
    <div class="span3">
      <?=$form->field($model, 'from_date')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'clientOptions' => ['minDate' => '0'], 'options' => ['class' => 'from_date']/*, 'clientOptions' => ['minDate'=>'0']*/])?>
</div>
 <div class="span3">
     <?=$form->field($model, 'to_date')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'clientOptions' => ['minDate' => '0'], 'options' => ['class' => 'to_date']/*, 'clientOptions' => ['minDate'=>'0']*/])?>
</div></div>
<div class="form-group form-actions">
        <?=Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
          <?=Html::a(Yii::t('app', 'Cancel'), Yii::$app->urlManager->createUrl(['special-offers/index']), ['class' => 'btn default'])?>
    </div>


    <?php ActiveForm::end();?>

</div>
    </div>
</div>

