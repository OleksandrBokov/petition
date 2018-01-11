<?php

class ResetController extends Controller
{
    public $layout ='main';

    public function actionPassword()
    {

        $model = new Reset();
        $this->performAjaxValidation($model);

        if(isset($_POST['Reset'])){

            $model = Reset::model()->find('email = :email',[':email'=>$_POST['Reset']['email']]);

            $model->new_password = RandomStringHelper::generate(Yii::app()->config->get('password_length'), Yii::app()->config->get('numberAndSymbolString'));
            $model->password = User::model()->createPasswordHash($model->new_password);

            if($model->update()){
                $m = new Mail();
                $message = $m->createMessage($model, 'reset_password');
                Mailer::_createMailToHtml($message);
                $this->redirect('successful');
            }
        }

        $this->render('index',['model'=>$model]);
    }

    public function actionSuccessful()
    {
        Yii::app()->user->setFlash('successful',Yii::t('main','Ваш новый пароль выслан Вам на email.'));
        $this->render('successful');
    }

    private function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='reset-password-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}