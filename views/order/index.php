<?php

use app\models\Orders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Заказы';

$dataProvider = new ActiveDataProvider([
    'query' => Orders::find()->where(['userId' => Yii::$app->user->identity->id]),
]);
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-12">
            <?php
            $groupedOrders = [];
            
            foreach ($dataProvider->getModels() as $model) {
                $orderTime = $model->order_time;
                $orderDate = Yii::$app->formatter->asDate($orderTime, 'php:j F Y');
                if (!isset($groupedOrders[$orderTime])) {
                    $groupedOrders[$orderTime] = [];
                }
                $groupedOrders[$orderTime][] = $model;
            }

            foreach (array_reverse($groupedOrders) as $orderTime => $orders):
                $orderDate = Yii::$app->formatter->asDate($orderTime, 'php:j F Y');
            ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title"><?= Html::encode("Заказ от {$orderDate}") ?></h4>
                        <h5 class="card-title"><?= Html::encode("Время заказа: " . Yii::$app->formatter->asTime($orderTime)) ?></h5>
                        
                        <?php foreach ($orders as $order): ?>
                            <hr>
                            <?php if ($order->itemRelation): ?>
                                <p class="card-text">Название: <?= Html::encode($order->itemRelation->name) ?></p>
                            <?php endif; ?>

                            <p class="card-text">Количество: <?= $order->amount ?></p>
                            <p class="card-text">Статус: <?= $order->status ?></p>

                            <?php if ($order->status === 'Новый'): ?>
                                <?= Html::a('Удалить', ['delete', 'id' => $order->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'Вы точно хотите удалить этот заказ?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
