<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Items;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
{
    /**
     * @inheritDoc
     */

     public function beforeAction($action)
     {
        if ($action->id=='create') $this->enableCsrfValidation=false;
 return parent::beforeAction($action);

     if (Yii::$app->user->isGuest){
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
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Cart::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCart()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Cart::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('cart', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cart model.
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
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
   /* public function actionCreate()
    {
        $model = new Cart();

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
    }*/

    public function actionCreate()
{
    $id = Yii::$app->request->post('id');
    $items = Yii::$app->request->post('items');

    $product = Items::findOne($id);

    if ($product && $product->amount > 0) {
        $cartItem = Cart::find()->where(['userId' => Yii::$app->user->identity->id, 'itemId' => $id])->one();

        if ($cartItem) {
            $cartItem->amount += $items;
        } else {
            $cartItem = new Cart([
                'userId' => Yii::$app->user->identity->id,
                'itemId' => $id,
                'amount' => $items,
            ]);
        }

        if ($cartItem->save()) {
            $product->amount -= $items;
            $product->save();
            Yii::$app->session->setFlash('success', 'Товар успешно добавлен в корзину.');

            return $this->asJson(['success' => true, 'amount' => $product->amount]);
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка добавления товара в корзину.');
        }
    } else {
        Yii::$app->session->setFlash('error', 'Товар не добавлен.');
    }

    return $this->asJson(['success' => false, 'message' => 'Извините, товар закончился!']);
}

    

       

    /**
     * Updates an existing Cart model.
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
     * Deletes an existing Cart model.
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
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionIncrease($id)
{
    $cartItem = $this->findModel($id);
    $item = Items::findOne($cartItem->itemId);

    if (!$item) {
        return $this->asJson(['success' => false, 'message' => 'Item not found.']);
    }
    
    if ($cartItem->amount + 1 > $item->amount) {
        return $this->asJson(['success' => false, 'message' => 'Cannot increase quantity. Exceeds available quantity.']);
    }

    $cartItem->amount += 1;
    $cartItem->save();

    return $this->asJson(['success' => true, 'amount' => $cartItem->amount]);
}



public function actionDecrease($id)
{
    $cartItem = $this->findModel($id);

    if ($cartItem->amount > 1) {
        $cartItem->amount -= 1;
        $cartItem->save();

        return $this->asJson(['success' => true, 'amount' => $cartItem->amount]);
    }

    return $this->asJson(['success' => false, 'message' => 'Cannot decrease quantity. Quantity already at the minimum.']);
}

}
