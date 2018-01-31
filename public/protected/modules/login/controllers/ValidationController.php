<?php

class ValidationController extends Controller
{
    public function actionIndex($ref='')
    {
        //$this->layout ='main';

        if($model = Registration::model()->checkValidToken($ref)){

//            Yii::app()->user->setFlash('message',Yii::t('main','Поздравляем! Вы успешно прошли авторизацию.'));
            Yii::app()->user->setFlash('message',Yii::t('main','Вітаємо! Ви успішно підписали петицію.'));
        }else{
//            Yii::app()->user->setFlash('message',Yii::t('main','К сожалению, пользователь не найден. Рекомендуем повторно зарегистрироваться.'));
            Yii::app()->user->setFlash('message',Yii::t('main','Нажаль користувача не знайдено. Рекомендуємо повторно підписати петицію.'));
        }

        $this->render('index',['model'=>$model]);
    }
}