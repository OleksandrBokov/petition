<?php

/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 23.01.2018
 * Time: 13:08
 */
Yii::import('application.extensions.yiiReCaptcha.ReCaptcha');

class PetitionReCaptcha extends ReCaptcha
{
    public function init()
    {
        $this->key = Yii::app()->config->get('capchaKey');
        $this->secret = Yii::app()->config->get('capchaSecretKey');
        parent::init();
    }
}