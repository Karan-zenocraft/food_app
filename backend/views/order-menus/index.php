<?php

use common\components\Common;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderMenusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-menus-index email-format-index">
 <div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Order's Menu Items</div>
    </div>
</div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        //'id',
        // 'order_id',
        [
            'attribute' => 'restaurant_id',
            'value' => function ($data) {
                return $data->restaurant->name;
            },
        ],
        [
            'attribute' => 'menu_id',
            'value' => function ($data) {
                return $data->menu->name;
            },
        ],
        'quantity',
        //'price',
        //'menu_total',
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
