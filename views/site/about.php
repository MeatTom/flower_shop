<?php

use app\models\Items;
use yii\helpers\Html;
use yii\bootstrap5\Carousel;
use yii\bootstrap5\CarouselItem;

/** @var yii\web\View $this */

$this->title = 'О нас';
//$this->params['breadcrumbs'][] = $this->title;

$newItems = Items::find()
    ->where(['>', 'amount', 0])
    ->orderBy(['create_time' => SORT_DESC])
    ->limit(5)
    ->all();
?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card mb-3" style="max-width: 100%;">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="/web/image_storage/icon.png" class="img-fluid rounded-start" alt="icon">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h3 class="card-header">Девиз нашей компании</h3>
        <h4 class="card-text text-primary">"Цветочное настроение в каждом букете – Мир цветов создан для вас!"</h4>
      </div>
    </div>
  </div>
</div>

    <h2>
        Наши последние новинки:
</h2>

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
