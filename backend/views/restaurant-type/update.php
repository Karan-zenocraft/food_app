<?php

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantType */

$this->title = 'Update Restaurant Type: ' . $model->type;
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurant Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="restaurant-type-update email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
