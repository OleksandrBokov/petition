<?php

class SCitySwitcherWidget extends CWidget
{
    public $htmlOptions = array();
    public $listOptions = array();
    public $linkOptions = array();
    public $content = '';

    protected $_cities;

    public function init()
    {
        $cities =  $this->_getCities();

        $this->_cities = $this->_getCities();

        $this->content .= CHtml::openTag('li',$this->listOptions);
        $this->content .= $this->setCurrentCity($cities);
        if(count($cities) > 1){
            $this->content .= CHtml::openTag('ul',['class'=>'dropdown-menu']);
            $this->content .= $this->setAvialableCities($cities);
            $this->content .= CHtml::closeTag('ul');
        }
        $this->content .= CHtml::closeTag('li');

        echo $this->content;
    }

    protected function setCurrentCity($cities)
    {
        $current = Yii::app()->session['city'];

        

        $content = '';
        foreach ($cities as $item){

            if($current == $item->subdomain){
                $content .= CHtml::openTag('a', $this->linkOptions);
                $content .= $item->name;
                $content .= CHtml::openTag('i',['class'=>'fa fa-globe', 'aria-hidden'=>'true']).CHtml::closeTag('i');
                $content .= CHtml::closeTag('a');
            }
        }
        return $content;

    }



    protected function setAvialableCities($cities)
    {
        $current = Yii::app()->session['city'];

        $content = '';

        foreach ($cities as $item){

            if($current != $item->subdomain){

                if(!empty($item->subdomain)){

                    $content .= CHtml::openTag('li');
                    $content .= CHtml::openTag( 'a', ['href'=>'https://'.$item->subdomain.'.'.Yii::app()->config->get('defaultSiteHost').SMultilangHelper::addLangToUrl('/')]);//Yii::app()->request->requestUri
                    $content .= $item->name;
                    $content .= CHtml::closeTag( 'a' );
                    $content .= CHtml::closeTag('li');

                }else{

                    $content .= CHtml::openTag('li');
                    $content .= CHtml::openTag( 'a', ['href'=>'https://'.Yii::app()->config->get('defaultSiteHost').SMultilangHelper::addLangToUrl('/')]);//SMultilangHelper::getLandToUrl().Yii::app()->request->requestUri]);
                    $content .= $item->name;
                    $content .= CHtml::closeTag( 'a' );
                    $content .= CHtml::closeTag('li');
                }
            }
        }
        return $content;
    }

    protected function _getCities()
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'status = :status';
        $criteria->params = array(':status'=>City::CITY_ACTIVE);

        return City::model()->findAll($criteria);
    }
}