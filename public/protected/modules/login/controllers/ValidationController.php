<?php

class ValidationController extends Controller
{
    public function actionIndex($ref='')
    {
        //$this->layout ='main';

        if($model = Registration::model()->checkValidToken($ref)){

            Yii::app()->user->setFlash('message',Yii::t('main','Поздравляем! Вы успешно прошли авторизацию.'));
        }else{
            Yii::app()->user->setFlash('message',Yii::t('main','К сожалению, пользователь не найден. Рекомендуем повторно зарегистрироваться.'));
        }

        $this->render('index',['model'=>$model]);
    }
}