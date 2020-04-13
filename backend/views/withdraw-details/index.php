<?php

use common\components\Common;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WithdrawDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Withdraw Details : ' . Common::get_user_name($_GET['uid']);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-details-index email-format-index">
 <div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Search Here</div>
    </div>
        <div class="block-content collapse in">
        <div class="tags-form span12">

     <?=Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'), "javascript:void(0);", ['class' => 'btn btn-primary open_search']);?>
     <?php if (!empty($_REQUEST['WithdrawDetailsSearch']) || (!empty($_GET['temp']) && $_GET['temp'] == "clear")) {?>
        <div class="withdraw-detailss-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
<?php } else {?>
    <div class="withdraw-details-serach common_search">
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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        // 'id',
        //'user_id',
        'amount',
        'transfer_id',
        [
            'attribute' => 'created_at',
            'label' => "Date & time",
            //'visible'=>( !empty( $_GET['tid'] ) ) ? false : true,
            'value' => function ($data) {
                return $data->created_at;
            },
        ],
        //'updated_at',

        //['class' => 'yii\grid\ActionColumn'],
    ],
]);?>
 </div>
    </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
    $('.withdraw-details-serach').hide();
        $('.open_search').click(function(){
            $('.withdraw-details-serach').toggle();
        });
    });
</script>
