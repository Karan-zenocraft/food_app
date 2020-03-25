<?php

use common\models\Restaurants;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
    </div>
    <div class="block-content collapse in">
<div class="users-form span12 common_search">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>
<div class="row">
                <div class="span3 style_input_width">
     <div class="span3 style_input_width"><?=$form->field($model, 'role_id')->dropDownList($UserRolesDropdown, ['class' => 'roles'])?></div>
</div>
 <div class="span3 style_input_width">
    <?=$form->field($model, 'user_name')->textInput(['maxlength' => true])?>
</div>
</div>
<div class="row">
                <div class="span3 style_input_width">
    <?=$form->field($model, 'email')->textInput(['maxlength' => true])?>
</div>
 <?php if ($model->isNewRecord) {?>
<div class="span3 style_input_width">
    <?=$form->field($model, 'password')->passwordInput(['maxlength' => true])?>
</div>
<?php }?>
</div>
<div class="row">
                <div class="span3 style_input_width">
    <?=$form->field($model, 'phone')->textInput()?>
</div>
 <div class="span3 style_input_width">
     <?=$form->field($model, 'status')->dropDownList(Yii::$app->params['user_status']);?></div>
</div>

<div class="row">
<div class="span3 style_input_width">
      <?=$form->field($model, 'photo')->fileInput(['id' => 'photo', 'value' => $model->photo]);?>
</div>
   <div class="span3 style_input_width">
    <?=$form->field($model, 'restaurant_id')->dropDownList(array("" => "") + Restaurants::RestaurantsDropdown())?>
  </div>
</div>
      <div class="row">
<div class="span3 style_input_width">
    <img id="image" width="100px" hieght="100px" src="<?php echo ($model->login_type == "1") ? Yii::$app->params['root_url'] . '/' . "uploads/" . $model->photo : $model->photo; ?>" alt="" />
    </div>

  </div>
    <div class="form-group">
        <?=Html::submitButton('Save', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
</div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript">
 $( document ).ready(function(){
    if($("#users-role_id").val() == 2){
      $(".field-users-restaurant_id").show();
  }else{
      $(".field-users-restaurant_id").hide();
  }
  $('#users-role_id').change(function() {
    var role_id = $(this).val();
    if(role_id == 2){
      $(".field-users-restaurant_id").show();
    }else{
      $(".field-users-restaurant_id").hide();
    }
  });
        $("#photo").change(function() {
        readURL(this);
        });
    });
    function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#image').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}
</script>