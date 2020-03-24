<style type="text/css">
img{
height: 43px !important;
width: 43px !important;
}
</style><?php

use common\components\Common;
use common\models\Restaurants;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SpecialOffersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Special Offers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurants-index email-format-index">
      <div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Search Here</div>
    </div>
        <div class="block-content collapse in">
        <div class="tags-form span12">

     <?=Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'), "javascript:void(0);", ['class' => 'btn btn-primary open_search']);?>
     <?php if (!empty($_REQUEST['RestaurantsSearch']) || (!empty($_GET['temp']) && $_GET['temp'] == "clear")) {?>
        <div class="special-offerss-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
<?php } else {?>
    <div class="special-offers-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    <?php }?>
</div>
</div>
</div>
<div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
        <?php $user_role = Common::get_user_role(Yii::$app->user->id, $flag = 0);?>

        <div class="pull-right">
        <?=Html::a(Yii::t('app', '<i class="icon-plus"></i> Add Offer'), ['create'], ['class' => 'btn btn-success'])?>
       </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
  <div class="block-content">
        <div class="goodtable">

    <?php Pjax::begin();?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        // 'id',
        [
            'attribute' => 'restaurant_id',
            //'visible'=>( !empty( $_GET['tid'] ) ) ? false : true,
            'format' => 'raw',
            'value' => function ($data) {
                $ssText = Restaurants::getRestaurantNames($data->restaurant_id, $flag = "name");
                return $ssText;
            },
        ],
        'discount',
        'coupan_code',
        [
            'attribute' => 'photo',
            'format' => 'image',
            'value' => function ($data) {
                if (!empty($data->photo)) {
                    $photo = Yii::$app->params['root_url'] . '/' . "uploads/restaurants_offers/" . $data->photo;
                } else {
                    $photo = Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
                }
                return $photo;
            },
        ],
        'from_date',
        'to_date',
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
                    return Common::template_update_button($url, $model, $flag);
                },
                'delete' => function ($url, $model) {
                    $flag = 1;
                    $confirmmessage = "Are you sure you want to delete this Offer?";
                    return Common::template_delete_button($url, $model, $confirmmessage, $flag);
                },

            ],
        ],
    ],
]);?>

    <?php Pjax::end();?>

 </div>
    </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
    $('.special-offers-serach').hide();
        $('.open_search').click(function(){
            $('.special-offers-serach').toggle();
        });
    });
</script>
