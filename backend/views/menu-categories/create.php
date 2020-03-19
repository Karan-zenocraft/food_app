<?php

/* @var $this yii\web\View */
/* @var $model common\models\MenuCategories */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => 'Manu Categories', 'url' => ['index', 'rid' => $_GET['rid']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    
.nav-list li:nth-child(4), .nav-list li:nth-child(4) a:hover{background: #006dcc;}
.nav-list li:nth-child(4) span, .nav-list li:nth-child(4) span:hover{color: #fff!important;}

</style>
<div class="menu-categories-create email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
