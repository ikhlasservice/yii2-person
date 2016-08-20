<?php

namespace backend\modules\persons\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "person_career".
 *
 * @property integer $person_id
 * @property integer $career_id
 * @property string $career_title
 * @property string $position_title
 * @property string $working_age
 * @property string $workplace_title
 * @property string $workplace_no
 * @property string $workplace_village
 * @property string $workplace_noRoom
 * @property string $workplace_class
 * @property integer $workplace_mu
 * @property string $workplace_alley
 * @property string $workplace_road
 * @property integer $tambol_id
 * @property integer $amphur_id
 * @property integer $province_id
 * @property integer $zip_code
 * @property string $workplace_phone
 * @property string $workplace_fax
 * @property string $salary
 * @property string $income_other
 * @property string $expenses
 *
 * @property Person $person
 * @property Career $career
 */
class PersonCareer extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'person_career';
    }

    public function behaviors() {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'salary',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'salary',
                ],
                'value' => function ($event) {
            return str_replace(',', '', $this->salary);
        }
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['person_id', 'career_id'], 'required'],
            [['person_id', 'career_id', 'workplace_mu', 'tambol_id', 'amphur_id', 'province_id', 'zip_code'], 'integer'],
            [['salary'], 'safe'],
            [['income_other', 'expenses'], 'string'],
            [['career_title', 'position_title', 'workplace_village', 'workplace_alley', 'workplace_road'], 'string', 'max' => 100],
            [['working_age'], 'string', 'max' => 14],
            [['workplace_title'], 'string', 'max' => 200],
            [['workplace_no'], 'string', 'max' => 8],
            [['workplace_noRoom', 'workplace_fax'], 'string', 'max' => 10],
            [['workplace_class'], 'string', 'max' => 3],
            [['workplace_phone'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'person_id' => Yii::t('person', 'บุคคล'),
            'career_id' => Yii::t('person', 'อาชีพ'),
            'career_title' => Yii::t('person', 'อาชีพ'),
            'position_title' => Yii::t('person', 'ตำแหน่งอาชีพ'),
            'working_age' => Yii::t('person', 'อายุงาน'),
            'workplace_title' => Yii::t('person', 'สถานที่ทำงาน ชื่อบริษัทหรือองค์กร'),
            'workplace_no' => Yii::t('person', 'เลขที่'),
            'workplace_village' => Yii::t('person', 'หมู่บ้าน/อาคาร'),
            'workplace_noRoom' => Yii::t('person', 'เลขที่ห้อง'),
            'workplace_class' => Yii::t('person', 'ชั้น'),
            'workplace_mu' => Yii::t('person', 'หมู่ที่'),
            'workplace_alley' => Yii::t('person', 'ตรอก/ซอย'),
            'workplace_road' => Yii::t('person', 'ถนน'),
            'tambol_id' => Yii::t('person', 'ตำบล'),
            'amphur_id' => Yii::t('person', 'อำเภอ'),
            'province_id' => Yii::t('person', 'จังหวัด'),
            'zip_code' => Yii::t('person', 'รหัสไปรษณีย์'),
            'workplace_phone' => Yii::t('person', 'โทรศัพท์'),
            'workplace_fax' => Yii::t('person', 'โทรสาร'),
            'salary' => Yii::t('person', 'เงินเดือน/รายได้ประจำ'),
            'income_other' => Yii::t('person', 'รายได้อื่นๆ'),
            'expenses' => Yii::t('person', 'ค่าใช้จ่ายประจำเดือน'),
            'address' => Yii::t('person', 'ที่อยู่'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson() {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCareer() {
        return $this->hasOne(Career::className(), ['id' => 'career_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAmphur() {
        return $this->hasOne(LocalAmphur::className(), ['id' => 'amphur_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince() {
        return $this->hasOne(LocalProvince::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTambol() {
        return $this->hasOne(LocalTambol::className(), ['id' => 'tambol_id']);
    }

    public function getAddress() {
        $str = [];
        if ($model = $this) {
            $str[] = $model->workplace_no ? 'บ้านเลขที่ ' . $model->workplace_no : '';
            $str[] = $model->workplace_alley ? 'ซ.' . $model->workplace_alley : '';
            $str[] = $model->workplace_road ? 'ถ.' . $model->workplace_road : '';
            $str[] = $model->workplace_mu ? 'ม.' . $model->workplace_mu : '';
            $str[] = $model->workplace_village ? 'หมู่บ้าน.' . $model->workplace_village : '';
            $str[] = $model->tambol_id ? 'ต.' . $model->tambol->name : '';
            $str[] = $model->amphur_id ? 'อ.' . $model->amphur->name : '';
            $str[] = $model->province_id ? 'จ.' . $model->province->name : '';
            $str[] = $model->zip_code;
            $str = array_filter($str);
        }
        return $str ? implode(' ', $str) : NULL;
    }

}
