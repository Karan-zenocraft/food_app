<?php

namespace backend\controllers;

use backend\components\AdminCoreController;
use common\models\AccountDetails;
use common\models\AccountDetailsSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AccountDetailsController implements the CRUD actions for AccountDetails model.
 */
class AccountDetailsController extends AdminCoreController
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
    }
     */
    /**
     * Lists all AccountDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AccountDetails model.
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
     * Creates a new AccountDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AccountDetails();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $post = Yii::$app->request->post();
            $postData = $post['AccountDetails'];
            $model->restaurant_id = $_GET['rid'];
            // Generate Stripe Bank account and connect account from the data
            \Stripe\Stripe::setApiKey("sk_test_ZBaRU0wL5z8YaEEPUhY3jzgF00tdHXg5cp");
            try {
                // first create bank token
                $bankToken = \Stripe\Token::create([
                    'bank_account' => [
                        'country' => 'US',
                        'currency' => 'usd',
                        'account_holder_name' => $postData['stripe_bank_account_holder_name'],
                        'account_holder_type' => $postData['stripe_bank_account_holder_type'],
                        'routing_number' => $postData['stripe_bank_routing_number'],
                        'account_number' => $postData['stripe_bank_account_number'],
                    ],
                ]);

                $account_holder_name = explode(" ", $postData['stripe_bank_account_holder_name']);
                $first_name = $account_holder_name[0];
                $last_name = $account_holder_name[1];
                // second create stripe account
                $stripeAccount = \Stripe\Account::create([
                    "type" => "custom",
                    "country" => "US",
                    "email" => $postData['stripe_email'],
                    "business_type" => "individual",
                    "business_profile" => [
                        "url" => "http://www.zenocraft.com",
                    ],
                    "individual" => [
                        "first_name" => $first_name,
                        "last_name" => $last_name,
                    ],
                    "requested_capabilities" => ['transfers'],
                ]);

                // third link the bank account with the stripe account
                $bankAccount = \Stripe\Account::createExternalAccount(
                    $stripeAccount->id, ['external_account' => $bankToken->id]
                );
                // Fourth stripe account update for tos acceptance
                \Stripe\Account::update(
                    $stripeAccount->id, [
                        'tos_acceptance' => [
                            'date' => time(),
                            'ip' => $_SERVER['REMOTE_ADDR'], // Assumes you're not using a proxy
                        ],
                    ]
                );
                $response = ["bankToken" => $bankToken->id, "stripeAccount" => $stripeAccount->id, "bankAccount" => $bankAccount->id];
                $model->stripe_bank_token = $response['bankToken'];
                $model->stripe_connect_account_id = $response['stripeAccount'];
                $model->stripe_bank_accout_id = $response['bankAccount'];
                $model->save(false);
                Yii::$app->session->setFlash('success', Yii::getAlias('@account_details_add_message'));
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', "Something went wrong for creating stripe account please try again later");
            }
            return $this->redirect(['index', 'rid' => $model->restaurant_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AccountDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!empty(Yii::$app->request->post()) && $model->validate()) {
            $post = Yii::$app->request->post();
            $postData = $post['AccountDetails'];
            if (($model->stripe_email != $postData['stripe_email']) || ($model->stripe_bank_account_holder_name != $postData['stripe_bank_account_holder_name']) || ($model->stripe_bank_account_holder_type != $postData['stripe_bank_account_holder_type']) || ($model->stripe_bank_routing_number != $postData['stripe_bank_routing_number']) || ($model->stripe_bank_account_number != $postData['stripe_bank_account_number'])) {
                \Stripe\Stripe::setApiKey("sk_test_ZBaRU0wL5z8YaEEPUhY3jzgF00tdHXg5cp");
                try {
                    // first create bank token
                    $bankToken = \Stripe\Token::create([
                        'bank_account' => [
                            'country' => 'US',
                            'currency' => 'usd',
                            'account_holder_name' => $postData['stripe_bank_account_holder_name'],
                            'account_holder_type' => $postData['stripe_bank_account_holder_type'],
                            'routing_number' => $postData['stripe_bank_routing_number'],
                            'account_number' => $postData['stripe_bank_account_number'],
                        ],
                    ]);

                    $account_holder_name = explode(" ", $postData['stripe_bank_account_holder_name']);
                    $first_name = $account_holder_name[0];
                    $last_name = $account_holder_name[1];
                    // second create stripe account
                    $stripeAccount = \Stripe\Account::create([
                        "type" => "custom",
                        "country" => "US",
                        "email" => $postData['stripe_email'],
                        "business_type" => "individual",
                        "business_profile" => [
                            "url" => "http://www.zenocraft.com",
                        ],
                        "individual" => [
                            "first_name" => $first_name,
                            "last_name" => $last_name,
                        ],
                        "requested_capabilities" => ['transfers'],
                    ]);

                    // third link the bank account with the stripe account
                    $bankAccount = \Stripe\Account::createExternalAccount(
                        $stripeAccount->id, ['external_account' => $bankToken->id]
                    );
                    // Fourth stripe account update for tos acceptance
                    \Stripe\Account::update(
                        $stripeAccount->id, [
                            'tos_acceptance' => [
                                'date' => time(),
                                'ip' => $_SERVER['REMOTE_ADDR'], // Assumes you're not using a proxy
                            ],
                        ]
                    );
                    $response = ["bankToken" => $bankToken->id, "stripeAccount" => $stripeAccount->id, "bankAccount" => $bankAccount->id];
                    $model->stripe_bank_token = $response['bankToken'];
                    $model->stripe_connect_account_id = $response['stripeAccount'];
                    $model->stripe_bank_accout_id = $response['bankAccount'];
                    $model->restaurant_id = $_GET['rid'];
                    $model->paypal_email = $postData['paypal_email'];
                    $model->stripe_email = $postData['stripe_email'];
                    $model->stripe_bank_account_holder_name = $postData['stripe_bank_account_holder_name'];
                    $model->stripe_bank_account_holder_name = $postData['stripe_bank_account_holder_name'];
                    $model->stripe_bank_account_holder_type = $postData['stripe_bank_account_holder_type'];
                    $model->stripe_bank_routing_number = $postData['stripe_bank_routing_number'];
                    $model->stripe_bank_account_number = $postData['stripe_bank_account_number'];
                    $model->save(false);
                    Yii::$app->session->setFlash('success', Yii::getAlias('@account_details_update_message'));
                    return $this->redirect(['index', 'rid' => $model->restaurant_id]);
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('error', "Something went wrong for creating stripe account please try again later");
                    return $this->redirect(['index', 'rid' => $model->restaurant_id]);
                }
            } else {
                $model->save(false);
                Yii::$app->session->setFlash('success', Yii::getAlias('@account_details_update_message'));
                return $this->redirect(['index', 'rid' => $model->restaurant_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AccountDetails model.
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
     * Finds the AccountDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AccountDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AccountDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
