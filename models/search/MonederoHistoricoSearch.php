<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MonederoHistorico;

/**
 * MonederoHistoricoSearch represents the model behind the search form about `app\models\MonederoHistorico`.
 */
class MonederoHistoricoSearch extends MonederoHistorico
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'monedero_id', 'terminal_id'], 'integer'],
            [['fecha_hora', 'tipo_operacion', 'concepto'], 'safe'],
            [['importe'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = MonederoHistorico::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSizeLimit' => [20, 200],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'monedero_id' => $this->monedero_id,
            'terminal_id' => $this->terminal_id,
            'fecha_hora' => $this->fecha_hora,
            'importe' => $this->importe,
        ]);

        $query->andFilterWhere(['like', 'tipo_operacion', $this->tipo_operacion])
            ->andFilterWhere(['like', 'concepto', $this->concepto]);

        return $dataProvider;
    }
}
