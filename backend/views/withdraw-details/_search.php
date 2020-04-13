<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WithdrawDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="withdraw-details-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index', 'uid' => $_GET['uid']],
    'method' => 'get',
]);?>

    <?php //$form->field($model, 'id')?>

    <?php // $form->field($model, 'user_id')?>
<div class="row">
    <div class="span3">
    <?=$form->field($model, 'amount')?>
</div>
</div>
<div class="row">
<div class="span3">
    <?=$form->field($model, 'transfer_id')?>
</div>
</div>
<div class="row">
    <div class="span3">
<?=$form->field($model, 'created_at')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'from_date']/*, 'clientOptions' => ['minDate'=>'0']*/])->label('Date')?>
</div>
</div>
    <?php // echo $form->field($model, 'updated_at') ?>

   <div class="form-group">
        <?=Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
         <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['withdraw-details/index', 'uid' => $_GET['uid'], "temp" => "clear"]), ['class' => 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
