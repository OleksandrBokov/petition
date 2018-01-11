<?php


class AdminModule extends CWebModule
{


    public function init()
    {
        $this->setImport(array(
            'application.modules.admin.components.AdminController',
            'application.modules.profile.modules.admin.models.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            Yii::app()->user->loginUrl =Yii::app()->createUrl('/admin/login');

            return true;
        }
        else
            return false;
    }
}
