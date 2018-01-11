<?php

class Social extends User
{
    public $name;

    public function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('social_id, social_link, social_name, email, role, status', 'required'),
            array('social_id, social_link', 'length', 'max'=>255),
            array('social_id', 'numerical', 'integerOnly'=>true),
            array('email','email'),
            array('firstName, lastName, social_name', 'length', 'max'=>45),
            array('gender', 'length', 'max'=>6),
            array('birthday, date_registration, timezone', 'numerical', 'integerOnly'=>true),
            array('ip', 'length', 'max'=>50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, email, password, firstName, lastName, phone, social_name, social_id, social_link, gender, birthday, date_registration, ip, timezone, role, status', 'safe', 'on'=>'search'),
        );
    }

    public function attributeLabels()
    {
        return parent::attributeLabels();
    }

    public function registration($data, $social)
    {
        $model = null;

        $model = Social::model()->find('social_name = :social_name AND social_id = :social_id OR email = :email',
            array(':social_name'=>$social, ':social_id'=>$data['id'], ':email'=>$data['email']));


        if ($model === null) {

            $model = new Social();
            $model->attributes = $data;

        }

        $model->social_id = $data['id'];
        $model->social_link = $data['link'];
        $model->firstName = $data['first_name'];
        $model->lastName = $data['last_name'];
        $model->social_name = $social;
        $model->birthday = DateHelper::convertDateToTimeStamp($data['birthday']);
        $model->role = User::ROLE_USER;
        $model->status = User::STATUS_AUTHORIZED;

        if($model->save())
            return false;
        else
            return $model->getErrors();

    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}