<?php

use common\components\Common;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RestaurantMenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Restaurant Menus';
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => 'Manage Menu Categories', 'url' => ['menu-categories/index', 'rid' => $_GET['rid']]];
$this->params['breadcrumbs'][] = ['label' => Common::get_name_by_id($_GET['cid'], "MenuCategories"), "url" => "#"];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-menu-index email-format-index">
 <div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Search Here</div>
    </div>
        <div class="block-content collapse in">
        <div class="tags-form span12">

     <?=Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'), "javascript:void(0);", ['class' => 'btn btn-primary open_search']);?>
     <?php if (!empty($_REQUEST['RestaurantMenuSearch']) || (!empty($_GET['temp']) && $_GET['temp'] == "clear")) {?>
        <div class="restaurant-menus-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
<?php } else {?>
    <div class="restaurant-menu-serach common_search">
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
        <?=Html::a(Yii::t('app', '<i class="icon-plus"></i> Add menu'), ['create', "rid" => $_GET['rid'], "cid" => $_GET['cid']], ['class' => 'btn btn-success'])?>
       </div>
<?php }
?>
    </div>
      <div class="block-content">
        <div class="goodtable">
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
            'filterOptions' => ["style" => "width:13%;"],
            'headerOptions' => ["style" => "width:13%;"],
            'contentOptions' => ["style" => "width:13%;"],
            'value' => function ($data) {
                return !empty($data->restaurant_id) ? $data->restaurant->name : "";
            },
        ],
        'name',
        'description:ntext',
        [
            'attribute' => 'menu_category_id',
            'filterOptions' => ["style" => "width:13%;"],
            'headerOptions' => ["style" => "width:13%;"],
            'contentOptions' => ["style" => "width:13%;"],
            'value' => function ($data) {
                return !empty($data->menu_category_id) ? $data->menuCategory->name : "";
            },
        ],
        //'price',
        //'photo',
        //'created_by',
        //'updated_by',
        //'status',
        //'created_at',
        //'updated_at',

        [
            'header' => 'Actions',
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ["style" => "width:40%;"],
            'contentOptions' => ["style" => "width:40%;"],
            'template' => '{update}{manage_menu}{delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    $flag = 1;
                    $url = Yii::$app->urlManager->createUrl(['restaurant-menu/update', "rid" => $_GET['rid'], "cid" => $_GET['cid'], 'id' => $model->id]);
                    return Common::template_update_button($url, $model, $flag);
                },
                'delete' => function ($url, $model) {
                    $flag = 1;
                    $confirmmessage = "Are you sure you want to delete this Menu?";
                    return Common::template_delete_button($url, $model, $confirmmessage, $flag);
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
    $('.restaurant-menu-serach').hide();
        $('.open_search').click(function(){
            $('.restaurant-menu-serach').toggle();
        });
    });
</script>
