<?php

/**
 * Class DefaultController
 */
class DefaultController extends UserController
{
    /**
     * empty action
     */
	public function actionIndex()
	{
        $this->render('index');
	}
    
    /**
     * Login action
     */
    public function actionLogin()
    {
        $this->layout = false;

        $model=new UserLoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        // collect user input data
        if(isset($_POST['UserLoginForm']))
        {
            $model->attributes=$_POST['UserLoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()){
                Yii::app()->user->setReturnUrl('/user');
                if(Yii::app()->user->role != User::ROLE_USER){
                    $this->redirect('/'.Yii::app()->user->role);
                }
                else
                    $this->redirect('/');
            }
        }
        // display the login form
        $this->render('login',array('model'=>$model));

    }

    public function actionRegistration()
    {
        $this->layout = false;
        if (!Yii::app()->user->isGuest)
            throw new CHttpException(404, 'Error 404 role is not guest');

        $model = new CustomUser();
        if (isset($_POST['CustomUser'])) {
            $model->attributes = $_POST['CustomUser'];
            if ($model->save()) {
                $m = new Mail();
                $message = $m->createMessage($model, 'registration');
                Mailer::_createMailToHtml($message);
                $this->redirect(Yii::app()->createUrl('/moderator/afterregistration'));
            }
        }

        $this->render('registration', ['model'=>$model]);

    }


}