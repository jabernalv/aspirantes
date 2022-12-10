<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AspiranteCargo;

/**
 * AspiranteCargoSearch represents the model behind the search form of `common\models\AspiranteCargo`.
 */
class AspiranteCargoSearch extends AspiranteCargo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'aspirante_uuid', 'created_at', 'modified_at'], 'safe'],
            [['cargo_id', 'estado_id'], 'integer'],
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
        $query = AspiranteCargo::find();

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
            'cargo_id' => $this->cargo_id,
            'estado_id' => $this->estado_id,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid])
            ->andFilterWhere(['like', 'aspirante_uuid', $this->aspirante_uuid]);

        return $dataProvider;
    }
}
