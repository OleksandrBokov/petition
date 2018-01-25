<?php



class MbMenu extends CWidget
{

    public $items = array();

    public function init()
    {
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

            $class = array();
            if(stristr(Yii::app()->request->url , $item['url']) !== false){
                if( isset($item['linkOptions']['class']) ){
                    $item['linkOptions']['class'] .= ' active';
                }else{
                    $class = ['class'=>'active'];
                }
            }

            echo CHtml::openTag('li', isset($item['linkOptions']) ? $item['linkOptions'] : $class);
            if(isset($item['url']))
            {
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