<?php

namespace ikhlas\persons\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\modules\image\models\Image;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "person".
 *
 * @property integer $id
 * @property string $id_card
 * @property integer $prefix_id
 * @property string $name
 * @property string $surname
 * @property string $name_en
 * @property string $surname_en
 * @property string $birthday
 * @property string $sex
 * @property integer $address_id
 * @property integer $contact_address_id
 * @property string $telephone
 * @property string $home_phone
 * @property string $email
 * @property string $facebook
 * @property string $doc_delivery
 * @property string $img_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Customer[] $customers
 * @property TbAddress $contactAddress
 * @property TbAddress $address
 * @property Image $img
 * @property Prefix $prefix
 * @property PersonCareer $personCareer
 * @property PersonContact $personContact
 * @property PersonDetail $personDetail
 * @property PersonSpouse $personSpouse
 * @property RegisterCustomer[] $registerCustomers
 * @property RegisterSeller[] $registerSellers
 * @property Seller[] $sellers
 * @property Staff[] $staff
 */
class Person extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'person';
    }

    public function behaviors() {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'id_card',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'id_card',
                ],
                'value' => function ($event) {
            return str_replace('-', '', $this->id_card);
        }
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'birthday',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'birthday',
                ],
                'value' => function ($event) {
            if ($this->birthday) {
                $date = \DateTime::createFromFormat('d/m/Y', $this->birthday);
                return $date?$date->format('Y-m-d'):$this->birthday;
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
            //[['id_card', 'name', 'surname', 'birthday', 'sex', 'telephone'], 'required'],
            [['id_card', 'name', 'surname', 'birthday', 'sex',], 'required'],
            [['telephone', 'email'], 'required', 'on' => 'contact'],
            [['doc_delivery'], 'required', 'on' => 'document'],
            [['prefix_id', 'address_id', 'contact_address_id', 'created_at', 'updated_at'], 'integer'],
            [['birthday'], 'safe'],
            //[['birthday'], 'string' , 'max'=>date('Y-m-d')],
            [['sex', 'doc_delivery'], 'string'],
            [['name', 'surname', 'name_en', 'surname_en'], 'string', 'max' => 100],
            [['telephone'], 'string', 'max' => 32],
            [['home_phone'], 'string', 'max' => 10],
            [['email', 'facebook', 'img_id'], 'string', 'max' => 50],
            [['img_id'], 'default', 'value' => null]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('person', 'รหัสบุคคล'),
            'id_card' => Yii::t('person', 'รหัสบัตรประชาชน'),
            'prefix_id' => Yii::t('person', 'คำนำหน้า'),
            'name' => Yii::t('person', 'ชื่อ'),
            'surname' => Yii::t('person', 'นามสกุล'),
            'name_en' => Yii::t('person', 'ชื่อ(ภาษาอังกฤษ)'),
            'surname_en' => Yii::t('person', 'นามสกุล(ภาษาอังกฤษ)'),
            'birthday' => Yii::t('person', 'เกิดเมื่อ วันที่'),
            'sex' => Yii::t('person', 'เพศ'),
            'address_id' => Yii::t('person', 'ที่อยู่ตามบัตร'),
            'contact_address_id' => Yii::t('person', 'ที่อยู่สามารถที่ติดต่อได้'),
            'telephone' => Yii::t('person', 'เบอร์โทรศัพท์ (มือถือ)'),
            'home_phone' => Yii::t('person', 'เบอร์โทรศัพท์ (บ้าน)'),
            'email' => Yii::t('person', 'E-mail'),
            'facebook' => Yii::t('person', 'Facebook'),
            'doc_delivery' => Yii::t('person', 'สถานที่ที่สะดวกให้จัดส่งเอกสาร'),
            'img_id' => Yii::t('person', 'รูปประจำตัว'),
            'created_at' => Yii::t('person', 'สร้างเมื่อ'),
            'updated_at' => Yii::t('person', 'ปรับปรุงเมื่อ'),
            'fullname' => Yii::t('person', 'ชื่อ-สกุล'),
            'fullname_en' => Yii::t('person', 'ชื่อ-สกุล(อังกฤษ)'),
            'phone' => Yii::t('person', 'เบอร์ติดต่อ'),
            'address' => Yii::t('person', 'ที่อยู่ตามบัตร'),
            'address_contact' => Yii::t('person', 'ที่อยู่'),
        ];
    }

    public function attributeHints() {
        return [
            'birthday' => Yii::t('person', 'พิมพ์ วัน/เดือน/ปี(ค.ศ.)'),
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();

        $scenarios['contact'] = ['telephone', 'email', 'home_phone', 'facebook'];
        $scenarios['document'] = ['doc_delivery'];

        return $scenarios;
    }

    public static function itemsAlias($key) {
        $items = [
            'sex' => [
                1 => Yii::t('app', 'ชาย'),
                2 => Yii::t('app', 'หญิง')
            ],
            'status' => [
                1 => Yii::t('app', 'โสด'),
                2 => Yii::t('app', 'หย่า'),
                3 => Yii::t('app', 'สมรส')
            ],
            'docDelivery' => [
                1 => Yii::t('app', 'ตามข้อมูลประวัติส่วนตัว'),
                2 => Yii::t('app', 'ตามข้อมูลติดต่อ'),
                3 => Yii::t('app', 'ตามข้อมูลการทำงาน')
            ],
        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public function getSexLabel() {
        return ArrayHelper::getValue($this->getItemSex(), $this->sex);
    }

    public static function getItemSex() {
        return self::itemsAlias('sex');
    }

    public function getStatusLabel() {
        return ArrayHelper::getValue($this->getItemStatus(), $this->status);
    }

    public static function getItemStatus() {
        return self::itemsAlias('status');
    }

    public function getDocDeliveryLabel() {
        return ArrayHelper::getValue($this->getItemDocDelivery(), $this->doc_delivery);
    }

    public static function getItemDocDelivery() {
        return self::itemsAlias('docDelivery');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers() {
        return $this->hasMany(Customer::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactAddress() {
        return $this->hasOne(ContactAddress::className(), ['id' => 'contact_address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress() {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImg() {
        return $this->hasOne(Image::className(), ['id' => 'img_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrefix() {
        return $this->hasOne(Prefix::className(), ['id' => 'prefix_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonCareer() {
        return $this->hasOne(PersonCareer::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonContact() {
        return $this->hasOne(PersonContact::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonDetail() {
        return $this->hasOne(PersonDetail::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonSpouse() {
        return $this->hasOne(PersonSpouse::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegisterCustomers() {
        return $this->hasMany(RegisterCustomer::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegisterSellers() {
        return $this->hasMany(RegisterSeller::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSellers() {
        return $this->hasMany(Seller::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff() {
        return $this->hasMany(Staff::className(), ['person_id' => 'id']);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    ###########################################
    ###########################################

    public function getFullname() {
        return ($this->prefix_id ? $this->prefix->title : "") . " " . $this->name . " " . $this->surname;
    }

    public function getFullname_en() {
        return ($this->prefix_id ? $this->prefix->title_en : "") . " " . $this->name_en . " " . $this->surname_en;
    }

    public static function getPrefixList() {
        return ArrayHelper::map(Prefix::find()->all(), 'id', 'title');
    }

    public function getAsBirthday() {
        return Yii::$app->formatter->asDate($this->birthday);
    }

    const UPLOAD_FOLDER = 'persons';

    public function getImage() {
        if (isset($this->img)) {
            return Yii::$app->img->getUploadThumbnailUrl(self::UPLOAD_FOLDER . '/' . $this->id) . $this->img->id;
        } else {
            return Yii::$app->img->getUploadUrl() . Yii::$app->img->no_img;
        }
    }

    public function getPhone() {
        return implode(', ', [$this->telephone, $this->home_phone]);
    }

    public function getAddressContact() {
        $str = [];
        if ($model = $this->contactAddress) {
            $str[] = $model->no;
            $str[] = $model->alley;
            $str[] = $model->road ? 'ถ.' . $model->road : '';
            $str[] = $model->mu ? 'ม.' . $model->mu : '';
            $str[] = $model->village ? 'หมู่บ้าน.' . $model->village : '';
            $str[] = $model->tambol_id ? 'ต.' . $model->tambol->name : '';
            $str[] = $model->amphur_id ? 'อ.' . $model->amphur->name : '';
            $str[] = $model->province_id ? 'จ.' . $model->province->name : '';
            $str[] = $model->zip_code;
            $str = array_filter($str);
        }
        return $str ? implode(' ', $str) : NULL;
    }

    public function getOwnAddress() {
        $str = [];
        if ($model = $this->address) {
            $str[] = $model->no ? 'บ้านเลขที่ ' . $model->no : '';
            $str[] = $model->alley ? 'ซ.' . $model->alley : '';
            $str[] = $model->road ? 'ถ.' . $model->road : '';
            $str[] = $model->mu ? 'ม.' . $model->mu : '';
            $str[] = $model->village ? 'หมู่บ้าน.' . $model->village : '';
            $str[] = $model->tambol_id ? 'ต.' . $model->tambol->name : '';
            $str[] = $model->amphur_id ? 'อ.' . $model->amphur->name : '';
            $str[] = $model->province_id ? 'จ.' . $model->province->name : '';
            $str[] = $model->zip_code;
            $str = array_filter($str);
        }
        return $str ? implode(' ', $str) : NULL;
    }

}
