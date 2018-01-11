<?php

/**
 * @author Yaroslav Fedan <yaroslav.fd@gmail.com>
 * @link https://github.com/YaroslavFedan
 */
class NotificationWidget extends CWidget
{
    public $icon = '';

    public $title = '';

    public $message = '';

    public $progressbar = false;

    public $link = false;

    public $target = '_blank';

    public $type = 'info';

    protected $defaultSettings = array();

    public $settings = array();


    public function init()
    {

        $this->defaultSettings = $this->getDefaultSetting();
        $settings = CMap::mergeArray($this->settings, $this->defaultSettings);
        $this->settings = json_encode($settings);

        $this->registerScipts();
    }


    protected function registerScipts()
    {
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assets = Yii::app()->getAssetManager()->publish($dir);

        $cs=Yii::app()->getClientScript();

        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($assets . '/js/bootstrap-notify.min.js',CClientScript::POS_END);

        $js = <<<EOP
        
        $.fn.createNoty = function(){
            var notify = $.notify( {
                icon : '{$this->icon}',
                title: '{$this->title}',
                message: '{$this->message}',
                url : '{$this->link}',
                target: '{$this->target}'
            }, {$this->settings});
        }
        

EOP;
        $cs->registerScript('Yii.' . get_class($this) , $js);
    }


    protected function getDefaultHtml()
    {
        $content = '';
        $content .= CHtml::openTag('div',['data-notify'=>'container', 'class'=>'col-xs-11 col-sm-3 alert alert-{0}', 'role'=>'alert']);

        $content .= CHtml::button('×',['type'=>'button','aria-hidden'=>'true','class'=>'close', 'data-notify'=>'dismiss']);

        $content .= CHtml::openTag('span',['data-notify'=>'icon']);
        $content .= CHtml::closeTag('span');

        $content .= CHtml::openTag('span',['data-notify'=>'title']);
        $content .= '{1}';
        $content .= CHtml::closeTag('span');

        $content .= CHtml::openTag('span',['data-notify'=>'message']);
        $content .= '{2}';
        $content .= CHtml::closeTag('span');

        if($this->progressbar){
            $content .= CHtml::openTag('div',['class'=>'progress', 'data-notify'=>'progressbar']);

            $content .= CHtml::openTag('div',[
                    'class'=>'progress-bar progress-bar-{0}',
                    'role'=>'progressbar',
                    'aria-valuenow'=>'0',
                    'aria-valuemin'=>'0',
                    'aria-valuemax'=>'100',
                    'style'=>'width: 0%;'
                ] ).CHtml::closeTag('div');

            $content .= CHtml::closeTag('div');
        }

        if($this->link){
            $content .= CHtml::openTag('a', ['href'=>'{3}','target'=>'{4}','data-notify'=>'url']).CHtml::closeTag('a');
        }

        $content .= CHtml::closeTag('div');

        return $content;
    }


    protected function getDefaultSetting()
    {
        return array(
            'element'=>'body',
            'position' =>null,
            'type'=>$this->type,
            'allow_dismiss'=>true,
            'newest_on_top'=>false,
            'showProgressbar'=>$this->progressbar,
            'placement'=>array(
                'from'=>'bottom',
                'align'=>'right'
            ),
            'offset'=>20,
            'spacing'=>10,
            'z_index'=>1031,
            'delay'=>5000,
            'timer'=>1000,
            'url_target'=>$this->target,
            'mouse_over'=>null,
            'animate'=>array(
                'enter'=>'animated fadeInDown',
                'exit'=>'animated fadeOutUp'
            ),
            'onShow'=>null,
            'onShown'=>null,
            'onClose'=>null,
            'onClosed'=>null,
            'icon_type' => 'class',
            'template' =>$this->getDefaultHtml()
        );
    }
}