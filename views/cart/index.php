<?php

use app\models\Cart;
use app\models\Items;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\bootstrap5\ButtonDropdown;
use yii\data\ActiveDataProvider;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Корзина';

$dataProvider = new ActiveDataProvider([
    'query' => Cart::find()->where(['userId' => Yii::$app->user->identity->id]),
]);

?>



<div class="cart-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <?php if (!empty($dataProvider->getModels())): ?>
            <?php foreach ($dataProvider->getModels() as $model): ?>
                <?php
                $item = Items::findOne($model->itemId);
                if (!$item) {
                    continue;
                }
                ?>
                <div class="col-md-12 mb-4">
                    <div class="card d-flex flex-row">
                        <?= Html::img($item->image, ['class' => 'card-img-left img-thumbnail', 'style' => 'width: 20%; height: 20%', 'alt' => 'Product Image']) ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= Html::encode($item->name) ?></h5>
                            <p class="card-text">Цена: <?= $item->price ?></p>
                            <p class="card-text card-text-quantity">Количество: <?= $model->amount ?></p>
                            <div class="btn-group">
                                <?= Html::a('-', ['cart/decrease', 'id' => $model->id], ['class' => 'btn btn-warning btn-decrease']) ?>
                                <?= Html::a('+', ['cart/increase', 'id' => $model->id], ['class' => 'btn btn-success btn-increase']) ?>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'Вы точно хотите удалить этот товар?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?= Html::a('Оформить заказ', 'javascript:void(0);', [
                'class' => 'btn btn-success btn-block mt-3',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#passwordModal',
            ]) ?>
        <?php else: ?>
            <div class="col-md-12 mb-4">
                <div class="alert alert-info">
                    <p>Ваша корзина пуста.</p>
                    <?= Html::a('Перейти в каталог', ['/items/catalog'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">Введите пароль</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="passwordForm">
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="submitOrder()">Подтвердить</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$js = <<< JS
$(document).ready(function() {
    window.submitOrder = function() {
        var password = document.getElementById('password').value;
        var orderButton = $('#orderButton');

        $.ajax({
            url: '/order/password',
            type: 'POST',
            dataType: 'json',
            data: { password: password },
            success: function(response) {
                var modalTitle = $('#modalTitle');
                var modalBody = $('#modalBody');

                if (response.success) {
                    if (orderButton.text().includes('Оформить заказ')) {
                        modalTitle.text('Заказ успешно подтвержден');
                        modalBody.text('Ваш заказ успешно оформлен. Благодарим за покупку!');
                        orderButton.attr('data-bs-toggle', 'modal');
                        orderButton.attr('data-bs-target', '#staticBackdrop');
                    } else {
                        window.location.href = '/order/checkout';
                    }
                } else {
                    modalTitle.text('Ошибка');
                    modalBody.text('Введен неправильный пароль. Пожалуйста, попробуйте еще раз.');
                }
            },
            error: function() {
                console.error('AJAX request failed.');
            }
        });
    };

    $(document).on('click', '.btn-increase, .btn-decrease', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $(e.target).closest('.card-body').find('.card-text-quantity').text('Количество: ' + response.amount);
                } else {
                    console.error('Failed to update quantity.');
                }
            },
            error: function() {
                console.error('AJAX request failed.');
            }
        });
    });
});
JS;

$this->registerJs($js);
?>




