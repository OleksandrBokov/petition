<?php

class ModeratorLoginForm extends CFormModel
{
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $password;
    /**
     * @var bool
     */
    public $rememberMe;
    /**
     * @var UserIdentity
     */
    private $_identity;
    /**
     * @var UserIdentity
     */
    public $ip;

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('username, password', 'required'),
            array('username','email'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
            array('ip', 'checkIp'),
        );
    }

    public function checkIp($attribute,$params){
        if(strripos(Yii::app()->config->get('ipAccess'),$_SERVER['REMOTE_ADDR']) === false){
            $this->addError($attribute, 'Ваш ip не дозволяє авторизуватися '.$this->$attribute);
        }else{
            return true;
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'rememberMe'=>Yii::t('main','Запомнить меня в следующий раз'),
            'password'=>Yii::t('main','Пароль'),
            'username'=>Yii::t('main','Email'),
        );
    }

    /**
     * @param $attribute
     * @param $params
     * @return void
     */
    public function authenticate($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            $this->_identity = new UserIdentity($this->username,$this->password);

            if(!$this->_identity->authenticate() )
                $this->addError('password',Yii::t('main','Неправильный Email или пароль.'));
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if($this->_identity===null)
        {
            $this->_identity= new UserIdentity($this->username,$this->password);
            $this->_identity->authenticate();
        }
        if($this->_identity->errorCode === UserIdentity::ERROR_NONE)
        {
            $duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
            Yii::app()->user->login($this->_identity,$duration);
            return true;
        }
        else
            return false;
    }

}