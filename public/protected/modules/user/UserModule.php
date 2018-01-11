<?php

/**
 * Class UserModule
 */
class UserModule extends CWebModule
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
			'user.models.*',
			'user.components.*',
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
            Yii::app()->user->loginUrl = Yii::app()->createUrl('/user/login');

			return true;
		}
		else
			return false;
	}
}
