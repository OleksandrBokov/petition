<?php

class CategorySearchWidget extends CWidget
{

    public $type_entity = false;
    public $language = false;
    public $name ='';
    public $value ='';
    public $htmlOptions = array( );
    public $defaultHtmlOptions = array();


    public function init()
    {

        $this->defaultHtmlOptions = array(
            'class'=>'live-search',
            'type'=>'text',
            'placeholder'=>Yii::t('main','выберите вид спорта'),
            'maxlength'=>255,
            'data-search'=>''
        );

        if(!$this->language)
            $this->language = Yii::app()->language;

        if(!$this->type_entity)
            throw new CException(Yii::t('yiiext','The type_entity can not be empty.'));

        $htmlOptions = CMap::mergeArray( $this->defaultHtmlOptions, $this->htmlOptions);

        $this->registerScripts();

        echo $this->renderHtml($htmlOptions);
    }


    protected function registerScripts()
    {
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assets = Yii::app()->getAssetManager()->publish($dir);
        $cs=Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerCssFile($assets .'/search.css');
//"propertychange
        $js = <<<EOP
        'use strict';
$(document).ready(function () {
   var list = $('#search-list');
   //list.hide();
$("input[data-search]").bind("change input paste", function(event){
    var data ={type_entity_id: {$this->type_entity},query:$(this).val() }
    list.empty();
   // list.hide();
    $.ajax({
        type:'post',
        'dataType':'json',
        url: $(this).attr('data-url'),
        data:{data:data},
        success:function(response){
         console.log(response);
         list.append(response.list);
         list.show();
        }
    })
});
})
EOP;

        $cs->registerScript('Yii.' . get_class($this) , $js,CClientScript::POS_END);
    }


    public function renderHtml($htmlOptions)
    {
        $content = '';
        $content .= CHtml::textField($this->name, $this->value,$htmlOptions);

        $content .= CHtml::openTag('ul',['id'=>'search-list']);

        $content .= CHtml::closeTag('ul');

        return $content;
    }
}