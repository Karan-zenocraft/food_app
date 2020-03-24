<?php

/* @var $this yii\web\View */
/* @var $model common\models\AccountDetails */

$this->title = 'Create Account Details';
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => 'Account Details', 'url' => ['index'], 'rid' => $_GET['rid']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-details-create email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
