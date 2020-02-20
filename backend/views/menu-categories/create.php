<?php

/* @var $this yii\web\View */
/* @var $model common\models\MenuCategories */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => 'Manu Categories', 'url' => ['index', 'rid' => $_GET['rid']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-categories-create email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
