<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Cart".
 *
 * @property int $id
 * @property int $itemId
 * @property int $amount
 * @property int $userId
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Cart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['itemId', 'amount', 'userId'], 'required'],
            [['itemId', 'amount', 'userId'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'itemId' => 'ID товара',
            'amount' => 'Количество',
            'userId' => 'ID пользователя',
        ];
    }
}
