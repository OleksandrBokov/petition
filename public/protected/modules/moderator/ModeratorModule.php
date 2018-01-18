<?php

/**
 * Class UserModule
 */
class ModeratorModule extends CWebModule
{
	/**
	 * import models
	 */
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
        parent::init();
		// import the module-level models and components
		$this->setImport(array(
			'moderator.models.*',
			'moderator.components.*',
			'application.models.*',
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
