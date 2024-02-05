<?php

namespace app\controllers;

use app\models\Orders;
use app\models\OrdersSearch;
use app\models\Cart;
use app\models\Items;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use Yii;

/**
 * OrderController implements the CRUD actions for Orders model.
 */
class OrderController extends Controller
{
    /**
     * @inheritDoc
     */

     public function beforeAction($action)
     {
     if (\Yii::$app->user->isGuest){
     $this->redirect(['site/login']);
     return false;
     } else return true;
     }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Orders models.
     *
     * @return string
     */
    public function actionOrders()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        if ((Yii::$app->user->isGuest) || (Yii::$app->user->identity->isAdmin==0)){
            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        } else 
        return $this->render('orders', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

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
     * @param int $id ID
     * @return string
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
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCheckout()
{
    $userId = Yii::$app->user->identity->id;
    $cartItems = Cart::findAll(['userId' => $userId]);

    if (!empty($cartItems)) {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            foreach ($cartItems as $cartItem) {
                $order = new Orders();
                $order->userId = $userId;
                $order->idItem = $cartItem->itemId;
                $order->amount = $cartItem->amount;
                $order->save();

                // Subtract the quantity from the Items table
                $item = Items::findOne($cartItem->itemId);
                if ($item) {
                    $item->amount -= $cartItem->amount;
                    $item->save();
                }

                $cartItem->delete();
            }

            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Orders placed successfully.');
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Failed to place the orders.');
        }
    } else {
        Yii::$app->session->setFlash('error', 'Cart is empty. Add items to the cart before checking out.');
    }

    return $this->redirect(['/order']);
}

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPassword()
{
    Yii::$app->response->format = Response::FORMAT_JSON;

    $password = Yii::$app->request->post('password');

    $user = Yii::$app->user->identity;

    if ($user && $user->validatePassword($password)) {
        return ['success' => true];
    } else {
        return ['success' => false];
    }
}
}
