<?php

namespace backend\controllers;

use backend\components\AdminCoreController;
use common\models\Restaurants;
use common\models\RestaurantsSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RestaurantsController implements the CRUD actions for Restaurants model.
 */
class RestaurantsController extends AdminCoreController
{
    /**
     * {@inheritdoc}
     */
    /*   public function behaviors()
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
     * Lists all Restaurants models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RestaurantsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Restaurants model.
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
     * Creates a new Restaurants model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Restaurants();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $postdata = Yii::$app->request->post();
            $model->restaurant_type = implode(",", $postdata['Restaurants']['restaurant_type']);
            $file = \yii\web\UploadedFile::getInstance($model, 'photo');
            if (!empty($file)) {
                $file_name = $file->basename . "_" . uniqid() . "." . $file->extension;
                //p(trim($file_name));
                $file_filter = str_replace(" ", "", $file_name);
                $model->photo = $file_filter;
                $file->saveAs(Yii::getAlias('@root') . '/uploads/restaurants/' . $file_filter);
            }
            $model->save(false);
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Restaurants model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_image = $model->photo;
        $restaurantTypes = explode(",", $model->restaurant_type);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $postdata = Yii::$app->request->post();
            $model->restaurant_type = implode(",", $postdata['Restaurants']['restaurant_type']);
            if (!empty($file)) {
                $delete = $model->oldAttributes['photo'];
                $file_name = $file->basename . "_" . uniqid() . "." . $file->extension;
                $file_filter = str_replace(" ", "", $file_name);
                if (!empty($old_image) && file_exists(Yii::getAlias('@root') . '/uploads/' . $old_image)) {
                    unlink(Yii::getAlias('@root') . '/uploads/restaurants/' . $old_image);
                }
                $file->saveAs(Yii::getAlias('@root') . '/uploads/restaurants/' . $file_filter, false);
                $model->photo = $file_filter;
            } else {
                $model->photo = $old_image;
            }
            $model->save(false);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'restaurantTypes' => $restaurantTypes,
        ]);
    }

    /**
     * Deletes an existing Restaurants model.
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

    /**
     * Finds the Restaurants model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Restaurants the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Restaurants::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
