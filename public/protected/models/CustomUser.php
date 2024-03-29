<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $email
 * @property string $password
 * @property string $firstName
 * @property string $lastName
 * @property string $patronymic
 * @property string $phone
 * @property string $gender
 * @property integer $birthday
 * @property string $address
 * @property integer $date_registration
 * @property integer $inn
 * @property string $token
 * @property string $role
 * @property string $status
 */
class CustomUser extends CActiveRecord
{
	public $verifyCode;
	public $userVote;
	public $postIndex;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, firstName, lastName, patronymic, phone, birthday, address, postIndex, inn', 'required'),
			//array('birthday, date_registration, inn', 'numerical', 'integerOnly'=>true),
			array('verifyCode', 'required'),
			array('verifyCode', 'ext.yiiReCaptcha.ReCaptchaValidator'),
//			array('verifyCode', 'reCaptchaValidator'),
			array('email', 'length', 'max'=>100),
			//array('password', 'length', 'min'=>6),
			array('email','email'),
			['email', 'filter', 'filter' => 'trim'],
//			['email', 'unique'],
//			['phone', 'unique'],
			['inn', 'checkInn'],
			//['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
			//['username', 'string', 'min' => 2, 'max' => 255],
			['inn', 'length', 'min' => 10, 'max' => 10],
			['inn', 'numerical', 'integerOnly' => TRUE,],
			//['birthday', 'length', 'max'=>10],
			array('firstName, lastName, phone', 'length', 'max'=>45),
			['phone', 'match', 'pattern' => '/^\+38\([0-9]{3}\)\s[0-9]{3}\s[0-9]{2}\s[0-9]{2}$/', 'message' => 'Телефон введений невірно' ],
			['phone', 'checkMobilePhone'],
//			['birthday', 'match', 'pattern' => '/^\[0-9]{2}.[0-9]{2}.[0-9]{4}$/', 'message' => 'Дата рождения должна быть формата dd.mm.yyyy' ],
			array('birthday', 'date','format'=>'dd.MM.yyyy','allowEmpty'=>false,'message'=>'Дата народження повинна бути формату dd.mm.yyyy.'),
			['birthday', 'checkBirthdayRange'],
			array('patronymic', 'length', 'max'=>50),
			array('social_status, role', 'length', 'max'=>15),
			array('address, token', 'length', 'max'=>255),
			array('postIndex', 'length', 'max'=>6, 'min'=>6),
			array('role', 'length', 'max'=>15),
			array('lastName', 'match', 'pattern' => '/^[А-яҐЄІЇЁґєіїё\s]+$/u', 'message' => 'Поле "Прізвище" може містити тільки кирилицю'),
			array('patronymic', 'match', 'pattern' => '/^[А-яҐЄІЇЁґєіїё\s]+$/u', 'message' => 'Поле "По батькові" може містити тільки кирилицю'),
			array('firstName', 'match', 'pattern' => '/^[А-яҐЄІЇЁґєіїё\s]+$/u', 'message' => 'Поле "Ім\'я" може містити тільки кирилицю'),
			array('status', 'length', 'max'=>10),
			array('status', 'length', 'max'=>10),
			array('password', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, password, firstName, lastName, patronymic, phone, social_status, birthday, address, postIndex, date_registration, inn, token, role, status, userVote', 'safe', 'on'=>'search'),
		);
	}

	public function checkMobilePhone($attribute,$params)
	{
		if(!$this->checkMibilePhoneNumber($this->$attribute))
			$this->addError($attribute, 'Ваш номер телефону не є мобільним '.$this->$attribute);
	}

	public function checkInn($attribute,$params)
	{
		$res=Yii::app()->db->createCommand("SELECT status FROM `user` where inn = '{$this->$attribute}'")->queryRow();

		if($res['status'] == 1){
			$this->addError($attribute, 'Такий ІПН вже існує в системі');
		}


	}

	public function checkUser($status = User::STATUS_TEMPL)
	{


//		if(!empty($this->inn) && !empty($this->birthday) && !empty($this->firstName) && !empty($this->lastName) && !empty($this->patronymic)){
		if(!empty($this->email)){
			
			$user = User::model()->findByAttributes([
				'email'=>$this->email,
				'status'=>$status,
			]);
			
			
			if(null === $user){
				return false;
			}
			else{
				return $user;
				
			}
		}
		return false;
	}

	public function checkBirthdayRange($attribute,$params)
	{
		$birthUnix = strtotime($this->$attribute);
		$minAge = strtotime('today UTC -16 year');
		if($birthUnix > $minAge)
			$this->addError($attribute, 'Ваш вік не дозволяє реєструватися');
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

	protected function beforeSave()
	{
		if($this->isNewRecord)
		{
			$this->token = RandomStringHelper::generate(Yii::app()->config->get('countSymbol'), Yii::app()->config->get('numberAndSymbolString'));
			$this->date_registration = DateHelper::setCurrentDateTimeToTimestamp();
			$this->address = $this->postIndex . ' '. $this->address;
			$this->birthday = DateHelper::convertDateToTimeStamp($this->birthday);
			$this->password =  User::model()->createPasswordHash($this->password);
			$this->phone =  str_replace(['(',')','+',' '], '', $this->phone);
			if(empty($this->role)){
				$this->role = User::ROLE_MODERATOR;
			}
		}

		return parent::beforeSave();
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
			'birthday' => Yii::t('main','Дата рождения'),
			'address' => Yii::t('main','Адрес'),
			'date_registration' => 'Date Registration',
			'inn' => Yii::t('main','ИНН'),
			'token' => 'Token',
			'role' => 'Role',
			'status' => 'Status',
			'verifyCode'=>'Капча',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('firstName',$this->firstName,true);
		$criteria->compare('lastName',$this->lastName,true);
		$criteria->compare('patronymic',$this->patronymic,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('social_status',$this->social_status,true);
		$criteria->compare('birthday',$this->birthday);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('date_registration',$this->date_registration);
		$criteria->compare('inn',$this->inn);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('role',$this->role,true);
		$criteria->addCondition('role <> "'. User::ROLE_ADMIN.'"');
		//$criteria->compare('status',$this->status,true);
		$criteria->addCondition('status in ('.User::STATUS_AUTHORIZED.',2)');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> 1000,
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CustomUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
