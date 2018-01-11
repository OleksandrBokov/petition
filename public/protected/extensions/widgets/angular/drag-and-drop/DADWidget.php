<?php

/**
 * @author Yaroslav Fedan <yaroslav.fd@gmail.com>
 * @link https://github.com/YaroslavFedan
 */
Yii::import('application.extensions.widgets.angular.AngularWidget');
Yii::import('application.extensions.widgets.angular.TemplateView');


class DADWidget extends AngularWidget implements TemplateView
{
    public $config;

    protected $id; ///selector from AppFactory

    public $itemId; // unique id elem

    public $search = false; // search fields

    public $usedTitle = ''; // title to used items
    public $availableTitle = ''; // title to available items

    public $order_field =''; // list of keys for sorting (delimiter ',')

    public function init()
    {
        $this->registerScript();


        $this->id =  $this->config['appController'];
        if($this->order_field)
            $this->setOrder();

        $this->config = json_encode($this->config);

        echo $this->renderHtml();

    }

    public  function registerScript()
    {
        parent::registerScript();

        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assets = Yii::app()->getAssetManager(['linkAssets' => true])->publish($dir, false, -1, YII_DEBUG);
        $cs = Yii::app()->getClientScript();

        $cs->registerScriptFile($assets.'/js/'.$this->config['appController'].'.js', CClientScript::POS_END);

        $cs->registerCssFile($assets .'/css/simple-draggable.css');
    }


    protected function renderHtml()
    {
        $content = '';

        $content .= CHtml::openTag('div',[
            'id'=>$this->id,
            'data-ng-controller'=>$this->id,
            'class'=>'ng-cloak',
            'data-ng-init'=>"init({$this->config})",]);
        $content .= '<div draggable-view></div>';

        $content .= '<script type="text/ng-template" id="'.$this->id.'.html">';
        $content .= $this->createTemplate();
        $content .= '</script>';

        $content .= CHtml::closeTag('div');

        return $content;
    }

    public function createTemplate() {}


    public function renderSaveButton()
    {
        $content = '';

        $content .= CHtml::openTag('div', ['class'=>'box-footer', 'style'=>'padding-right:0']);
        $content .= CHtml::openTag('div', ['class'=>'pull-right']);
        $content .= CHtml::openTag('div',['class'=>'loader', 'data-ng-show'=>'loaderShow']).CHtml::closeTag('div');
        $content .= CHtml::openTag('button ',['class'=>'btn btn-success btn-sm', 'data-ng-click'=>'saveChanges()', "ng-disabled"=>"checked"]);
        $content .= "<[ buttonSave ]>";
        $content .= CHtml::closeTag('button');
        $content .= CHtml::closeTag('div');
        $content .= CHtml::closeTag('div');

        return $content;
    }

    private function setOrder()
    {
        $order = explode(',',$this->order_field);
        $this->order_field = '';
        $count = count($order);
        foreach ($order as $k => $v){
            if($k != $count-1)
                $this->order_field .= "'".$v."',";
            else
                $this->order_field .= "'".$v."'";
        }
    }
}