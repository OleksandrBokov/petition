<?php

class RegistrationController extends Controller
{

    public function actionIndex()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Registration();
            if (isset($_POST['Registration'])) {
                $model->attributes = $_POST['Registration'];

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
        }
    }
}