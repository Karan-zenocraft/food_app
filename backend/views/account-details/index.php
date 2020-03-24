<?php

use common\components\Common;
use common\models\AccountDetails;
use yii\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AccountDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Account Details';
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => Common::get_name_by_id($_GET['rid'], "Restaurants")];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-details-index email-format-index">
     <div class="email-format-index">

</div>
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
        <div class="pull-right">
            <?php
$accountDetails = AccountDetails::find()->where(['restaurant_id' => $_GET['rid']])->one();
if (empty($accountDetails)) {?>

            <?=Html::a(Yii::t('app', '<i class="icon-plus"></i> Add Account Details'), ['create', 'rid' => $_GET['rid']], ['class' => 'btn btn-success'])?>
        <?php }?>
            <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['account-details/index']), ['class' => 'btn btn-primary'])?>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
    <div class="block-content">
        <div class="goodtable">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        //'id',
        [
            'attribute' => 'restaurant_id',
            'filterOptions' => ["style" => "width:13%;"],
            'headerOptions' => ["style" => "width:13%;"],
            'contentOptions' => ["style" => "width:13%;"],
            'value' => function ($data) {
                return !empty($data->restaurant_id) ? $data->restaurant->name : "";
            },
        ],
        'paypal_email:email',
        'stripe_bank_account_holder_name',
        'stripe_bank_account_holder_type',
        //'stripe_bank_routing_number',
        //'stripe_bank_account_number',
        //'stripe_bank_token',
        //'stripe_connect_account_id',
        //'stripe_bank_accout_id',
        //'created_at',
        //'updated_at',

        [
            'header' => 'Actions',
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ["style" => "width:40%;"],
            'contentOptions' => ["style" => "width:40%;"],
            'template' => '{update}',
            'buttons' => [
                'update' => function ($url, $model) {
                    $flag = 1;
                    $url = Yii::$app->urlManager->createUrl(['account-details/update', "rid" => $_GET['rid'], 'id' => $model->id]);
                    return Common::template_update_button($url, $model, $flag);
                },

            ],
        ],
    ],
]);?>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
    $('.account-details-serach').hide();
        $('.open_search').click(function(){
            $('.account-details-serach').toggle();
        });
    });

</script>
