<?php

namespace backend\controllers;

use backend\components\AdminCoreController;
use common\models\MenuCategories;
use common\models\MenuCategoriesSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * MenuCategoriesController implements the CRUD actions for MenuCategories model.
 */
class MenuCategoriesController extends AdminCoreController
{
    /**
     * {@inheritdoc}
     */
    /*public function behaviors()
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
     * Lists all MenuCategories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuCategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MenuCategories model.
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
     * Creates a new MenuCategories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MenuCategories();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->restaurant_id = $_GET['rid'];
            $model->save(false);
            Yii::$app->session->setFlash('success', Yii::getAlias('@menucategory_add_message'));
            return $this->redirect(['index', 'rid' => $model->restaurant_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MenuCategories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::getAlias('@menucategory_update_message'));
            return $this->redirect(['index', 'rid' => $model->restaurant_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MenuCategories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success', Yii::getAlias('@menucategory_delete_message'));
        return $this->redirect(['index', 'rid' => $model->restaurant_id]);
    }

    /**
     * Finds the MenuCategories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MenuCategories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MenuCategories::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
