<?php

use common\models\RestaurantType;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Restaurants */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
    </div>
    <div class="block-content collapse in">
<div class="restaurants-form span12 common_search">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>

    <div class="row">
    <div class="span3"><?=$form->field($model, 'name')->textInput(['maxlength' => true])?></div>
<?php $restaurant_types = ArrayHelper::map(Restauranttype::find()->orderBy('type')->asArray()->all(), 'id', 'type');?>
</div>
  <div class="row">
 <div class="span3">
    <?php
echo $form->field($model, 'restaurant_type')->widget(Select2::classname(), [
    'data' => $restaurant_types,
    'name' => 'restaurant_type',
    'options' => ['placeholder' => 'Choose Type', 'multiple' => true],
    'pluginOptions' => [
        'tags' => false,
        'tokenSeparators' => [',', ' '],
        'maximumInputLength' => 10,
    ],
]); ?>

 </div>
</div>
      <div class="row">
    <td colspan="4"><?=$form->field($model, 'description')->textarea(['rows' => 2])?>  </td>
 </div>

    <div class="row">

    <div class="span3"><?=$form->field($model, 'longitude')->textInput()?></div>
    <div class="span3"><?=$form->field($model, 'lattitude')->textInput()?></div>
</div>
<div class="row">
    <div class="span3"> <?=$form->field($model, 'address')->textInput(['maxlength' => true])?></div>

   <div class="span3"> <?=$form->field($model, 'website')->textInput(['maxlength' => true])?></div>
</div>

  <div class="row">
    <div class="span3">  <?=$form->field($model, 'contact_no')->textInput()?></div>

   <div class="span3">   <?=$form->field($model, 'avg_cost_for_two')->textInput()?></div>
</div>
     <div class="row">
    <div class="span3">
      <?=$form->field($model, 'photo')->fileInput(['id' => 'photo', 'value' => $model->photo]);?>
     </div>
   </div>
   <div class="row">
    <div class="span3">
    <img id="image" width="100px" hieght="100px" src="<?php echo Yii::getAlias('@web') . "../../frontend/web/uploads/" . $model->photo; ?>" alt="" />
    </div>
    </div>
<div class="row">
   <div class="span3"> <?=$form->field($model, 'email')->textInput(['maxlength' => true])?></div>
       <div class="span3"><?=$form->field($model, 'status')->dropDownList(Yii::$app->params['user_status']);?></div>
</div>
    <?php // echo $form->field($model, 'is_deleted')->dropDownList([1 => '1', 0 => '0'], ['prompt' => ''])?>

    <?php // echo $form->field($model, 'created_by')->textInput()?>

    <?php // echo $form->field($model, 'updated_by')->textInput()?>

    <?php // echo $form->field($model, 'created_at')->textInput()?>

    <?php // echo $form->field($model, 'updated_at')->textInput()?>


    <div class="form-group form-actions">
        <?=Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
          <?=Html::a(Yii::t('app', 'Cancel'), Yii::$app->urlManager->createUrl(['restaurants/index']), ['class' => 'btn default'])?>
    </div>

    <?php ActiveForm::end();?>
</div>
    </div>
</div>
