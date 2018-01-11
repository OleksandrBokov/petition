<?php
class ServiceUserIdentity extends UserIdentity {
    const ERROR_NOT_AUTHENTICATED = 3;

    /**
     * @var EAuthServiceBase the authorization service instance.
     */
    protected $service;

    protected $email;
    // Будем хранить id.
    protected $_id;
    /**
     * Constructor.
     * @param EAuthServiceBase $service the authorization service instance.
     */
    public function __construct($service, $email) {
        $this->service = $service;
        $this->email = $email;
    }

    /**
     * Authenticates a user based on {@link username}.
     * This method is required by {@link IUserIdentity}.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        if ($this->service->isAuthenticated) {
            $user = User::model()->find('LOWER(email)=?', array(strtolower($this->email)));


            if ($user->status == User::STATUS_BLOCKED) { //banned
                Yii::app()->user->setFlash('message-banned',
                    Yii::t('main', 'Ваш аккаунт заблокирован'));
            }else {
                // В качестве идентификатора будем использовать id, а не username,
                // как это определено по умолчанию. Обязательно нужно переопределить
                // метод getId(см. ниже).
                $this->_id = $user->id;
                // Далее логин нам не понадобится, зато имя может пригодится
                // в самом приложении. Используется как Yii::app()->user->name.
                $this->username = $user->firstName.' '.$user->lastName;
                $this->errorCode = self::ERROR_NONE;

            }
            return !$this->errorCode;
        }
        else {
            $this->errorCode = self::ERROR_NOT_AUTHENTICATED;
        }
        return !$this->errorCode;
    }
}