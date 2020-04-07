<?php

/* @var $this yii\web\View */
/* @var $model common\models\AccountDetails */

$this->title = 'Update Account Details: ' . $model->restaurant->name;
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => 'Account Details', 'url' => ['index'], 'rid' => $model->restaurant_id];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<style type="text/css">
    
.nav-list li:nth-child(4), .nav-list li:nth-child(4) a:hover{background: #006dcc;}
.nav-list li:nth-child(4) span, .nav-list li:nth-child(4) span:hover{color: #fff!important;}

</style>

<div class="account-details-update email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
