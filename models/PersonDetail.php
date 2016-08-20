<?php

namespace backend\modules\persons\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "person_detail".
 *
 * @property integer $person_id
 * @property integer $nationality_id
 * @property integer $religion_id
 * @property string $person_status
 * @property integer $numberOfChildren
 * @property integer $degree_id
 * @property string $date_of_issue
 * @property string $date_of_expiry
 *
 * @property Person $person
 */
class PersonDetail extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'person_detail';
    }

    
    
    
    public function behaviors() {
        return [
                       [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'date_of_issue',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'date_of_issue',
                ],
                'value' => function ($event) {
            if ($this->date_of_issue) {
                $date = \DateTime::createFromFormat('d/m/Y', $this->date_of_issue);
                return $date?$date->format('Y-m-d'):$this->date_of_issue;
            }
        }
            ],
                       [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'date_of_expiry',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'date_of_expiry',
                ],
                'value' => function ($event) {
            if ($this->date_of_expiry) {
                $date = \DateTime::createFromFormat('d/m/Y', $this->date_of_expiry);
                return $date?$date->format('Y-m-d'):$this->date_of_expiry;
            }
        }
            ],
        ];
    }

    
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['person_id', 'person_status'], 'required'],
            [['person_id', 'nationality_id', 'religion_id', 'numberOfChildren', 'degree_id'], 'integer'],
            [['person_status'], 'string'],
            [['date_of_issue', 'date_of_expiry'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'person_id' => Yii::t('person', 'Person ID'),
            'nationality_id' => Yii::t('person', 'สัญชาติ'),
            'religion_id' => Yii::t('person', 'ศาสนา'),
            'person_status' => Yii::t('person', 'สถานภาพการสมรส'),
            'numberOfChildren' => Yii::t('person', 'จำนวนบุตร/ธิดา'),
            'degree_id' => Yii::t('person', 'วุฒิการศึกษา'),
            'date_of_issue' => Yii::t('person', 'วันที่ออกบัตร'),
            'date_of_expiry' => Yii::t('person', 'วันที่หมดอายุ'),
        ];
    }

    public static function itemsAlias($key) {
        $items = [
            'person_status' => [
                1 => Yii::t('app', 'โสด'),
                2 => Yii::t('app', 'หย่า'),
                3 => Yii::t('app', 'สมรส')
            ],            
        ];
        return ArrayHelper::getValue($items, $key, []);
    }
    
    public function getPersonStatusLabel() {
        return ArrayHelper::getValue($this->getItemPersonStatus(), $this->person_status);
    }

    public static function getItemPersonStatus() {
        return self::itemsAlias('person_status');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson() {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }

    public function getNationality() {
        return $this->hasOne(Nationality::className(), ['id' => 'nationality_id']);
    }

    public function getReligion() {
        return $this->hasOne(Religion::className(), ['id' => 'religion_id']);
    }

    public function getDegree() {
        return $this->hasOne(Degree::className(), ['id' => 'degree_id']);
    }

}
