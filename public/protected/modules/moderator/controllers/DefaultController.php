<?php

/**
 * Class DefaultController
 */
class DefaultController extends ModeratorController
{
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('main','Петиции');
        $petitionModel = new Petition('search');

        $petitionModel->unsetAttributes();  // clear any default values
        if (isset($_GET['Petition'])) {
            $petitionModel->attributes = $_GET['Petition'];
        }

        $this->render('index', array(
            'model' => $petitionModel,
        ));
    }
    /**
     * Login action
     */
    public function actionLogin()
    {
        $this->layout = false;
//        $ipAccess = Yii::app()->config->get('ipAccess');
//        echo "<pre>";
//        print_r($ipAccess);
//        print_r($_SERVER['REMOTE_ADDR']);
//        echo "</pre>";die;

        if(strripos(Yii::app()->config->get('ipAccess'),$_SERVER['REMOTE_ADDR']) === false){
            
        }

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

    public function actionChangestatus(){
        $moderator = CustomUser::model()->findByAttributes(['role'=>User::ROLE_MODERATOR]);
        if(!is_null($moderator)){
            $moderator->status = 1;
            $moderator->save(false);
        }
        $this->redirect('/');
    }

    public function actionRegistration()
    {
        $this->layout = false;
        $user = User::model()->findByAttributes(['role'=>User::ROLE_MODERATOR]);
        if (!Yii::app()->user->isGuest)
            throw new CHttpException(404, 'Error 404 role is not guest');

        if(null !== $user)
            $this->redirect('/');

        $model = new CustomUser();

        if (isset($_POST['CustomUser'])) {
            $model->attributes = $_POST['CustomUser'];
            if($model->validate()){
                
                if($user = $model->checkUser()){
                    if($user->status == User::STATUS_TEMPL){
                        $user->status = User::STATUS_MODERATOR;
                        $user->attributes = $_POST['CustomUser'];
                        $user->save();
                        $m = new Mail();
                        $message = $m->createMessage($user, 'moderator_registrate');
                        Mailer::_createMailToHtml($message);
                        $this->redirect(Yii::app()->createUrl('/moderator/afterregistration'));
                    }
                }
                else{
                    if($user = $model->checkUser(User::STATUS_AUTHORIZED)){
                        $model->addError('userVote', 'Такий email вже зареэстровано');
                    }else{
                        $model->status = User::STATUS_MODERATOR;
                        $model->save(false);
                        $m = new Mail();
                        $message = $m->createMessage($model, 'moderator_registrate');
                        Mailer::_createMailToHtml($message);
                        $this->redirect(Yii::app()->createUrl('/moderator/afterregistration'));
                    }

                }
            }
            
            //$model->postIndex = '111111';
//            if ($model->save()) {
//                $m = new Mail();
//                $message = $m->createMessage($model, 'registration');
//                Mailer::_createMailToHtml($message);
//                $this->redirect(Yii::app()->createUrl('/moderator/afterregistration'));
//            }
        }

        $this->render('registration', ['model'=>$model]);
//        $this->render('application.modules.user.views.default.registration', ['model'=>$model]);
    }


}