<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Items;
use app\models\Category;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
 <h1><?= Html::encode($this->title) ?></h1>
 <p>
 <?= Html::a('Создать товар', ['create'], ['class' => 'btn btn-success']) ?>
 </p>
 <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
 <?= GridView::widget([
 'dataProvider' => $dataProvider,
 'filterModel' => $searchModel,
 'columns' => [
 ['class' => 'yii\grid\SerialColumn'],
 'id',
 ['attribute'=>'Категория', 'value'=> function($data){return $data->getCategoryRelation()->One()->name;}],
 'name',
 ['attribute'=>'Фото', 'format'=>'html', 'value'=>function($data){return"<img src='{$data->image}' alt='photo' style='width: 70px;'>";}],
 'country',
 'price',
 'amount',
 'color',
[
    'class' => ActionColumn::className(),
    'urlCreator' => function ($action, Items $model, $key, $index, $column) {
    return Url::toRoute([$action, 'id' => $model->id]);
    }
],
    ],
    ]); ?>
   </div>
   