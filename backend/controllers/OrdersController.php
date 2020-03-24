<?php

namespace backend\controllers;

use backend\components\AdminCoreController;
use common\components\Common;
use common\models\DeviceDetails;
use common\models\NotificationList;
use common\models\Orders;
use common\models\OrdersSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends AdminCoreController
{
    /**
     * {@inheritdoc}
     */
    /*  public function behaviors()
    {
    return [
    'verbs' => [
    'class' => VerbFilter::className(),
    'actions' => [
    'delete' => ['POST'],
    ],
    ],
    ];
    }
     */
    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionAcceptOrder($order_id)
    {
        $this->layout = 'popup';
        $orderModel = Orders::find()->where(['id' => $order_id])->one();
        if (!empty(Yii::$app->request->post()) && !empty($orderModel)) {
            $postData = Yii::$app->request->post();
            $orderModel->status = $postData['Orders']['status'];
            if ($orderModel->save(false)) {
                $user_id = $orderModel->user_id;
                $deviceModel = DeviceDetails::find()->select('device_tocken,type')->where(['user_id' => $user_id])->one();
                $device_tocken = $deviceModel->device_tocken;
                $type = $deviceModel->type;
                $title = "Order Status Notification";
                $body = "Your order is " . Yii::$app->params['order_status_value'][$orderModel->status];
                if ($type == Yii::$app->params['device_type']['android']) {
                    $status = Common::push_notification_android($device_tocken, $title, $body);
                } else {
                    $status = Common::push_notification_android($device_tocken, $title, $body);
                }
                if ($status) {
                    $NotificationListModel = new NotificationList();
                    $NotificationListModel->user_id = $user_id;
                    $NotificationListModel->title = $title;
                    $NotificationListModel->body = $body;
                    $NotificationListModel->status = 1;
                    $NotificationListModel->save(false);
                }

            }
            Yii::$app->session->setFlash('success', Yii::getAlias('@order_update_message'));
            return Common::closeColorBox();

        }
        return $this->render('accept_order', [
            'orderModel' => $orderModel,
        ]);
    }
    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
