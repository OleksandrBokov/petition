<?php


class LanguagesSwitcher extends CWidget
{

    public $htmlOptions = array();
    public $listOptions = array();
    public $linkOptions = array();
    public $content = '';

    public function init()
    {
        $this->content .= CHtml::openTag('ul',$this->htmlOptions);
        $this->content .= CHtml::openTag('li',$this->listOptions);

        $this->content .= $this->setCurrentLang();
        $this->content .= CHtml::openTag('ul',['class'=>'dropdown-menu']);
        $this->content .= $this->setAvialableLang();
        $this->content .= CHtml::closeTag('ul');

        $this->content .= CHtml::closeTag('li');
        $this->content .= CHtml::closeTag('ul');

        echo $this->content;
    }


    protected function setCurrentLang()
    {
        $content = '';
        foreach (SMultilangHelper::suffixList() as $suffix => $name){

            if($suffix == SMultilangHelper::getLandToUrl()){
                $content .= CHtml::openTag('a', $this->linkOptions);
                $content .= Yii::t('main', $name);
                $content .= CHtml::openTag('span',['class'=>'caret']).CHtml::closeTag('span');
                $content .= CHtml::closeTag('a');
            }
        }
        return $content;
    }

    protected function setAvialableLang()
    {
        $content = '';
        $currentUrl = ltrim(Yii::app()->request->url, '/');

        foreach (SMultilangHelper::suffixList() as $suffix => $name){
            $url = '/' . ($suffix ? trim($suffix, '_') . '/' : '') . $currentUrl;

            if($suffix != SMultilangHelper::getLandToUrl()){
                $content .= CHtml::openTag('li');
                $content .= CHtml::link(Yii::t('main', $name), $url);
                $content .= CHtml::closeTag('li');
            }
        }
        return $content;

    }
}