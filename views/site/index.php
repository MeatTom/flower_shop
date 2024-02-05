<?php
/** @var yii\web\View $this */
use app\models\Items;
use yii\helpers\Html;
use yii\bootstrap5\Carousel;

$this->title = 'Мир Цветов';

$newItems = Items::find()
    ->where(['>', 'amount', 0])
    ->orderBy(['create_time' => SORT_DESC])
    ->limit(5)
    ->all();
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Добро пожаловать в Мир Цветов!</h1>

        <p class="lead">Выбирайте лучшие цветы для своих близких и себя!</p>

        <p><a class="btn btn-lg btn-success" href="/items/index">Посмотреть товары</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <h2>Широкий выбор цветов</h2>
                <p>У нас вы найдете разнообразие цветов для любого случая. Выбирайте из нашего обширного каталога.</p>
            </div>
            <div class="col-lg-4 mb-3">
                <h2>Доставка по всему миру</h2>
                <p>Мы осуществляем доставку цветов в любую точку мира. Сделайте заказ прямо сейчас и порадуйте своих близких.</p>
            </div>
            <div class="col-lg-4">
                <h2>Свежие и качественные цветы</h2>
                <p>Наши цветы всегда свежие и красочные. Гарантируем высокое качество каждого букета.</p>
            </div>
        </div>

    </div>
<br>
    <h2>Наши последние новинки:</h2>

    <?php if (!empty($newItems)): ?>
<div class="container mt-5">

<style>
            #newItemsCarousel {
                max-width: 50%;
                margin: 0 auto;
            }
        </style>

    <div id="newItemsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php foreach ($newItems as $index => $item): ?>
                <button type="button" data-bs-target="#newItemsCarousel" data-bs-slide-to="<?= $index ?>" <?= $index === 0 ? 'class="active" aria-current="true"' : '' ?> aria-label="Slide <?= $index+1 ?>"></button>
            <?php endforeach; ?>
        </div>
        <div class="carousel-inner">
            <?php foreach ($newItems as $index => $item): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <?= Html::img($item->image, ['class' => 'd-block w-100', 'alt' => 'New Item Image']) ?>
                    <div class="carousel-caption bg-dark bg-opacity-75 d-none d-md-block">
                        <h5><?= Html::encode($item->name) ?></h5>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#newItemsCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#newItemsCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<?php endif; ?>

</div>
