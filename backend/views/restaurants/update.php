<?php

/* @var $this yii\web\View */
/* @var $model common\models\Restaurants */

$this->title = 'Update Restaurant: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="restaurants-update email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
    'restaurantTypes' => $restaurantTypes,

])?>

</div>