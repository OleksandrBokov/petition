<?php

class RegistrationController extends Controller
{

    public function actionIndex()
    {
        $model = new Registration();
        $this->performAjaxValidation($model);

        if (isset($_POST['Registration'])) {
            $model->attributes = $_POST['Registration'];
            $valid=$model->validate();
            if($valid){
                if ($model->save()) {

                    $m = new Mail();
                    $message = $m->createMessage($model, 'registration');
                    Mailer::_createMailToHtml($message);

                    echo json_encode([
                        'status'=>'success',
                        'message'=> Yii::t('main',
                            '{p}Спасибо большое! На Ваш e-mail (который вы ввели при регистрации) было отправлено письмо с ссылкой для подтверждение регистрации, а так же инструкции по дальнейшей работе с ресурсом. В случае если вы не получили письмо - проверьте папку со спамом.{/p}',
                            ['{p}'=>'<p class="successful-registration">','{/p}'=>'</p>'])]);
                    Yii::app()->end();

                }
            }
            else{
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        }
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}