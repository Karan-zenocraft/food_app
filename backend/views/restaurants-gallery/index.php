<?php

use common\components\Common;
use yii\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel common\models\RestaurantsGallerySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Restaurant Gallery';
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants Gallery', 'url' => ['restaurants-gallery/index', 'rid' => $_GET['rid']]];
$this->params['breadcrumbs'][] = ['label' => $snRestaurantName];

?>
<div class="restaurants-gallery-index email-format-index">
    <div class="email-format-index">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Search Here</div>
        </div>
        <div class="block-content collapse in">
        <div class="restaurants-gallery-form span12">

             <?=Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'), "javascript:void(0);", ['class' => 'btn btn-primary open_search']);?>
             <?php if (!empty($_REQUEST['RestaurantsGallerySearch']) || (!empty($_GET['temp']) && $_GET['temp'] == "clear")) {?>
                <div class="restaurantss-gallery-serach common_search">
                 <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
        <?php } else {?>
            <div class="restaurants-gallery-serach common_search">
                 <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    <?php }?>
</div>
</div>
</div>
   <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">
            <?php echo Html::encode($this->title) . ' - ' . $snRestaurantName ?>
        </div>
        <div class="pull-right">
            <?=Html::a(Yii::t('app', '<i class="icon-plus"></i> Add Photo'), Yii::$app->urlManager->createUrl(['restaurants-gallery/create', 'rid' => ($_GET['rid'] > 0) ? $_GET['rid'] : 0]), ['class' => 'btn btn-success'])?>
            <?php // echo Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['restaurants-gallery/index', 'rid' => ( $_GET['rid'] > 0 ) ? $_GET['rid'] : 0]), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <div class="block-content">
    <?php // Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        // 'id',
        // 'restaurant_id',
        // 'image_name',
        [
            'attribute' => 'image_name',
            'filter' => false,
            'format' => 'html',
            'value' => function ($data) {
                return Html::img(Yii::getAlias('@web') . "/../uploads/restaurant/" . $data['image_name'], ['width' => '70px']);
            },
            'headerOptions' => ["style" => "width:17%;text-align:center;"],
            'contentOptions' => ["style" => "width:17%;text-align:center;"],
        ],
        [
            'attribute' => 'image_description',
            //'visible'=>( !empty( $_GET['tid'] ) ) ? false : true,
            'format' => 'raw',
            'value' => function ($data) {
                $ssText = Common::get_substr($data->image_description, 20);
                return Html::a($ssText, ['view', 'id' => $data->id], ['class' => 'colorbox_popup', 'onclick' => 'javascript:openColorBox(700,650);']);
            },
        ],
        'image_title',
        //'image_description:ntext',
        [
            'attribute' => 'status',
            'header' => 'Status',
            'filter' => Yii::$app->params['status'],
            'value' => function ($data) {
                return Yii::$app->params['status'][$data->status];
            },
            'headerOptions' => ["style" => "width:12%;text-align:center;"],
            'contentOptions' => ["style" => "width:12%;text-align:center;"],
        ],
        //'created_by',
        //'updated_by',
        //'created_at',
        //'updated_at',

        [
            'header' => 'Actions',
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ["style" => "width:40%;"],
            'contentOptions' => ["style" => "width:40%;"],
            'template' => '{update}{delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    $flag = 1;
                    $url = Yii::$app->urlManager->createurl(['restaurants-gallery/update', 'rid' => $model->restaurant_id, 'id' => $model->id]);
                    return Common::template_update_button($url, $model, $flag);
                },
                'delete' => function ($url, $model) {
                    $flag = 1;
                    $url = Yii::$app->urlManager->createurl(['restaurants-gallery/delete', 'id' => $model->id, 'rid' => $model->restaurant_id]);

                    $confirmmessage = "Are you sure you want to delete this this image?";
                    return Common::template_delete_button($url, $model, $confirmmessage, $flag);
                },
            ],
        ],
    ],
]);?>

    <?php // Pjax::end(); ?>
   </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
    $('.restaurants-gallery-serach').hide();
        $('.open_search').click(function(){
            $('.restaurants-gallery-serach').toggle();
        });
    });

</script>