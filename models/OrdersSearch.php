<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class OrdersSearch extends Orders
{
    public function rules()
    {
        return [
            [['status'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Orders::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
