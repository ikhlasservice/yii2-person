<?php

namespace backend\modules\persons\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $no
 * @property string $alley
 * @property string $village
 * @property integer $mu
 * @property string $road
 * @property integer $tambol_id
 * @property integer $amphur_id
 * @property integer $province_id
 * @property integer $zip_code
 * @property string $type
 *
 * @property LocalAmphur $amphur
 * @property LocalProvince $province
 * @property LocalTambol $tambol
 * @property Person[] $people
 * @property Person[] $people0
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['no','tambol_id', 'amphur_id', 'province_id'], 'required'],
            [['mu', 'tambol_id', 'amphur_id', 'province_id', 'zip_code'], 'integer'],
            [['type'], 'string'],
            [['no'], 'string', 'max' => 5],
            [['alley', 'village', 'road'], 'string', 'max' => 100],
            [['contactBy'], 'default', 'value' => 1]
        ];
    }
    public $contactBy;
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('person', 'รหัสที่อยู่'),
            'no' => Yii::t('person', 'เลขที่'),
            'alley' => Yii::t('person', 'ซอย'),
            'village' => Yii::t('person', 'หมู่บ้าน'),
            'mu' => Yii::t('person', 'หมู่ที่'),
            'road' => Yii::t('person', 'ถนน'),
            'tambol_id' => Yii::t('person', 'ตำบล'),
            'amphur_id' => Yii::t('person', 'อำเภอ'),
            'province_id' => Yii::t('person', 'จังหวัด'),
            'zip_code' => Yii::t('person', 'รหัสไปรษณีย์'),
            'type' => Yii::t('person', 'ประเภทที่อยู่อาศัย'),
            'contactBy' => Yii::t('person', 'ที่อยู่ที่สามารถติดต่อได้'),
        ];
    }

    public static function itemsAlias($key) {
        $items = [
            'contactBy' => [
                1 => Yii::t('person', 'ตามบัตรประชาชน'),
                2 => Yii::t('person', 'ที่อยู่อื่นระบุ')
            ],   
        ];
        return ArrayHelper::getValue($items, $key, []);
    }
    
    public function getContactByLabel() {
        return ArrayHelper::getValue($this->getItemContactBy(), $this->contactBy);
    }

    public static function getItemContactBy() {
        return self::itemsAlias('contactBy');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAmphur()
    {
        return $this->hasOne(LocalAmphur::className(), ['id' => 'amphur_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(LocalProvince::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTambol()
    {
        return $this->hasOne(LocalTambol::className(), ['id' => 'tambol_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasMany(Person::className(), ['contact_address_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeople0()
    {
        return $this->hasMany(Person::className(), ['address_id' => 'id']);
    }
    
     public static function itemAmphurList($id) {
        $datas = [];
        $datas = LocalAmphur::find()->where(['province_id' => $id])->all();
        return  ArrayHelper::map($datas,'id','name');
    }    
    
    public static function itemTambolList($id) {
        $datas = [];
        $datas = LocalTambol::find()->where(['amphur_id' => $id])->all();
        return  ArrayHelper::map($datas,'id','name');
    }    
    
}
