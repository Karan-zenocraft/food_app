<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\FeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Feedbacks';
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedbacks-index email-format-index">
 <div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Search Here</div>
    </div>
        <div class="block-content collapse in">
        <div class="tags-form span12">

     <?=Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'), "javascript:void(0);", ['class' => 'btn btn-primary open_search']);?>
     <?php if (!empty($_REQUEST['FeedbackSearch']) || (!empty($_GET['temp']) && $_GET['temp'] == "clear")) {?>
        <div class="feedbackss-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
<?php } else {?>
    <div class="feedbacks-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    <?php }?>
</div>
</div>
</div>

  <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>

        <div class="pull-right">

       </div>

    </div>
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

        //'id',
        [
            'attribute' => 'restaurant_id',
            'value' => function ($data) {
                return !empty($data->restaurant_id) ? $data->restaurant->name : "";
            },
        ],
        [
            'attribute' => 'user_id',
            'value' => function ($data) {
                return !empty($data->user_id) ? $data->user->user_name : "";
            },
        ],
        'rating',
        'review_note:ntext',
        //'created_at',
        //'updated_at',

        // ['class' => 'yii\grid\ActionColumn'],
    ],
]);?>

    <?php Pjax::end();?>

 </div>
    </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
    $('.feedbacks-serach').hide();
        $('.open_search').click(function(){
            $('.feedbacks-serach').toggle();
        });
    });
</script>
