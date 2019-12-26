<?php

/* @var $this yii\web\View */
/* @var $model common\models\SpecialOffers */

$this->title = 'Create Special Offer';
$this->params['breadcrumbs'][] = ['label' => 'Manage Special Offers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="special-offers-create email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
