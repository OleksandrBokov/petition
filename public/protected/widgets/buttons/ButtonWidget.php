<?php


class ButtonWidget extends CWidget
{

    public $link = false;

    public $label = 'button';

    public $url = '#';

    public $htmlOptions = array('class'=>'btn btn-sm btn-default');

    public $iconOptions = array();

    public function init(){

        $con = '';
        if(!$this->link) {

            $con .= CHtml::openTag('button', $this->htmlOptions);
            $con .= CHtml::openTag('span', $this->iconOptions) . CHtml::closeTag('span');
            $con .= $this->label;
            $con .= CHtml::closeTag('button');
        }else{
            $con .= CHtml::openTag('a',CMap::mergeArray(['href'=>$this->url],$this->htmlOptions));
            $con .= CHtml::openTag('span',$this->iconOptions).CHtml::closeTag('span');
            $con .= $this->label;
            $con .= CHtml::closeTag('a');
        }
        echo $con;
    }
}