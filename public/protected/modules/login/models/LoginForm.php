<?php

Yii::import('application.extensions.eauth.EAuthWidget');
/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
    public $status;
	public $rememberMe;

	private $_identity;


	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required', 'message'=>Yii::t('main','Необходимо заполнить поле "{attribute}"')),
            array('username','email'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
			array('status', 'checkStatus'),
		);
	}



	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>Yii::t('main','Запомнить меня'),
            'username' =>Yii::t('main','Э-почта'),
            'password' =>Yii::t('main','Пароль'),
        );
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 * @param string $attribute the name of the attribute to be validated.
	 * @param array $params additional parameters passed with rule when being executed.
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

    public function checkStatus($attribute,$params)
    {
        $user = User::model()->find('LOWER(email)=?', array(strtolower($this->username)));

        if($user == null){
            $this->addError('password',Yii::t('main','Неправильный Email или пароль.'));
        } else{

            if($user->status == User::STATUS_NOT_AUTHORIZED)
                $this->addError('password',Yii::t('main','Ваша учетная запись не подтверждена. Проверьте свою электронную почту.'));

            if($user->status == User::STATUS_BLOCKED)
                $this->addError('password',Yii::t('main','Ваша учетная запись заблокирована.'));
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

			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}


}
