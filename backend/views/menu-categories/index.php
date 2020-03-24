<?php

use common\components\Common;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MenuCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu Categories';
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    
.nav-list li:nth-child(4), .nav-list li:nth-child(4) a:hover{background: #006dcc;}
.nav-list li:nth-child(4) span, .nav-list li:nth-child(4) span:hover{color: #fff!important;}

</style>
<div class="menu-categories-index email-format-index">
 <div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Search Here</div>
    </div>
        <div class="block-content collapse in">
        <div class="tags-form span12">

     <?=Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'), "javascript:void(0);", ['class' => 'btn btn-primary open_search']);?>
     <?php if (!empty($_REQUEST['MenuCategoriesSearch']) || (!empty($_GET['temp']) && $_GET['temp'] == "clear")) {?>
        <div class="menu-categoriess-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
<?php } else {?>
    <div class="menu-categories-serach common_search">
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
        <?=Html::a(Yii::t('app', '<i class="icon-plus"></i> Add menu Category'), ['create', 'rid' => $_GET['rid']], ['class' => 'btn btn-success'])?>
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
        'name',
        'description',
        [
            'attribute' => 'restaurant_id',
            'filterOptions' => ["style" => "width:13%;"],
            'headerOptions' => ["style" => "width:13%;"],
            'contentOptions' => ["style" => "width:13%;"],
            'value' => function ($data) {
                return !empty($data->restaurant_id) ? $data->restaurant->name : "";
            },
        ],
        [
            'attribute' => 'status',
            'filterOptions' => ["style" => "width:13%;"],
            'headerOptions' => ["style" => "width:13%;"],
            'contentOptions' => ["style" => "width:13%;"],
            'value' => function ($data) {
                return Yii::$app->params['user_status'][$data->status];
            },
        ],
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
                    $url = Yii::$app->urlManager->createUrl(['menu-categories/update', "rid" => $_GET['rid'], 'id' => $model->id]);
                    return Common::template_update_button($url, $model, $flag);
                },
                'manage_menu' => function ($url, $model) {
                    $title = "manage Restaurant's Menu";
                    $flag = 3;
                    $url = Yii::$app->urlManager->createUrl(['restaurant-menu/index', 'rid' => $model->restaurant_id, 'cid' => $model->id]);
                    return Common::template_view_gallery_button($url, $model, $title, $flag);

                },
                'delete' => function ($url, $model) {
                    $flag = 1;
                    $confirmmessage = "Are you sure you want to delete this Category?";
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
    $('.menu-categories-serach').hide();
        $('.open_search').click(function(){
            $('.menu-categories-serach').toggle();
        });
    });
</script>
