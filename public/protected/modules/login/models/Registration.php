<?php

class Registration extends CActiveRecord
{

    public function tableName()
    {
        return 'user';
    }

//    public function rules()
//    {
//        return array(
//            array('firstName, lastName, email, phone, password',
//                'required',
//                'message'=>Yii::t('main','Необходимо заполнить поле "{attribute}"')
//                ),
//            array('firstName, lastName, phone', 'length', 'max'=>45),
//            array('email','email'),
//            array('email', 'unique','message'=>Yii::t('main','Пользователь с таким email уже существует.')),
//            array('password', 'length', 'min'=>Yii::app()->config->get('password_length')),
//            array('firstName, lastName, email, phone, password, date_registration, password, ip, role', 'safe')
//        );
//    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, password, firstName, lastName, patronymic, phone, birthday, address, inn', 'required'),
            array('email, password', 'length', 'max'=>100),
            array('password', 'length', 'min'=>6),
            array('email','email'),
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'unique'],
            ['phone', 'unique'],
            ['inn', 'unique'],
            ['inn', 'length', 'min' => 10, 'max' => 10],
            ['birthday', 'length', 'max'=>10],
            array('firstName, lastName, phone', 'length', 'max'=>45),
            ['phone', 'match', 'pattern' => '/^\+38\([0-9]{3}\)\s[0-9]{3}\s[0-9]{2}\s[0-9]{2}$/', 'message' => 'Телефон введений невірно' ],
            ['phone', 'checkMobilePhone'],
            array('birthday', 'date','format'=>'dd.MM.yyyy','allowEmpty'=>false,'message'=>'Дата народження повинна бути формату dd.mm.yyyy.'),
            ['birthday', 'checkBirthdayRange'],
            array('patronymic, ip', 'length', 'max'=>50),
            array('social_status, role', 'length', 'max'=>15),
            array('address, token, avatar', 'length', 'max'=>255),
            array('role', 'length', 'max'=>15),
            array('lastName', 'match', 'pattern' => '/^[А-яҐЄІЇЁґєіїё\s]+$/u', 'message' => 'Поле "Прізвище" може містити тільки кирилицю'),
            array('patronymic', 'match', 'pattern' => '/^[А-яҐЄІЇЁґєіїё\s]+$/u', 'message' => 'Поле "По батькові" може містити тільки кирилицю'),
            array('firstName', 'match', 'pattern' => '/^[А-яҐЄІЇЁґєіїё\s]+$/u', 'message' => 'Поле "Ім\'я" може містити тільки кирилицю'),
            array('status', 'length', 'max'=>10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, email, password, firstName, lastName, patronymic, phone, social_status, birthday, address, date_registration, inn, ip, token, avatar, role, status', 'safe', 'on'=>'search'),
        );
    }

    public function checkMobilePhone($attribute,$params)
    {


        if(!$this->checkMibilePhoneNumber($this->$attribute))
            $this->addError($attribute, 'Ваш номер телефону не є мобільним '.$this->$attribute);
    }

    public function checkBirthdayRange($attribute,$params)
    {
        $birthUnix = strtotime($this->$attribute);
        $minAge = strtotime('today UTC -16 year');
        if($birthUnix > $minAge)
            $this->addError($attribute, 'Ваш вік не дозволяє регестріровать');
    }

    public function checkMibilePhoneNumber($phones){
        $codeArray = array();
        $res=Yii::app()->db->createCommand('SELECT `code` FROM `mobile_phones_code`')->queryAll();

        if(function_exists('array_column')){
            $codeArray = array_column($res, 'code');
        }
        else{
            foreach ($res as $k => $v){
                $codeArray[] = $v['code'];
            }
        }

        $phones = trim($phones);

        if(mb_strlen($phones, 'UTF-8') >= 18){
            $pos = strpos($phones, '0');
            $tmp2 = substr($phones, $pos);

            $code = substr_replace($tmp2, '', -11);
            if(in_array($code, $codeArray)){
                return true;
            }
        }
        else{
            return false;
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'votings' => array(self::HAS_MANY, 'Voting', 'user_id'),
        );
    }

    protected function beforeSave()
    {
        if($this->isNewRecord)
        {
            $this->token = RandomStringHelper::generate(Yii::app()->config->get('countSymbol'), Yii::app()->config->get('numberAndSymbolString'));
            $this->date_registration = DateHelper::setCurrentDateTimeToTimestamp();
            $this->password =  User::model()->createPasswordHash($this->password);
            $this->ip =  Yii::app()->getRequest()->getUserHostAddress();
            $this->role = User::ROLE_USER;
        }
        
        return parent::beforeSave();
    }

//    public function attributeLabels()
//    {
//        return array(
//            'id' => 'ID',
//            'email' => 'Email',
//            'password' => Yii::t('main','Пароль'),
//            'firstName' => Yii::t('main','Имя'),
//            'lastName' => Yii::t('main','Фамилия'),
//            'phone' => Yii::t('main','Телефон'),
//            'social_name' => 'Social Name',
//            'social_id' => 'Social',
//            'social_link' => 'Social Link',
//            'gender' => 'Gender',
//            'birthday' => 'Birthday',
//            'date_registration' => 'Date Registraton',
//            'ip' => 'Ip',
////            'timezone' => 'Timezone',
//            'role' => 'Role',
//            'status' => 'Status',
//            'city_id' => Yii::t('main','город')
//        );
//    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'email' => 'Email',
            'password' => Yii::t('main','Пароль'),
            'firstName' => Yii::t('main','Имя'),
            'lastName' => Yii::t('main','Фамилия'),
            'patronymic' => Yii::t('main','Отчество'),
            'phone' => Yii::t('main','Номер мобильного телефона'),
            'social_status' => Yii::t('main','Социальный статут'),
            'birthday' => Yii::t('main','Дата рождения'),
            'address' => Yii::t('main','Адрес'),
            'date_registration' => 'Date Registration',
            'inn' => Yii::t('main','ИНН'),
            'ip' => 'Ip',
            'token' => 'Token',
            'avatar' => 'Avatar',
            'role' => 'Role',
            'status' => 'Status',
        );
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


    public function checkValidToken($ref)
    {
        $model = User::model()->find('token = :token',[':token'=>$ref]);

        if($model === null)
            return false;
        else{
            $model->status = User::STATUS_AUTHORIZED;
            $model->save();
            return $model;
        }
    }
}