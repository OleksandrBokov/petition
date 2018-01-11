<?php

class Flag extends CController
{
    public static $_assetsUrl;

    public static function setBackground($styles = '', $language = false, $position = false)
    {
        if(!$language)
            $language = Yii::app()->language;

        if(!$position)
            $position = '99% 7px no-repeat';

        $assetsUrl = self::getAssetsUrl();

        return  "background: url({$assetsUrl}/flags/png/{$language}.png) {$position} rgb(255, 255, 255); {$styles} ";
    }

    public static function getAssetsUrl()
    {
        if( self::$_assetsUrl===null )
        {
            self::$_assetsUrl=Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias('webroot.protected.modules.admin.assets'),
                false,
                -1,
                YII_DEBUG
            );
        }
        return self::$_assetsUrl;
    }
}