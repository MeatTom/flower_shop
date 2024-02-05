<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\Html;

$this->title = 'Где нас найти';
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card" style="width: 80%">
  <img src="/web/image_storage/Map.png" class="card-img-top" alt="...">
  <div class="card-body">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>Адрес:</b> 4-я Советская улица, 17/8, Санкт-Петербург</li>
        <li class="list-group-item"><b>Наш e-mail:</b> worldofflowers@yandex.ru</li>
        <li class="list-group-item"><b>Наш телефон:</b> +79119682230</li>
    </ul>
  </div>
</div>
</div>
