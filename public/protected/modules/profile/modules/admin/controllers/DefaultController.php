<?php

class DefaultController extends AdminController
{

    public function actionIndex()
    {
        $this->pageTitle = 'Личные данные';
        $model = Admin::model()->findByPk(Yii::app()->user->id);

        $this->render('index',['model'=>$model]);
    }

    public function actionUpdate()
    {
        $this->pageTitle = 'редактировать';
        $model = Admin::model()->findByPk(Yii::app()->user->id);

        $this->render('update',['model'=>$model]);
    }
}
