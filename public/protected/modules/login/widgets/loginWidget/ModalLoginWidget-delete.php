<?php

Yii::import('application.modules.login.models.LoginForm');
Yii::import('application.modules.login.models.Registration');

class ModalLoginWidget extends CWidget
{

    public $htmlOptions = array();
    public $linkOptions = array();
    public $listOptions = array();

    public $resetPassword = array();

    public $items = array();

    public function init()
    {

        $authForm = new LoginForm;
        $model = new Registration();

        $this->createLoginWidget();
        $this->render('application.modules.login.widgets.loginWidget.views.modalForm', array('authForm' => $authForm,'resetPassword'=>$this->resetPassword,'model'=>$model));
    }

    protected function createLoginWidget()
    {
        $content = '';
        $content = CHtml::openTag('li', $this->listOptions);

        $content .= CHtml::link( Yii::t('main','Вход'),'#',['class'=>"dropdown-toggle", 'data-toggle'=>"dropdown"]);




        $content .= CHtml::closeTag('li');


        echo $content;
    }
}