<?php

/**
 * Class AdminModule
 */
class AdminModule extends CWebModule
{

    /**
     * 
     */
    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(array(
            'application.modules.admin.components.AdminController',
        ));
    }

    /**
     * @param CController $controller
     * @param CAction $action
     * @return bool
     */
    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            Yii::app()->user->loginUrl = Yii::app()->createUrl('/admin/login');

            return true;
        }
        else
            return false;
    }
}
