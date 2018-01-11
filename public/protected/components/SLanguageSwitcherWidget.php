<?php

class SLanguageSwitcherWidget extends CWidget
{

    public function init()
    {
        $langs = array();
        $currentUrl = ltrim(Yii::app()->request->url, '/');
        foreach (Yii::app()->params['translatedLanguages'] as $k => $v){
            $active = ($k == Yii::app()->language) ? 'active':'';
            foreach (SMultilangHelper::suffixList() as $suffix => $name){
                if($name == $v){
                    $langs[] = array(
                        'name'=>$k,
                        'url' =>'/' . ($suffix ? trim($suffix, '_') . '/' : '') . $currentUrl,
                        'active'=>$active
                    );
                }

            }
        }
        $content = CHtml::openTag('li',['class'=>'language']);
        foreach ($langs as $lang){
            $content .= CHtml::link($lang['name'], $lang['url'],['class'=>$lang['active']]);
        }
        $content .= CHtml::closeTag('li');
        echo $content;
    }
}