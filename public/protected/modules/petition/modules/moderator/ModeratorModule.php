<?php

/**
 * Class AdminModule
 */
class ModeratorModule extends CWebModule
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
            'application.modules.moderator.components.ModeratorController',
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
            Yii::app()->user->loginUrl = Yii::app()->createUrl('/moderator/login');

            return true;
        }
        else
            return false;
    }
}
