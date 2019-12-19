<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantTypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="restaurant-type-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]);?>
<div class="row">

    <div class="span3">

    <?=$form->field($model, 'type')?>
</div>
</div>
<div class="row">

    <div class="span3">
    <?=$form->field($model, 'description')?>
    </div>
</div>

   <div class="form-group">
        <?=Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
        <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['restaurant-type/index', "temp" => "clear"]), ['class' => 'btn btn-default'])?>
    </div>
    <?php ActiveForm::end();?>

</div>
