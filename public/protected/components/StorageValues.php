<?php

class StorageValues
{
    public static function set($key ,$params)
    {
        Yii::app()->session[$key] = $params;


        Yii::app()->Cookies->putCMsg($key,$params);
    }

    public static function get($key)
    {

        if(isset(Yii::app()->session[$key]) && !empty(Yii::app()->session[$key]))
            return Yii::app()->session[$key];
        else
            return Yii::app()->Cookies->getCMsg($key);
    }

    public static function destroy($key)
    {
        Yii::app()->session[$key]='';
        Yii::app()->Cookies->delCMsg($key);
    }

    public static function destroyAll($array)
    {
        foreach ($array as $item)
        {
            self::destroy($item);
        }
    }
}