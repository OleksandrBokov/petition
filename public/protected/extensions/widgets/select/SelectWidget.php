<?php

class SelectWidget extends CWidget
{
    public $htmlOptions = array();

    public $type = 'default';

    public $dataContent = array();

    public $content = array();

    public $model = false;

    public $attribute = false;

    public $translate = true;

    public $language = false;

    public $search = false;

    public $cs;

    public $empty = array();

    public $selected = false;

    public $id;

    protected $name;

    public $title ='';


    public function init()
    {
        if(!$this->language)
            $this->language = Yii::app()->language.'_'.strtoupper(Yii::app()->language);
        else
            $this->language = $this->language.'_'.strtoupper($this->language);


        if($this->type != 'default'){
            if(!$this->model)
                throw new CException(Yii::t('yiiext','The model can not be empty.'));

            if(!$this->attribute)
                throw new CException(Yii::t('yiiext','The attribute can not be empty.'));


            $this->id = get_class($this->model).'_'.$this->attribute;
            $this->name = get_class($this->model).'['.$this->attribute.']';

            $arr_conf = array( 'id'=>$this->id,  'name'=>$this->name);
            $this->htmlOptions = CMap::mergeArray($this->htmlOptions, $arr_conf);
        }

        $this->registerScripts();
        $this->_setSelect();

    }

    protected function _setSelect()
    {
        switch($this->type){
            case 'select2':
                $this->select2();
                break;
            default:
                $this->defaultSelect();
        }
    }

    protected function defaultSelect()
    {
        $content = '';

        if(!empty($this->dataContent)){
            $content .= CHtml::openTag('select', $this->htmlOptions);

            foreach($this->dataContent as $key=>$value)
            {
                $content .= CHtml::openTag('option',['value'=>$key, 'data-content'=>$value]);
                $content .= $key;
                $content .= CHtml::closeTag('option');
            }
            $content .= CHtml::closeTag('select');

            echo $content;
        }
    }

    protected function select2()
    {
        $content = '';
        if(!empty($this->dataContent)){
            $content .= CHtml::openTag('select', $this->htmlOptions);

            foreach($this->dataContent as $key=>$value)
            {
                $content .= CHtml::openTag('option',['value'=>$key, 'data-content'=>$value]);
                $content .= $key;
                $content .= CHtml::closeTag('option');
            }
            $content .= CHtml::closeTag('select');
        }
        echo $content;

    }


    protected function registerScripts()
    {
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assets = Yii::app()->getAssetManager()->publish($dir);

        $this->cs=Yii::app()->getClientScript();

        $this->cs->registerCoreScript('jquery');
        $this->cs->registerCssFile($assets .'/css/bootstrap-select.min.css');
        $this->cs->registerCssFile($assets .'/css/select-style.css');
        $this->cs->registerScriptFile($assets . '/js/bootstrap-select.js',CClientScript::POS_END);//min.
        if($this->translate)
            $this->cs->registerScriptFile($assets . '/js/i18n/defaults-'.$this->language.'.min.js',CClientScript::POS_END);


        $js = <<<EOP
        $(document).on('ready', function(){
            $("#{$this->id}").selectpicker({
                'liveSearch': "{$this->search}"
            }).on('loaded.bs.select', function(e){
                $("#{$this->id}").selectpicker('val',"{$this->selected}");
            })
        })
EOP;
        $this->cs->registerScript('Yii.' . get_class($this) . '#' . $this->attribute, $js,CClientScript::POS_END);
    }
}