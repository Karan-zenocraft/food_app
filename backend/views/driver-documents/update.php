<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DriverDocuments */

$this->title = 'Update Driver Documents: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Driver Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="driver-documents-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
