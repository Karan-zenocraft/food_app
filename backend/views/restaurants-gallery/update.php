<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantsGallery */
$this->title = "Update Photo - ".$snRestaurantName;
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants Gallery', 'url' => ['restaurants-gallery/index','rid'=>$_GET['rid']]];
$this->params['breadcrumbs'][] = ['label' => $snRestaurantName];
?>
<style type="text/css">
    
.nav-list li:nth-child(4), .nav-list li:nth-child(4) a:hover{background: #006dcc;}
.nav-list li:nth-child(4) span, .nav-list li:nth-child(4) span:hover{color: #fff!important;}

</style>
<div class="restaurants-gallery-update email-format-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
