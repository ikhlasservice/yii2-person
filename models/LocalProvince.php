<?php

namespace ikhlas\persons\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "local_province".
 *
 * @property integer $id
 * @property string $name
 * @property integer $region_id
 *
 * @property Address[] $addresses
 */
class LocalProvince extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'local_province';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'region_id'], 'required'],
            [['id', 'region_id'], 'integer'],
            [['name'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('person', 'ID'),
            'name' => Yii::t('person', 'Name'),
            'region_id' => Yii::t('person', 'Region ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['province_id' => 'id']);
    }
    
    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(),'id','name');
    }
    
}
