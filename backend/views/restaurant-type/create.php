<?php

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantType */

$this->title = 'Create Restaurant Type';
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurant Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-type-create email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
