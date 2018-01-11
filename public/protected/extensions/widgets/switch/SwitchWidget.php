<?php

class SwitchWidget extends CWidget
{
    public $model;

    public $attribute;

    /**
     * @var array default HTML attributes for each radio item (applicable only if `type` = 2)
     */
    public $itemOptions = [];

    /**
     * @var array default HTML attributes for each radio item label
     */
    public $labelOptions = [];

    public $htmlOptions = ['class'=>'form-control'];

    public $on_label = true;

    public $onText = 'Yes';

    public $offText = 'No';

    protected $_checked = '';

    public $onValue = 1;

    public $offValue = 0;

    public $handleWidth = '114px';

    public $onColor = 'primary';
    public $offColor = 'default';



    public function init()
    {
        $attribute = $this->attribute;

        $this->_checked = ($this->model->$attribute == 1) ? 'checked' : '';

        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assets = Yii::app()->getAssetManager()->publish($dir);

        $cs=Yii::app()->getClientScript();

        $cs->registerCssFile($assets .'/css/bootstrap-switch.min.css');

        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($assets . '/js/bootstrap-switch.js',CClientScript::POS_END);

        $name =  get_class($this->model).'['.$this->attribute.']';
        $id = get_class($this->model).'_'.$this->attribute.'_swicher';

        if($this->on_label){
            echo CHtml::activeLabel($this->model, $this->attribute, $this->labelOptions);
        }

        echo "<input type='checkbox'".$this->_checked."  id='".$id."' > ";
        echo "<input type='text'  name='".$name."' value= '".$this->model->$attribute."' class='{$id} hidden'>";
        $js = <<<EOP

        $(document).on('ready', function(){
            $("#{$id}").bootstrapSwitch({
                onText: '{$this->onText}',
                offText: '{$this->offText}',
                onColor: '{$this->onColor}',
                offColor: '{$this->offColor}',
                handleWidth: '{$this->handleWidth}',
                onSwitchChange: function(e, state){ 
             
                    if(state){ 
                        $(this).val({$this->onValue});
                        $('.{$id}').val({$this->onValue});
                    }else{
                        $(this).val({$this->offValue});
                        $('.{$id}').val({$this->offValue});
                    }
                }
                
            });
        })


EOP;

        $cs->registerScript('Yii.' . get_class($this) . '#' . $this->attribute, $js);
    }


}