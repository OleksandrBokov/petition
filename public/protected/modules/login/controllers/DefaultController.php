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
    
    public function actionRegistration()
    {
        if (!Yii::app()->user->isGuest)
            throw new CHttpException(404, 'Error 404');
        $model = new CustomUser();

        if(isset($_POST['ajax']) && $_POST['ajax'] === 'moderator-sign-up-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['CustomUser'])) {

            echo "<pre>";
            print_r($_POST);
            echo "</pre>";die;
            $model->attributes = $_POST['CustomUser'];

            if ($model->save()) {

                $m = new Mail();
                $message = $m->createMessage($model, 'registration');
                Mailer::_createMailToHtml($message);

                echo json_encode(['message'=> Yii::t('main',
                    '{p}Спасибо большое! На Ваш e-mail (который вы ввели при регистрации) было отправлено письмо с ссылкой для подтверждение регистрации, а так же инструкции по дальнейшей работе с ресурсом. В случае если вы не получили письмо - проверьте папку со спамом.{/p}',
                    ['{p}'=>'<p class="successful-registration">','{/p}'=>'</p>'])]);
                Yii::app()->end();

            }else{
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

        }
        $this->render('registration', ['model'=>$model]);
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