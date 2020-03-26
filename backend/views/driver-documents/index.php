<style type="text/css">
img{
height: 100px !important;
width: 100px !important;
}
</style><?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DriverDocumentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Driver Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-documents-index email-format-index">
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

        //'id',
        //'user_id',
        //'document_photo',
        [
            'attribute' => 'document_photo',
            'format' => 'image',
            'value' => function ($data) {
                if (!empty($data->document_photo)) {
                    $document_photo = Yii::$app->params['root_url'] . '/' . "uploads/documents/" . $data->document_photo;
                } else {
                    $document_photo = Yii::$app->params['root_url'] . '/' . "uploads/no_image.png";
                }
                return $document_photo;
            },
        ],
        // 'document_photo_url:url',
        //'created_at',
        //'updated_at',

        // ['class' => 'yii\grid\ActionColumn'],
    ],
]);?>
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

