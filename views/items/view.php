<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Items */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['catalog']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin): ?>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                ['attribute'=>'Фото', 'format'=>'html', 'value'=>function($data){return"<img src='{$data->image}' alt='photo' style='width: 70px;'>";}],
                'price',
                'country',
                'category',
                'color',
                'amount',
                'create_time',
            ],
        ]) ?>
    <?php else: ?>

        <div class="card mb-3" style="max-width: 100%;">
  <div class="row g-0 bg-info bg-opacity-75">
    <div class="col-md-4">
      <img src="<?= $model->image ?>" class="img-fluid rounded-start" alt="<?= Html::encode($model->name) ?>">
    </div>
    <div class="col-md-8">
      <div class="card-body">   
        <br>
                <p class="card-text">Страна производства: <?= Html::encode($model->country) ?></p>
                <?php
                        if ($model->categoryRelation) {
                            echo '<p class="card-text">Категория: ' . Html::encode($model->categoryRelation->name) . '</p>';
                        }
                        ?>
                <p class="card-text">Цвет: <?= Html::encode($model->color) ?></p>
                <p class="card-text">Доступное количество: <?= $model->amount ?></p>
                <p class="card-text">Цена: <?= $model->price ?></p>
                
      </div>
    </div>
  </div>
</div>
    <?php endif; ?>

</div>
