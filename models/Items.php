<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
/**
 * This is the model class for table "Items".
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property float $price
 * @property string $country
 * @property int $category
 * @property string $color
 * @property int $amount
 * @property string $create_time
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'image', 'price', 'country', 'category', 'color', 'amount'], 'required'],
            [['image'], 'string'],
            [['price'], 'number'],
            [['category', 'amount'], 'integer'],
            [['create_time'], 'safe'],
            [['name', 'country', 'color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID товара',
            'name' => 'Название',
            'image' => 'Изображение',
            'price' => 'Цена',
            'country' => 'Страна-изготовитель',
            'category' => 'Категория',
            'color' => 'Цвет',
            'amount' => 'Количество в наличии',
            'create_time' => 'Дата создания',
        ];
    }

     /**
     * Связь с категорией
     * @return ActiveQuery
     */
    public function getCategoryRelation()
    {
        return $this->hasOne(Category::className(), ['id' => 'category']);
    }
}
