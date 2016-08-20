<?php

namespace ikhlas\persons\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "degree".
 *
 * @property integer $id
 * @property string $title
 *
 * @property PersonDetail[] $personDetails
 */
class Degree extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'degree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('person', 'รหัสวุฒิการศึกษา'),
            'title' => Yii::t('person', 'วุฒิการศึกษา'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonDetails()
    {
        return $this->hasMany(PersonDetail::className(), ['degree_id' => 'id']);
    }
    
    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(),'id','title');
    }
}
