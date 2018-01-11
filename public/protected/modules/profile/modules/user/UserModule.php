<?php


class UserModule extends CWebModule
{


    public function init()
    {
        $this->setImport(array(
            'application.modules.user.components.UserController',
            'application.modules.profile.modules.user.models.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            Yii::app()->user->loginUrl =Yii::app()->createUrl('/user/login');

            return true;
        }
        else
            return false;
    }
}
