<?php
Yii::import('application.extensions.widgets.noty.NotificationWidget');
//Yii::import('application.modules.task.models.TaskAssign');

/**
 * @author Yaroslav Fedan <yaroslav.fd@gmail.com>
 * @link https://github.com/YaroslavFedan
 */
class TaskWidget extends NotificationWidget
{
    public $taskSettings;

    public $target='_self';

    public $sound_signal = true;

    public $htmlOptions = array(); //danger, info, success, warning

    public $closeButton = true;

    public $url = '#';

    public $intervalQuery = 1000;

    public function init()
    {

        $this->taskSettings['template'] = $this->getDefaultHtml();

        $this->taskSettings = json_encode($this->taskSettings);

        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assets = Yii::app()->getAssetManager()->publish($dir);


        if($this->sound_signal)
        {
            echo CHtml::openTag('audio',['id'=>'chatAudio']);
            echo CHtml::openTag('source',['src'=>$assets.'/sound/notify.ogg','type'=>'audio/ogg']);
            echo CHtml::openTag('source',['src'=>$assets.'/sound/notify.mp3','type'=>'audio/mpeg']);
            echo CHtml::openTag('source',['src'=>$assets.'/sound/notify.wav','type'=>'audio/wav']);
            echo CHtml::closeTag('audio');
        }

        $cs=Yii::app()->getClientScript();

        $cs->registerCssFile($assets .'/css/min-notify.css');

    $js = <<<EOP

        $(document).ready(function(){ setTimeout(function(){getNewTask();}, 20000)})
          
        $.fn.createNotyTask = function(message){
            var notify = $.notify( message, {$this->taskSettings} );
            if(parseInt({$this->sound_signal})){
                $('#chatAudio')[0].play();
            }
            $('#new_bid').removeClass('hidden');
            if(typeof $.fn.yiiGridView !== typeof undefined){
                $.fn.yiiGridView.update('task-history-grid');
            }
        }
        setInterval(function() {getNewTask(); }, {$this->intervalQuery});
        function getNewTask(){
            $.ajax({
                type : "post",
                url : '{$this->url}',
                dataType: "json",
                success: function(data){
                    $.fn.createNotyTask(data);
                    console.log(data);
                }
            })
        }
EOP;

        $cs->registerScript('Yii.' . get_class($this) , $js, CClientScript::POS_END);
        return parent::init();
    }

    protected function getDefaultHtml()
    {
        $content = '';
        $content .= CHtml::openTag('div',$this->htmlOptions);
        if($this->closeButton){
            $content .= CHtml::button('×',['type'=>'button','aria-hidden'=>'true','class'=>'close', 'data-notify'=>'dismiss']);
        }
        $content .= CHtml::openTag('span',['data-notify'=>'title']);
        $content .= '{1}';
        $content .= CHtml::closeTag('span');
        $content .= CHtml::openTag('span',['data-notify'=>'message']);
        $content .= '{2}';
        $content .= CHtml::closeTag('span');
        $content .= CHtml::openTag('a', ['href'=>'{3}','target'=>'{4}','data-notify'=>'url']).CHtml::closeTag('a');
        $content .= CHtml::closeTag('div');
        return $content;
    }

}