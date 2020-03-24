<?php

/* @var $this yii\web\View */
/* @var $model common\models\AccountDetails */

$this->title = 'Update Account Details: ' . $model->restaurant->name;
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => 'Account Details', 'url' => ['index'], 'rid' => $model->restaurant_id];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="account-details-update email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
