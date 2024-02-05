<?php

namespace app\controllers;

use app\models\Items;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ItemSearch;
use yii\web\UploadedFile;
use yii\web\Response;
use Yii;

/**
 * ItemsController implements the CRUD actions for Items model.
 */
class ItemsController extends Controller
{
    /**
     * @inheritDoc
     */
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
     * Lists all Items models.
     *
     * @return string
     */

    public function actionCatalog()
    {
        $searchModel = new ItemSearch(); 
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    if ((Yii::$app->user->isGuest) || (Yii::$app->user->identity->isAdmin==0)){
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } else 
    return $this->render('catalog', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
    }

    public function actionIndex()
    {
        $searchModel = new ItemSearch(); 
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAvailableQuantity()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $itemId = Yii::$app->request->get('itemId');
        $item = Items::findOne($itemId);

        if (!$item) {
            throw new NotFoundHttpException('Item not found.');
        }

        return ['availableQuantity' => $item->amount];
    }

    /**
     * Displays a single Items model.
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
     * Creates a new Items model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
     public function actionCreate()
    {
        $model = new Items();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            $model->image=UploadedFile::getInstance($model,'image');
            $file_name='/web/image_storage/' . Yii::$app->getSecurity()->generateRandomString(50). '.' . $model->image->extension;
            $model->image->saveAs(Yii::$app->basePath . $file_name);
            $model->image=$file_name;
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Items model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
 {
 $model = $this->findModel($id);
 if ($this->request->isPost) {
 $model->load($this->request->post());
 $model->image=UploadedFile::getInstance($model,'image');
 $file_name='/web/image_storage/' . Yii::$app->getSecurity()->generateRandomString(50). '.' . $model->image->extension;
 $model->image->saveAs(Yii::$app->basePath . $file_name);
 $model->image=$file_name;
 $model->save(false);
 return $this->redirect(['view', 'id' => $model->id]);
 }
 return $this->render('update', ['model' => $model,
]);
}
    /**
     * Deletes an existing Items model.
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
     * Finds the Items model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Items the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Items::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
