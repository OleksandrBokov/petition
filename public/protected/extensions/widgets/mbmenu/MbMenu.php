<?php

/**
 * @author Yaroslav Fedan <yaroslav.fd@gmail.com>
 * @link https://github.com/YaroslavFedan
 */

//Yii::import('zii.widgets.CMenu');

class MbMenu extends CWidget
{

    public $items = array();

    public function init()
    {
        $route=Yii::app()->request->requestUri;
       // $this->items=$this->normalizeItems($this->items, $route);

        echo $this->renderMenuRecursive($this->items);

    }

    protected function renderMenuRecursive($items)
    {

        foreach($items as $item)
        {

            if(isset($item['icon']))
                $icon =  '<i class="'.$item['icon'].'"></i>';
            else
                $icon = '';

            if(isset($item['linkOptions'])){
               // $item['linkOptions']['class'] = $item['linkOptions']['class'].' active';
//                echo "<pre>";
//                print_r($item['linkOptions']['class'] = $item['linkOptions']['class'].' active');
//                echo "</pre>";
            }


            echo CHtml::openTag('li', isset($item['linkOptions']) ? $item['linkOptions'] : array());
            if(isset($item['url'])){
                echo CHtml::openTag('a',['href'=>$item['url']]);
                echo $icon;
                echo CHtml::openTag('span',['class'=>'text-capitalize']);
                echo isset($item['label']) ? $item['label'] : '';
                echo CHtml::closeTag('span');

                if(isset($item['banner'])){
                    echo CHtml::openTag('span',isset($item['banner']['htmlOptions']) ? $item['banner']['htmlOptions'] : array() );
                    echo CHtml::openTag('small',isset($item['banner']['labelOptions']) ? $item['banner']['labelOptions'] : array());
                    echo isset($item['banner']['label']) ? $item['banner']['label'] : '';
                    echo CHtml::closeTag('small');
                    echo CHtml::closeTag('span');
                }

                echo CHtml::closeTag('a');
            }else{

                echo CHtml::openTag('a',['href'=>'javascript:void(0);']);
                echo $icon;
                echo CHtml::openTag('span',['class'=>'text-capitalize']);
                echo isset($item['label']) ? $item['label'] : '';
                echo CHtml::closeTag('span');

                if(isset($item['banner'])){
                    echo CHtml::openTag('span',isset($item['banner']['htmlOptions']) ? $item['banner']['htmlOptions'] : array() );
                    echo CHtml::openTag('small',isset($item['banner']['labelOptions']) ? $item['banner']['labelOptions'] : array());
                    echo isset($item['banner']['label']) ? $item['banner']['label'] : '';
                    echo CHtml::closeTag('small');
                    echo CHtml::closeTag('span');
                }

                echo CHtml::closeTag('a');
            }

               // echo CHtml::link( $icon.'<span class="text-capitalize">'.$item['label'].'</span>',$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array());





            if(isset($item['items']) && count($item['items']))
            {
                echo "\n".CHtml::openTag('ul',$item['itemOptions'])."\n";
                $this->renderMenuRecursive($item['items']);
                echo CHtml::closeTag('ul')."\n";
            }
            echo CHtml::closeTag('li')."\n";
        }
    }


   

}