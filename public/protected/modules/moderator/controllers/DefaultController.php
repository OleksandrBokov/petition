<?php

/**
 * Class DefaultController
 */
class DefaultController extends ModeratorController
{
    
    /**
     * Login action
     */
    public function actionLogin()
    {
        $this->layout = false;

        $model=new ModeratorLoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='moderator-login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        // collect user input data
        if(isset($_POST['ModeratorLoginForm']))
        {
            $model->attributes=$_POST['ModeratorLoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()){
                Yii::app()->user->setReturnUrl('/moderator');
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        // display the login form
        $this->render('login',array('model'=>$model));

    }


}