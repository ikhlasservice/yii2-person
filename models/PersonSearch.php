<?php

namespace backend\modules\persons\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\persons\models\Person;

/**
 * PersonSearch represents the model behind the search form about `backend\modules\persons\models\Person`.
 */
class PersonSearch extends Person {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'id_card', 'prefix_id', 'address_id', 'contact_address_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'surname', 'name_en', 'surname_en', 'birthday', 'sex', 'telephone', 'home_phone', 'email', 'facebook', 'doc_delivery', 'img_id'], 'safe'],
            [['fullname'], 'safe'],
        ];
    }

    public $fullname;

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Person::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'fullname' => [
                    'asc' => ['name' => SORT_ASC, 'surname' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC, 'surname' => SORT_DESC],
                    'label' => 'Full Name',
                    'default' => SORT_ASC
                ],
            ]
        ]);




        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_card' => $this->id_card,
            'prefix_id' => $this->prefix_id,
            'birthday' => $this->birthday,
            'address_id' => $this->address_id,
            'contact_address_id' => $this->contact_address_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'surname', $this->surname])
                ->andFilterWhere(['like', 'name_en', $this->name_en])
                ->andFilterWhere(['like', 'surname_en', $this->surname_en])
                ->andFilterWhere(['like', 'sex', $this->sex])
                ->andFilterWhere(['like', 'telephone', $this->telephone])
                ->andFilterWhere(['like', 'home_phone', $this->home_phone])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'facebook', $this->facebook])
                ->andFilterWhere(['like', 'doc_delivery', $this->doc_delivery])
                ->andFilterWhere(['like', 'img_id', $this->img_id]);

        $query->andWhere('name LIKE "%' . $this->fullname . '%" ' .
                'OR surname LIKE "%' . $this->fullname . '%"'
        );

        return $dataProvider;
    }

}
