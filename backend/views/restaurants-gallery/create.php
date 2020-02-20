<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantsGallery */

$this->title = "Add Photo - ".$snRestaurantName;
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants Gallery', 'url' => ['restaurants-gallery/index','rid'=>$_GET['rid']]];
$this->params['breadcrumbs'][] = ['label' => $snRestaurantName];

?>
<div class="restaurants-gallery-create email-format-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
