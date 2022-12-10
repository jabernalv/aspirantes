<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ArchivoAspirante;

/**
 * ArchivoAspiranteSearch represents the model behind the search form of `common\models\ArchivoAspirante`.
 */
class ArchivoAspiranteSearch extends ArchivoAspirante
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid', 'aspirante_uuid', 'comentarios_aspirante', 'ruta_web', 'md5', 'created_at', 'modified_at'], 'safe'],
            [['tipo_archivo_aspirante_id'], 'integer'],
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
        $query = ArchivoAspirante::find();

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
            'tipo_archivo_aspirante_id' => $this->tipo_archivo_aspirante_id,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid])
            ->andFilterWhere(['like', 'aspirante_uuid', $this->aspirante_uuid])
            ->andFilterWhere(['like', 'comentarios_aspirante', $this->comentarios_aspirante])
            ->andFilterWhere(['like', 'ruta_web', $this->ruta_web])
            ->andFilterWhere(['like', 'md5', $this->md5]);

        return $dataProvider;
    }
}
