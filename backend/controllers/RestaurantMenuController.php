<?php

namespace backend\controllers;

use backend\components\AdminCoreController;
use common\models\RestaurantMenu;
use common\models\RestaurantMenuSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RestaurantMenuController implements the CRUD actions for RestaurantMenu model.
 */
class RestaurantMenuController extends AdminCoreController
{
    /**
     * {@inheritdoc}
     */
    /* public function behaviors()
    {
    return [
    'verbs' => [
    'class' => VerbFilter::className(),
    'actions' => [
    'delete' => ['POST'],
    ],
    ],
    ];
    }*/

    /**
     * Lists all RestaurantMenu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RestaurantMenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RestaurantMenu model.
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
     * Creates a new RestaurantMenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RestaurantMenu();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $file = \yii\web\UploadedFile::getInstance($model, 'photo');
            if (!empty($file)) {
                $file_name = $file->basename . "_" . uniqid() . "." . $file->extension;
                //p(trim($file_name));
                $file_filter = str_replace(" ", "", $file_name);
                $model->photo = $file_filter;
                $file->saveAs(Yii::getAlias('@root') . '/uploads/menus/' . $file_filter);
            }
            $model->restaurant_id = $_GET['rid'];
            $model->menu_category_id = $_GET['cid'];
            $model->save(false);
            Yii::$app->session->setFlash('success', Yii::getAlias('@menu_add_message'));
            return $this->redirect(['index', 'rid' => $model->restaurant_id, 'cid' => $model->menu_category_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RestaurantMenu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_image = $model->photo;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $file = \yii\web\UploadedFile::getInstance($model, 'photo');
            if (!empty($file)) {
                $delete = $model->oldAttributes['photo'];
                $file_name = $file->basename . "_" . uniqid() . "." . $file->extension;
                $file_filter = str_replace(" ", "", $file_name);
                if (!empty($old_image) && file_exists(Yii::getAlias('@root') . '/uploads/' . $old_image)) {
                    unlink(Yii::getAlias('@root') . '/uploads/menus' . $old_image);
                }
                $file->saveAs(Yii::getAlias('@root') . '/uploads/menus' . $file_filter, false);
                $model->photo = $file_filter;
            } else {
                $model->photo = $old_image;
            }
            $model->restaurant_id = $_GET['rid'];
            $model->menu_category_id = $_GET['cid'];
            $model->save();
            Yii::$app->session->setFlash('success', Yii::getAlias('@menu_update_message'));
            return $this->redirect(['index', 'rid' => $model->restaurant_id, 'cid' => $model->menu_category_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RestaurantMenu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success', Yii::getAlias('@menu_delete_message'));
        return $this->redirect(['index', 'rid' => $model->restaurant_id, 'cid' => $model->menucategory_id]);
    }

    /**
     * Finds the RestaurantMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RestaurantMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RestaurantMenu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
