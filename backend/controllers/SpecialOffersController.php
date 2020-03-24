<?php

namespace backend\controllers;

use backend\components\AdminCoreController;
use common\components\Common;
use common\models\SpecialOffers;
use common\models\SpecialOffersSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SpecialOffersController implements the CRUD actions for SpecialOffers model.
 */
class SpecialOffersController extends AdminCoreController
{
    /**
     * {@inheritdoc}
     */

    /**
     * Lists all SpecialOffers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SpecialOffersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SpecialOffers model.
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
     * Creates a new SpecialOffers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SpecialOffers();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $postdata = Yii::$app->request->post();
            $user_id = Yii::$app->user->id;
            $role = Common::get_user_role($user_id, $flag = "1");
            if ($role->role_id == Yii::$app->params['userroles']['super_admin']) {
                $model->restaurant_id = implode(",", $postdata['SpecialOffers']['restaurant_id']);
            } else {
                $model->restaurant_id = $role->restaurant_id;
            }
            $file = \yii\web\UploadedFile::getInstance($model, 'photo');
            if (!empty($file)) {
                $file_name = $file->basename . "_" . uniqid() . "." . $file->extension;
                //p(trim($file_name));
                $file_filter = str_replace(" ", "", $file_name);
                $model->photo = $file_filter;
                $file->saveAs(Yii::getAlias('@root') . '/uploads/restaurants_offers/' . $file_filter);
            }
            $model->save(false);
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SpecialOffers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_image = $model->photo;
        $restaurants = explode(",", $model->restaurant_id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $postdata = Yii::$app->request->post();
            $user_id = Yii::$app->user->id;
            $role = Common::get_user_role($user_id, $flag = "1");
            if ($role->role_id == Yii::$app->params['userroles']['super_admin']) {
                $model->restaurant_id = implode(",", $postdata['SpecialOffers']['restaurant_id']);
            } else {
                $model->restaurant_id = $role->restaurant_id;
            }
            $file = \yii\web\UploadedFile::getInstance($model, 'photo');
            if (!empty($file)) {
                $delete = $model->oldAttributes['photo'];
                $file_name = $file->basename . "_" . uniqid() . "." . $file->extension;
                $file_filter = str_replace(" ", "", $file_name);
                if (!empty($old_image) && file_exists(Yii::getAlias('@root') . '/uploads/restaurants_offers/' . $old_image)) {
                    unlink(Yii::getAlias('@root') . '/uploads/restaurants_offers/' . $old_image);
                }
                $file->saveAs(Yii::getAlias('@root') . '/uploads/restaurants_offers/' . $file_filter, false);
                $model->photo = $file_filter;
            } else {
                $model->photo = $old_image;
            }
            $model->save(false);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            //'restaurants' => $restaurants,
        ]);
    }

    /**
     * Deletes an existing SpecialOffers model.
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
     * Finds the SpecialOffers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SpecialOffers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SpecialOffers::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
