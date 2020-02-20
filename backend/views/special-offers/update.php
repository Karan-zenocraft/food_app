<?php

/* @var $this yii\web\View */
/* @var $model common\models\SpecialOffers */

$this->title = 'Update Special Offers: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Special Offers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="special-offers-update email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
