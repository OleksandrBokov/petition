<?php


class Admin extends CActiveRecord
{
    public $login;

    public $confirm_password;

    public function tableName()
    {
        return 'user';
    }

    public function init()
    {
        $this->login = Yii::app()->config->get('adminEmail');
        return parent::init();
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, login, password', 'required'),
            array('email', 'unique'),
            array('email, password, confirm_password', 'length', 'max'=>100),
            array('firstName, lastName, phone', 'length', 'max'=>45),
            array('ip', 'length', 'max'=>50),
            array('id, email, password, firstName, lastName, phone, ip', 'safe', 'on'=>'search'),
        );
    }

    protected function beforeSave()
    {
        $this->password = $this->createPasswordHash($this->password);
        $this->ip = Yii::app()->getRequest()->getUserHostAddress();
    }


    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'email' => 'Логин для входа',
            'login' => 'Почтовый адрес для писем',
            'password' => Yii::t('main','Пароль'),
            'firstName' => Yii::t('main','Имя'),
            'lastName' => Yii::t('main','Фамилия'),
            'phone' => Yii::t('main','Телефон'),
        );
    }


    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}