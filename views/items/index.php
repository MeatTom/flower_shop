<?php
use app\models\Items;
use app\models\Category;
use app\models\ItemSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\bootstrap5\ButtonDropdown;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\ItemSearch $searchModel */

YiiAsset::register($this);

$this->title = 'Каталог';
//$this->params['breadcrumbs'][] = $this->title;

$sortParams = Yii::$app->request->get('sort');
$priceSort = $sortParams === 'price' ? '-price' : 'price';
$createTimeSort = $sortParams === 'create_time' ? '-create_time' : 'create_time';
$countrySort = $sortParams === 'country' ? '-country' : 'country';
$nameSort = $sortParams === 'name' ? '-name' : 'name';
?>
<div class="items-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    echo ButtonDropdown::widget([
        'label' => 'Фильтр по категориям',
        'options' => ['class' => 'btn btn-secondary', 'style' => 'margin-bottom: 1em'],
        'dropdown' => [
            'items' => $searchModel->getCategoriesDropdown(),
        ],
    ]);
    ?>

<?php
echo Html::a('По цене ' . ($sortParams === 'price' ? '↓' : '↑'), ['index', 'sort' => $priceSort], ['class' => 'btn btn-default']);
echo Html::a('По новизне ' . ($sortParams === 'create_time' ? '↓' : '↑'), ['index', 'sort' => $createTimeSort], ['class' => 'btn btn-default']);
echo Html::a('По стране происхождения ' . ($sortParams === 'country' ? '↓' : '↑'), ['index', 'sort' => $countrySort], ['class' => 'btn btn-default']);
echo Html::a('По наименованию ' . ($sortParams === 'name' ? '↓' : '↑'), ['index', 'sort' => $nameSort], ['class' => 'btn btn-default']);
?>

    <div class="row">
        <div class="col-md-12" style="margin-bottom: 2em">
            <?= Html::a('Сбросить', ['index'], ['class' => 'btn btn-danger']) ?>
        </div>
    </div>

    <div class="row">
    <?php foreach ($dataProvider->getModels() as $model): ?>
        <?php if ($model->amount > 0):?>
            <div class="col-md-4">
                <div class="card mb-4 pointer" data-href="<?= Url::to(['view', 'id' => $model->id]) ?>">
                    <img src="<?= $model->image ?>" class="card-img-top" alt="<?= Html::encode($model->name) ?>" style="cursor: pointer;">
                    <div class="card-body">
                        <h5 class="card-title"><?= Html::encode($model->name) ?></h5>
                        <p class="card-text">Цена: <?= $model->price ?></p>
                        <p class="card-text">Страна происхождения: <?= $model->country ?></p>
                        <?php
        
                        if ($model->categoryRelation) {
                            echo '<p class="card-text">Категория: ' . Html::encode($model->categoryRelation->name) . '</p>';
                        }
                        ?>
                        <?php if (!Yii::$app->user->isGuest): ?>
                            <?= Html::button('Добавить в корзину', [
                                'class' => 'btn btn-primary add-to-cart-btn',
                                'data' => [
                                    'product-id' => $model->id,
                                    'items' => 1,
                                ],
                            ]) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<?php
$js = <<< JS
$(document).on('click', '.pointer img', function() {
    var href = $(this).parent('.pointer').data('href');
    if (href) {
        window.location.href = href;
    }
});

$(document).on('click', '.add-to-cart-btn', function() {
    var productId = $(this).data('product-id');
    var items = $(this).data('items');
    add_product(productId, items);
});

function add_product(id, items) {
    console.log('Sending data: id=' + id + ', items=' + items);

    let form = new FormData();
    form.append('id', id);
    form.append('items', items);

    fetch('/cart/create', {
        method: 'POST',
        body: form,
    })
    .then(response => response.json())  
    .then(result => {
        console.log(result);

        let title = document.getElementById('staticBackdropLabel');
        let body = document.getElementById('modalBody');

        if (result.success) {
            title.innerText = 'Информационное сообщение';
            body.innerHTML = '<p>Товар успешно добавлен в корзину</p>';
        } else {
            title.innerText = 'Ошибка';
            body.innerHTML = '<p>' + result.message + '</p>';
        }

        let myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
        myModal.show();

        let closeButton = document.querySelector('#staticBackdrop .btn-close');
        closeButton.addEventListener('click', function() {
            myModal.hide();
        });
    })
    .catch(error => {
        console.log('Fetch request failed:', error);
    });
}

JS;
$this->registerJs($js);
?>
