<?php

namespace aditiya\easyfilemanager\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use aditiya\easyfilemanager\models\Easyfilemanager;

/**
 * EasyfilemanagerSearch represents the model behind the search form of `app\modules\easy_file_manager\models\Easyfilemanager`.
 */
class EasyfilemanagerSearch extends Easyfilemanager
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key', 'name', 'extension', 'category', 'description', 'mimetype', 'roles', 'created_at', 'filepath'], 'safe'],
            [['size'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Easyfilemanager::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'size' => $this->size,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'extension', $this->extension])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'mimetype', $this->mimetype])
            ->andFilterWhere(['like', 'roles', $this->roles])
            ->andFilterWhere(['like', 'filepath', $this->filepath]);

        return $dataProvider;
    }
}
