<?php

/* @var $this yii\web\View */
/* @var $model common\models\Restaurants */
$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Restaurant',
]);
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurants-create email-format-create">

    <?=$this->render('_form', [
    'model' => $model,
])?>

</div>
