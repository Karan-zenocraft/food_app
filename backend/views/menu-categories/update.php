<?php

/* @var $this yii\web\View */
/* @var $model common\models\MenuCategories */

$this->title = 'Update : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => 'Menu Categories', 'url' => ['index', 'rid' => $model->restaurant_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-categories-update email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
