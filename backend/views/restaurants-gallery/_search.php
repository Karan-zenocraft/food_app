<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantsGallerySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="restaurants-gallery-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index','rid'=>$_GET['rid']],
        'method' => 'get',
      /*  'options' => [
            'data-pjax' => 1
        ],*/
    ]); ?>

    <?php // $form->field($model, 'id') ?>

    <?php // $form->field($model, 'restaurant_id') ?>
   <div class="row">
   <div class="span3"><?= $form->field($model, 'image_title') ?></div>
   <div class="span3"><?= $form->field($model, 'image_description') ?></div>
   <div class="span3"><?= $form->field($model, 'status')->dropDownList(Yii::$app->params['user_status']);?></div>
   </div>
        
   

    <?php // $form->field($model, 'image_name') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
         <?= Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['restaurants-gallery/index','rid'=>$_GET['rid'],"temp"=>"clear"]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
