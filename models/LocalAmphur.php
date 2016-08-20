<?php

namespace ikhlas\persons\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "local_amphur".
 *
 * @property integer $id
 * @property string $name
 * @property integer $province_id
 *
 * @property Address[] $addresses
 */
class LocalAmphur extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'local_amphur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'province_id'], 'required'],
            [['id', 'province_id'], 'integer'],
            [['name'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('person', 'รหัสอำเภอ'),
            'name' => Yii::t('person', 'อำเภอ'),
            'province_id' => Yii::t('person', 'รหัสจังหวัด'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['amphur_id' => 'id']);
    }
    
    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(),'id','name');
    }
}
