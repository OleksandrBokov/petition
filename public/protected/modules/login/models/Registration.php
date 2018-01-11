<?php

class Registration extends CActiveRecord
{

    public function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return array(
            array('firstName, lastName, email, phone, password',
                'required',
                'message'=>Yii::t('main','Необходимо заполнить поле "{attribute}"')
                ),
            array('firstName, lastName, phone', 'length', 'max'=>45),
            array('email','email'),
            array('email', 'unique','message'=>Yii::t('main','Пользователь с таким email уже существует.')),
            array('password', 'length', 'min'=>Yii::app()->config->get('password_length')),
            array('firstName, lastName, email, phone, password, date_registration, password, ip, role', 'safe')
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

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'email' => 'Email',
            'password' => Yii::t('main','Пароль'),
            'firstName' => Yii::t('main','Имя'),
            'lastName' => Yii::t('main','Фамилия'),
            'phone' => Yii::t('main','Телефон'),
            'social_name' => 'Social Name',
            'social_id' => 'Social',
            'social_link' => 'Social Link',
            'gender' => 'Gender',
            'birthday' => 'Birthday',
            'date_registration' => 'Date Registraton',
            'ip' => 'Ip',
            'timezone' => 'Timezone',
            'role' => 'Role',
            'status' => 'Status',
            'city_id' => Yii::t('main','город')
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