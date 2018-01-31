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
 * @property string $phone
 * @property string $social_name
 * @property string $social_id
 * @property string $social_link
 * @property string $gender
 * @property integer $birthday
 * @property integer $date_registraton
 * @property string $ip
 * @property string $city_id
 * @property integer $timezone
 * @property string $avatar
 * @property string $role
 * @property string $status
 */
class User extends CActiveRecord
{

    const ROLE_ADMIN = 'admin';
    const ROLE_MODERATOR = 'moderator';
    const ROLE_MANAGER = 'moderator';
    const ROLE_USER = 'user';
    const ROLE_GUEST = 'guest';

    const STATUS_NOT_AUTHORIZED = 0;
    const STATUS_AUTHORIZED = 1;
    const STATUS_TEMPL = 2;
    const STATUS_BLOCKED = 3;
    const STATUS_MODERATOR = 4;

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
			array('email, password, phone, role, status', 'required'),
			array('date_registration', 'numerical', 'integerOnly'=>true),
			array('email, password', 'length', 'max'=>100),
			array('firstName, lastName, phone', 'length', 'max'=>45),
			array('token', 'length', 'max'=>255),
            array('status', 'length', 'max'=>10),
			array('role', 'length', 'max'=>15),
            array('status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, password, firstName, lastName, phone, token, birthday, date_registration, role, status', 'safe', 'on'=>'search'),
		);
	}

    protected function beforeSave()
    {
        if($this->isNewRecord){
            $this->date_registration = DateHelper::setCurrentDateTimeToTimestamp();
            $this->password = $this->createPasswordHash($this->password);
        }

        return parent::beforeSave();
    }

    public function createPasswordHash($password)
    {
        return md5(Yii::app()->config->get('hashKey').$password);
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
			'phone' => Yii::t('main','Телефон'),
			'birthday' => 'Birthday',
			'date_registration' => 'Date Registraton',
			'timezone' => 'Timezone',
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
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('birthday',$this->birthday);
		$criteria->compare('date_registration',$this->date_registration);
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
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
