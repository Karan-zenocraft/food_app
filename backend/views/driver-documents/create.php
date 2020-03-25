<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DriverDocuments */

$this->title = 'Create Driver Documents';
$this->params['breadcrumbs'][] = ['label' => 'Driver Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-documents-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
