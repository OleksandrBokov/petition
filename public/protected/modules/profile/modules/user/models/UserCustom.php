<?php

/**
 * Class UserCustom
 */
class UserCustom extends User
{
    public function tableName()
    {
        return 'user';
    }

    /**
     * @return array
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//            array('email, password', 'required'),
            array('email', 'unique'),
            array('email', 'email'),
            array('email, password', 'length', 'max'=>100),
//            array('firstName, lastName, phone', 'length', 'max'=>45),
//            array('firstName, lastName', 'length', 'max'=>45),
//            array('ip', 'length', 'max'=>50),
//            array('byte_code', 'safe'),
//            array('avatar', 'length', 'max'=>255),
//            array('upload_image', 'file','types'=>'jpg, gif, png, jpeg','allowEmpty'=>true ),
//            array('id, email, password, firstName, lastName, phone, ip, avatar, byte_code', 'safe', 'on'=>'search'),
            array('id, email, password, firstName, lastName, phone, ip, avatar', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return parent::attributeLabels();
//        return array(
//            'id' => 'ID',
//            'email' => 'Логин для входа',
//            'login' => 'Почтовый адрес для писем',
//            'password' => Yii::t('main','Пароль'),
//            'new_password' => Yii::t('main','Новый Пароль'),
//            'confirmation_new_password' => Yii::t('main','Подтвердите новый пароль'),
//            'firstName' => Yii::t('main','Имя'),
//            'lastName' => Yii::t('main','Фамилия'),
//            'avatar' => Yii::t('main','Аватар'),
//            'phone' => Yii::t('main','Телефон'),
//        );
    }

    /**
     * @param null|string $className
     * @return mixed|static
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}