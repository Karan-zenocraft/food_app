<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FeedbackSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="feedbacks-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index', 'rid' => $_GET['rid']],
    'method' => 'get',
    'options' => [
        'data-pjax' => 1,
    ],
]);?>
<div class="row">
    <div class="span3 style_input_width">
    <?=$form->field($model, 'user_id')?>
</div>
</div>
<div class="row">
    <div class="span3 style_input_width">
    <?=$form->field($model, 'rating')?>
</div>
</div>
    <div class="row">
    <div class="span3 style_input_width">
    <?=$form->field($model, 'review_note')?>
</div>
</div>
    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?=Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
         <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['feedbacks/index', 'rid' => $_GET['rid'], "temp" => "clear"]), ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
