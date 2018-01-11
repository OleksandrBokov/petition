<?php
//Yii::import('application.modules.registration.models.Social');

class DefaultController extends Controller
{
    public function actionIndex()
    {
        
        if (Yii::app()->request->isAjaxRequest) {
            $model = new LoginForm;
            if (isset($_POST['LoginForm'])) {
                $model->attributes = $_POST['LoginForm'];
                if ($model->validate() && $model->login()) {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
                } else {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
                }
            }
        }
    }

    /*** Authorization and registration from social network ***/
    public function actionAjax()
    {
        $serviceName = Yii::app()->request->getQuery('service');

        if (isset($serviceName)) {
            /** @var $eauth EAuthServiceBase */
            $eauth = Yii::app()->eauth->getIdentity($serviceName);

            try {
                if ($eauth->authenticate()) {
                    $error = Social::model()->registration($eauth->getAttributes(), $serviceName);

                    $identity = new ServiceUserIdentity($eauth , $eauth->getAttribute('email'));

                    if ($identity->authenticate()) {

                        if(!$error){
                            Yii::app()->user->login($identity);
                            $eauth->redirect( Yii::app()->user->returnUrl  );//SMultilangHelper::addLangToUrl('/')
                        }else{
                            echo "<pre>";
                            print_r($error);
                            echo "</pre>";
                            Yii::app()->end();
                        }

                    }else{
                        $eauth->cancel();
                    }
                }
            }
            catch (EAuthException $e) {
                // save authentication error to session
                Yii::app()->user->setFlash('error', 'EAuthException: '.$e->getMessage());
                // close popup window and redirect to cancelUrl
                $eauth->redirect($eauth->getCancelUrl());
            }
        }
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}