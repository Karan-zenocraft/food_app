<?php
use common\components\Common;
/* @var $this yii\web\View */
/* @var $model common\models\RestaurantMenu */
$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => 'Manu Categories', 'url' => ['menu-categories/index', 'rid' => $_GET['rid']]];
$this->params['breadcrumbs'][] = ['label' => Common::get_name_by_id($_GET['cid'], "MenuCategories"), "url" => "#"];
$this->params['breadcrumbs'][] = ['label' => 'Restaurant Menus', 'url' => ['index', 'rid' => $_GET['rid'], 'cid' => $_GET['cid']]];
$this->params['breadcrumbs'][] = $this->title
?>
<style type="text/css">
    
.nav-list li:nth-child(4), .nav-list li:nth-child(4) a:hover{background: #006dcc;}
.nav-list li:nth-child(4) span, .nav-list li:nth-child(4) span:hover{color: #fff!important;}

</style>

<div class="restaurant-menu-create email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
