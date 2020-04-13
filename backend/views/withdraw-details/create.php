<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WithdrawDetails */

$this->title = 'Create Withdraw Details';
$this->params['breadcrumbs'][] = ['label' => 'Withdraw Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
