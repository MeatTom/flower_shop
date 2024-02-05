<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "Orders".
 *
 * @property int $id
 * @property int $userId
 * @property string $order_time
 * @property int $idItem
 * @property int $amount
 * @property string $status
 * @property string|null $reason
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'idItem', 'amount'], 'required'],
            [['userId', 'idItem', 'amount'], 'integer'],
            [['order_time'], 'safe'],
            [['status'], 'string'],
            [['reason'], 'required', 'when' => function ($model) { 
                return $model->status === 'Отменен';}, 'whenClient' => "function (attribute, value) {
                return $('#orders-status').val() === 'Отменен';}"],
            [['reason'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID заказа',
            'userId' => 'ID пользователя',
            'order_time' => 'Время заказа',
            'idItem' => 'ID товара',
            'amount' => 'Количество',
            'status' => 'Статус',
            'reason' => 'Причина отмены',
        ];
    }

    /**
     * Связь с категорией
     * @return ActiveQuery
     */
    public function getItemRelation()
    {
        return $this->hasOne(Items::className(), ['id' => 'idItem']);
    }
}
