<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * User represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
    public $nombreCompleto;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nivel_permisos'], 'integer'],
            [['nombre', 'apellidos', 'email', 'password', 'tag_rfid', 'nombreCompleto', 'dni'], 'safe'],
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
        $query = User::find();

        //$query->where('usuario.id != 1');

        $query->orderBy('nombre');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSizeLimit' => [50, 100,200,500],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'nivel_permisos' => $this->nivel_permisos,
            'dni' => $this->dni,
            'tag_rfid' => $this->tag_rfid,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password]);

        $query->andFilterWhere(['like', 'concat(nombre, " ", apellidos)', $this->nombreCompleto]);



        return $dataProvider;
    }
}
