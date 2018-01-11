<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    // Будем хранить id.
    protected $_id;


    // Данный метод вызывается один раз при аутентификации пользователя.
    public function authenticate()
    {

        $user = User::model()->find('LOWER(email)=?', array(strtolower($this->username)));



        if (($user === null) || ( md5(Yii::app()->config->get('hashKey') . $this->password) !== $user->password)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
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


    public function getId(){
        return $this->_id;
    }


}