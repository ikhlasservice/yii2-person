<?php

namespace backend\modules\persons\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "religion".
 *
 * @property integer $id
 * @property string $title
 *
 * @property PersonDetail[] $personDetails
 */
class Religion extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'religion';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title'], 'string', 'max' => 200],
            [['title'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('person', 'รหัสศาสนา'),
            'title' => Yii::t('person', 'ศาสนา'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonDetails() {
        return $this->hasMany(PersonDetail::className(), ['religion_id' => 'id']);
    }

    public static function getList() {
        return ArrayHelper::map(self::find()->orderBy([
                            'id' => SORT_ASC,
                        ])->all(), 'id', 'title');
    }

}
