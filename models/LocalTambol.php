<?php

namespace backend\modules\persons\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "local_tambol".
 *
 * @property integer $id
 * @property string $name
 * @property integer $peaple
 * @property integer $post
 * @property integer $amphur_id
 *
 * @property Address[] $addresses
 */
class LocalTambol extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'local_tambol';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'peaple', 'post', 'amphur_id'], 'required'],
            [['id', 'peaple', 'post', 'amphur_id'], 'integer'],
            [['name'], 'string'],
            [['id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('person', 'เลขตำบล'),
            'name' => Yii::t('person', 'ตำบล'),
            'peaple' => Yii::t('person', 'จำนวนประชากร'),
            'post' => Yii::t('person', 'รหัสไปรษณีย์'),
            'amphur_id' => Yii::t('person', 'เลขอำเภอ'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['tambol_id' => 'id']);
    }
    
    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(),'id','name');
    }
    
}
