<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Category;

class ItemSearch extends Items
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Items::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['category' => $this->category]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function getCategoriesDropdown()
    {
        $categories = Category::find()->select(['id', 'name'])->distinct()->all();
    
        $dropdownItems = [];
        foreach ($categories as $category) {
            $dropdownItems[] = ['label' => $category->name, 'url' => ['index', 'ItemSearch[category]' => $category->id]];
        }
    
        return $dropdownItems;
    }
    

}
