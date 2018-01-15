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
 * @property string $ip
 * @property string $token
 * @property string $avatar
 * @property string $role
 * @property string $status
 */
class CustomUser extends CActiveRecord
{
	/**
	 * @var
	 */
	public $rememberMe;
	
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
			array('email, password, firstName, lastName, patronymic, phone, birthday, address, date_registration, inn, ip, token, role', 'required'),
			//array('birthday, date_registration, inn', 'numerical', 'integerOnly'=>true),

			array('email, password', 'length', 'max'=>100),
			array('email','email'),
			['email', 'filter', 'filter' => 'trim'],
			['email', 'unique'],
			['phone', 'unique'],
			['inn', 'unique'],
			//['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
			//['username', 'string', 'min' => 2, 'max' => 255],
			['inn', 'length', 'min' => 10, 'max' => 10],
			['birthday', 'length', 'max'=>10],
			array('firstName, lastName, phone', 'length', 'max'=>45),
			['phone', 'match', 'pattern' => '/^\+38\([0-9]{3}\)\s[0-9]{3}\s[0-9]{2}\s[0-9]{2}$/', 'message' => ' Что-то не так' ],
//			['birthday', 'match', 'pattern' => '/^\[0-9]{2}.[0-9]{2}.[0-9]{4}$/', 'message' => 'Дата рождения должна быть формата dd.mm.yyyy' ],
			array('birthday', 'date','format'=>'dd.MM.yyyy','allowEmpty'=>false,'message'=>'Дата рождения должна быть формата dd.mm.yyyy.'),
			array('patronymic, ip', 'length', 'max'=>50),
			array('social_status, role', 'length', 'max'=>15),
			array('address, token, avatar', 'length', 'max'=>255),
			array('role', 'length', 'max'=>15),
			array('lastName', 'match', 'pattern' => '/^[А-яҐЄІЇЁґєіїё\s]+$/u', 'message' => 'Поле "Фамилия" может содержать только кириллицу'),
			array('patronymic', 'match', 'pattern' => '/^[А-яҐЄІЇЁґєіїё\s]+$/u', 'message' => 'Поле "Отчество" может содержать только кириллицу'),
			array('firstName', 'match', 'pattern' => '/^[А-яҐЄІЇЁґєіїё\s]+$/u', 'message' => 'Поле "Имя" может содержать только кириллицу'),
			array('status', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, password, firstName, lastName, patronymic, phone, social_status, birthday, address, date_registration, inn, ip, token, avatar, role, status', 'safe', 'on'=>'search'),
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
			$this->role = User::ROLE_MODERATOR;
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
			'social_status' => Yii::t('main','Социальный статут'),
			'birthday' => Yii::t('main','Дата рождения'),
			'address' => Yii::t('main','адрес'),
			'date_registration' => 'Date Registration',
			'inn' => Yii::t('main','ИНН'),
			'ip' => 'Ip',
			'token' => 'Token',
			'avatar' => 'Avatar',
			'role' => 'Role',
			'status' => 'Status',
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
		$criteria->compare('social_status',$this->gender,true);
		$criteria->compare('birthday',$this->birthday);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('date_registration',$this->date_registration);
		$criteria->compare('inn',$this->inn);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
