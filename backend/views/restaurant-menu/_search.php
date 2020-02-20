<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantMenuSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="restaurant-menu-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index', 'rid' => $_GET['rid'], 'cid' => $_GET['cid']],
    'method' => 'get',
]);?>
<div class="row">
    <div class="span3 style_input_width">
    <?=$form->field($model, 'name')?>
</div></div>
<div class="row">
    <div class="span3 style_input_width">
    <?=$form->field($model, 'description')?>
    </div></div>
    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'photo') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?=Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
         <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['restaurant-menu/index', 'rid' => $_GET['rid'], 'cid' => $_GET['cid'], "temp" => "clear"]), ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
