<?php

namespace ikhlas\persons\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "career".
 *
 * @property integer $id
 * @property string $title
 * @property integer $created_by
 *
 * @property PersonCareer[] $personCareers
 */
class Career extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'career';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by'], 'integer'],
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
            'id' => Yii::t('person', 'รหัสอาชีพ'),
            'title' => Yii::t('person', 'อาชีพ'),
            'created_by' => Yii::t('person', 'Created By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonCareers()
    {
        return $this->hasMany(PersonCareer::className(), ['career_id' => 'id']);
    }
    
    
    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(),'id','title')+['0'=>'อื่นๆ ระบุ'];
    }
}
