<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Панель администратора';
?>
<div class="container">
    <style>
        .btn-width {
            width: 100%;
        }
    </style>
    <h1>Панель администратора</h1>
    <br>
    <p><?= Html::a('Управление товарами', ['/items/catalog'], ['class' => 'btn btn-primary btn-lg btn-width']) ?></p>
    <p><?= Html::a('Управление заказами', ['/order/orders'], ['class' => 'btn btn-success btn-lg btn-width']) ?></p>
    <p><?= Html::a('Управление категориями', ['/category'], ['class' => 'btn btn-info btn-lg btn-width']) ?></p>
</div>
