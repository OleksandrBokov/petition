<?php

class DefaultController extends AdminController
{

	public function actionIndex()
	{
        $petitionModel = new Petition('search');

        $petitionModel->unsetAttributes();  // clear any default values
        if (isset($_GET['Petition'])) {
            $petitionModel->attributes = $_GET['Petition'];
        }
        
        $this->render('index', array(
            'model' => $petitionModel,
        ));
	}


//    public function actionCapcha()
//    {
//        $this->pageTitle = Yii::t('main', 'Капча');
//        $capchaKey = Yii::app()->config->get('capchaKey');
//        $capchaSecretKey = Yii::app()->config->get('capchaSecretKey');
//        
//        $this->render('capcha', array(
//            'capchaKey' => $capchaKey,
//            'capchaSecretKey' => $capchaSecretKey,
//        ));
//    }


    public function actionLink()
    {
        $link = $_SERVER['SERVER_NAME']. '/moderator/registration';

        $this->render('link', array(
            'link' => $link,
        ));
    }


    public function actionLogin()
    {
        $this->layout = false;

        $model=new AdminLoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='admin-login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        // collect user input data
        if(isset($_POST['AdminLoginForm']))
        {
            $model->attributes=$_POST['AdminLoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()){
                Yii::app()->user->setReturnUrl('/admin');
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        // display the login form
        $this->render('login',array('model'=>$model));

    }


}