<?php

namespace ikhlas\persons\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "nationality".
 *
 * @property integer $id
 * @property string $title
 *
 * @property PersonDetail[] $personDetails
 */
class Nationality extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nationality';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 100],
            [['title'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('person', 'รหัสสัญชาติ'),
            'title' => Yii::t('person', 'สัญชาติ'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonDetails()
    {
        return $this->hasMany(PersonDetail::className(), ['nationality_id' => 'id']);
    }
    
    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(),'id','title');
    }
}
