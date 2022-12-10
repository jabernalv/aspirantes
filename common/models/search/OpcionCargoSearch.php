<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OpcionCargo;

/**
 * OpcionCargoSearch represents the model behind the search form of `common\models\OpcionCargo`.
 */
class OpcionCargoSearch extends OpcionCargo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cargo_id', 'requiere_titulo'], 'integer'],
            [['opcion', 'created_at', 'modified_at'], 'safe'],
            [['anios_experiencia_profesional', 'anios_experiencia_relacionada'], 'number'],
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
        $query = OpcionCargo::find();

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
            'id' => $this->id,
            'cargo_id' => $this->cargo_id,
            'requiere_titulo' => $this->requiere_titulo,
            'anios_experiencia_profesional' => $this->anios_experiencia_profesional,
            'anios_experiencia_relacionada' => $this->anios_experiencia_relacionada,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'opcion', $this->opcion]);

        return $dataProvider;
    }
}
