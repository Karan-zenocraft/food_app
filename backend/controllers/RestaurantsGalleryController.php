<?php

namespace backend\controllers;

use backend\components\AdminCoreController;
use common\components\Common;
use common\models\RestaurantsGallery;
use common\models\RestaurantsGallerySearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RestaurantsGalleryController implements the CRUD actions for RestaurantsGallery model.
 */
class RestaurantsGalleryController extends AdminCoreController
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
     * Lists all RestaurantsGallery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $snRestaurantId = ($_GET['rid'] > 0) ? $_GET['rid'] : 0;
        $user = Common::get_user_role(Yii::$app->user->id, $flag = "1");

        $snRestaurantName = Common::get_name_by_id($snRestaurantId, $flag = "Restaurants");
        $searchModel = new RestaurantsGallerySearch();
        $dataProvider = $searchModel->backendSearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'snRestaurantName' => $snRestaurantName,
        ]);
    }

    /**
     * Displays a single RestaurantsGallery model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = 'popup';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RestaurantsGallery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new RestaurantsGallery();
        // $model->scenario = 'insert';
        $snRestaurantId = ($_GET['rid'] > 0) ? $_GET['rid'] : 0;
        $user = Common::get_user_role(Yii::$app->user->id, $flag = "1");
        $snRestaurantName = Common::get_name_by_id($snRestaurantId, $flag = "Restaurants");
        $model->restaurant_id = $_GET['rid'];

        if ($model->load(Yii::$app->request->post())) {
            $file = \yii\web\UploadedFile::getInstance($model, 'image_name');
            if (!empty($file)) {
                $file_name = $file->basename . "_" . uniqid() . "." . $file->extension;
                $model->image_name = $file_name;
                if ($model->validate()) {
                    $model->save();
                    $file->saveAs(Yii::getAlias('@root') . '/uploads/restaurant/' . $file_name);

                }
                Yii::$app->session->setFlash('success', Yii::getAlias('@restaurant_gallery_add_message'));
                return $this->redirect(['index', 'rid' => $model->restaurant_id]);
            } else {
                return $this->render('create', ['model' => $model, 'snRestaurantName' => $snRestaurantName, 'MenuCategoriesDropdown' => $MenuCategoriesDropdown]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'snRestaurantName' => $snRestaurantName,
        ]);

    }

    /**
     * Updates an existing RestaurantsGallery model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // $model->scenario = 'update';
        $old_image = $model->image_name;
        $snRestaurantId = ($_GET['rid'] > 0) ? $_GET['rid'] : 0;
        $user = Common::get_user_role(Yii::$app->user->id, $flag = "1");
        $snRestaurantName = Common::get_name_by_id($snRestaurantId, $flag = "Restaurants");
        if ($model->load(Yii::$app->request->post())) {
            $file = \yii\web\UploadedFile::getInstance($model, 'image_name');

            if (!empty($file)) {
                $delete = $model->oldAttributes['image_name'];
                $file_name = $file->basename . "_" . uniqid() . "." . $file->extension;

                $model->image_name = $file_name;
                if (!empty($old_image) && file_exists(Yii::getAlias('@root') . '/frontend/web/uploads/' . $old_image)) {
                    unlink(Yii::getAlias('@root') . '/uploads/restaurant/' . $old_image);
                }
                $file->saveAs(Yii::getAlias('@root') . '/uploads/restaurant/' . $file_name, false);
                $model->image_name = $file_name;
                $model->save();
            } else {
                $model->image_name = $old_image;
                $model->save(false);
            }
            Yii::$app->session->setFlash('success', Yii::getAlias('@restaurant_gallery_update_message'));
            return $this->redirect(['index', 'rid' => $model->restaurant_id]);
        } else {
            return $this->render('update', ['model' => $model, 'snRestaurantName' => $snRestaurantName]);
        }
        return $this->render('update', [
            'model' => $model,
            'snRestaurantName' => $snRestaurantName,
        ]);
    }

    /**
     * Deletes an existing RestaurantsGallery model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->findModel($id)->delete();
        $user = Common::get_user_role(Yii::$app->user->id, $flag = "1");

        if (file_exists(Yii::getAlias('@root') . '/uploads/restaurant/' . $model->image_name)) {
            unlink(Yii::getAlias('@root') . 'uploads/restaurant/' . $model->image_name);
        }

        $model->delete();
        Yii::$app->session->setFlash('success', Yii::getAlias('@restaurant_gallery_delete_message'));
        return $this->redirect(['index', 'rid' => $model->restaurant_id]);
    }

    /**
     * Finds the RestaurantsGallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RestaurantsGallery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RestaurantsGallery::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
