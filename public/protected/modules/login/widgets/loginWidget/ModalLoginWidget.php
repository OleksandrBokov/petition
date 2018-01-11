<?php

Yii::import('application.modules.login.models.LoginForm');
Yii::import('application.modules.login.models.Registration');

class ModalLoginWidget extends CWidget
{
        public function init()
        {
            $authForm = new LoginForm;
            $model = new Registration();
            $this->render('application.modules.login.widgets.loginWidget.views.modal-form', array('authForm' => $authForm, 'model'=>$model));
        }
}