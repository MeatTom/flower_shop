<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Items $model */

$this->title = 'Update Items: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['catalog']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="items-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
