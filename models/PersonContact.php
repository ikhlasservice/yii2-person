<?php

namespace backend\modules\persons\models;

use Yii;

/**
 * This is the model class for table "person_contact".
 *
 * @property integer $person_id
 * @property integer $prefix_id
 * @property string $name
 * @property string $surname
 * @property string $relationship
 * @property string $address_no
 * @property string $address_alley
 * @property string $address_village
 * @property integer $address_mu
 * @property string $address_road
 * @property integer $tambol_id
 * @property integer $amphur_id
 * @property integer $province_id
 * @property integer $zip_code
 * @property string $tel_number
 * @property string $home_phone
 * @property string $email
 *
 * @property Person $person
 * @property Prefix $prefix
 */
class PersonContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person_id'], 'required'],
            [['person_id', 'prefix_id', 'address_mu', 'tambol_id', 'amphur_id', 'province_id', 'zip_code'], 'integer'],
            [['name', 'surname', 'address_alley', 'address_village', 'address_road'], 'string', 'max' => 100],
            [['relationship'], 'string', 'max' => 200],
            [['address_no'], 'string', 'max' => 8],
            [['tel_number'], 'string', 'max' => 32],
            [['home_phone'], 'string', 'max' => 10],
            [['email'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'person_id' => Yii::t('person', 'บุคคล'),
            'prefix_id' => Yii::t('person', 'คำนำหน้า'),
            'name' => Yii::t('person', 'ชื่อ'),
            'surname' => Yii::t('person', 'นามสกุล'),
            'relationship' => Yii::t('person', 'ความสัมพันธ์'),
            'address_no' => Yii::t('person', 'เลขที่'),
            'address_alley' => Yii::t('person', 'ซอย'),
            'address_village' => Yii::t('person', 'หมู่บ้าน'),
            'address_mu' => Yii::t('person', 'หมู่ที่'),
            'address_road' => Yii::t('person', 'ถนน'),
            'tambol_id' => Yii::t('person', 'ตำบล'),
            'amphur_id' => Yii::t('person', 'อำเภอ'),
            'province_id' => Yii::t('person', 'จังหวัด'),
            'zip_code' => Yii::t('person', 'รหัสไปรษณีย์'),
            'tel_number' => Yii::t('person', 'เบอร์โทรศัพท์ (มือถือ)'),
            'home_phone' => Yii::t('person', 'เบอร์โทรศัพท์ (บ้าน)'),
            'email' => Yii::t('person', 'Email'),
            'fullname' => Yii::t('person', 'ชื่อ-นามสกุล'),
            'address' => Yii::t('person', 'ที่อยู่'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrefix()
    {
        return $this->hasOne(Prefix::className(), ['id' => 'prefix_id']);
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

    
    public function getFullname()
    {
        return ($this->prefix_id?$this->prefix->title:"")." ".$this->name." ".$this->surname;
    }
    
    public function getAddress() {
        $str = [];
        if($model=$this){
            $str[]=$model->address_no?'บ้านเลขที่ '.$model->address_no:'';
            $str[]=$model->address_alley?'ซ.'.$model->address_alley:'';
            $str[]=$model->address_road?'ถ.'.$model->address_road:'';
            $str[]=$model->address_mu?'ม.'.$model->address_mu:'';
            $str[]=$model->address_village?'หมู่บ้าน.'.$model->address_village:'';
            $str[]=$model->tambol_id?'ต.'.$model->tambol->name:'';
            $str[]=$model->amphur_id?'อ.'.$model->amphur->name:'';
            $str[]=$model->province_id?'จ.'.$model->province->name:'';
            $str[]=$model->zip_code;
            $str = array_filter($str);
            
        }
        return $str?implode(' ', $str):NULL;
    }
}
