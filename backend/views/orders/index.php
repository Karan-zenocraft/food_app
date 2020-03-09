<?php

use common\components\Common;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index  email-format-index">
      <div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Search Here</div>
    </div>
        <div class="block-content collapse in">
        <div class="tags-form span12">

     <?=Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'), "javascript:void(0);", ['class' => 'btn btn-primary open_search']);?>
     <?php if (!empty($_REQUEST['OrdersSearch']) || (!empty($_GET['temp']) && $_GET['temp'] == "clear")) {?>
        <div class="orderss-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
<?php } else {?>
    <div class="orders-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    <?php }?>
</div>
</div>
</div>
<div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
        <?php $user_role = Common::get_user_role(Yii::$app->user->id, $flag = 0);

if ($user_role == Yii::$app->params['userroles']['super_admin']) {?>

        <div class="pull-right">
       </div>
<?php }
?>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
  <div class="block-content">
        <div class="goodtable">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

//        'id',
        [
            'attribute' => 'user_id',
            'value' => function ($data) {
                return $data->user->user_name;
            },
        ],
        [
            'attribute' => 'payment_type',
            'value' => function ($data) {
                return Yii::$app->params['payment_type_value'][$data->payment_type];
            },
        ],
        'total_amount',
        'delivery_charges',
        'other_charges',
        [
            'attribute' => 'user_address_id',
            'value' => function ($data) {
                return $data->userAddress->address;
            },
        ],
        [
            'label' => 'transaction_id',
            'value' => 'orderPayments.transaction_id',
        ],
        [
            'attribute' => 'status',
            'value' => function ($data) {
                return Yii::$app->params['order_status_value'][$data->status];
            },
        ],
        //'created_at',
        //'updated_at',
        [
            'header' => 'Actions',
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ["style" => "width:40%;"],
            'contentOptions' => ["style" => "width:40%;"],
            'template' => '{view_menu_items}',
            'buttons' => [

                'view_menu_items' => function ($url, $model) {
                    $title = "View menu Items";
                    $flag = 1;
                    $url = Yii::$app->urlManager->createUrl(['order-menus/index', 'order_id' => $model->id]);
                    return Common::template_view_menu_items($url, $model, $title, $flag);

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
    $('.orders-serach').hide();
        $('.open_search').click(function(){
            $('.orders-serach').toggle();
        });
    });
</script>