<?php

/**
 * @author Yaroslav Fedan <yaroslav.fd@gmail.com>
 * @link https://github.com/YaroslavFedan
 */
class AngularWidget extends CWidget
{
    public function init()
    {
        $this->registerScript();
    }

    public  function registerScript()
    {
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assets = Yii::app()->getAssetManager(['linkAssets'=>true])->publish($dir,false, -1, YII_DEBUG); //

        $cs=Yii::app()->getClientScript();

        $cs->registerCssFile($assets .'/css/angular.css');
        /*
         AngularJS v1.4.0
         (c) 2010-2015 Google, Inc. http://angularjs.org
         License: MIT
        */
        $cs->registerScriptFile($assets . '/js/_lib/angular.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets . '/js/_lib/app.factory.js', CClientScript::POS_END);
    }
}