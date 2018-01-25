<?php


class AlertWidget extends CWidget
{
    public $class;
    public $content = false;
    public $dismiss = true;

    public $cssOptions = array();

    public function init()
    {

        $html = '';

        if(!$this->class){
            $class = ['class'=>'alert alert-warning'];
        }else{
            $class = ['class'=>'alert alert-'.$this->class];
        }

        if($this->dismiss){
            $class['class'] .= ' alert-message alert-dismissible';
        }

        $htmlOptions = CMap::mergeArray($class, $this->cssOptions);

        if($this->content){
            $html .= CHtml::openTag('div',$htmlOptions);
            if($this->dismiss){
                $inner = '';
                $inner .= CHtml::openTag('span',['aria-hidden'=>'true']);
                $inner .= '&times;';
                $inner .= CHtml::closeTag('span');
                $html .= CHtml::openTag('button', ['type'=>'button','class'=>'close','data-dismiss'=>'alert', 'aria-label'=>'Close']);
                $html .= $inner;
                $html .= CHtml::closeTag('button');
            }
            $html .= $this->content;
            $html .= CHtml::closeTag('div');

        }

        echo $html;
        $js_conf =<<<EOP
window.setTimeout(function() { $(".alert-message").alert('close'); }, 2000);
EOP;
        Yii::app()->clientScript->registerScript('alert', $js_conf, CClientScript::POS_END);
    }
}