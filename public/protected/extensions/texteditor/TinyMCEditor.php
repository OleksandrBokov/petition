<?php

/**
 * @author Yaroslav Fedan <yaroslav.fd@gmail.com>
 * @link https://github.com/YaroslavFedan
 */
class TinyMCEditor extends CWidget
{

    public $model;

    public $attribute;

    public $selector;

    public $height = 300;
    public $width = 100;

    public $language;

    public $menubar = 'false';

    public $plugins = array();

    public $toolbar = array();

    public $content_css = '//www.tinymce.com/css/codepen.min.css';

    public $filemanager = true;

    public $htmlOptions = array();

    public $subfolder;

    public $value = '';

    public function init()
    {
        $_SESSION['RF']["subfolder"] = $this->subfolder;


        $arr = explode('/','/uploads/'.$this->subfolder);

        $dir = $_SERVER['DOCUMENT_ROOT'];

        for($i = 1; $i < count($arr); $i++)
        {
            $dir = $dir.'/'.$arr[$i];
            if(!empty($arr[$i])){
                self::createDir($dir);
            }
        }

        if(!$this->model)
            throw new CDbException(Yii::t('yiiext','The model not by empty.'));

        if(!$this->attribute)
            throw new CDbException(Yii::t('yiiext','The attribute not by empty.'));

        if(!$this->selector)
            $this->selector = get_class($this->model).'_'.$this->attribute;

        if(!$this->language)
            $this->language = 'en';

        if(empty($this->plugins))
            $this->plugins = $this->getDefaultPlugins();

        $this->plugins = json_encode($this->plugins);

        if(empty($this->toolbar))
            $this->toolbar = $this->getDefaultToolbars();

        $this->toolbar = json_encode($this->toolbar);

        echo CHtml::activeTextArea($this->model,$this->attribute,['id'=>$this->selector]);

//        echo CHtml::openTag('textArea',['name'=>get_class($this->model).'['.$this->attribute.']', 'id'=>$this->selector,
//        ]);
//        echo $this->value;
//        echo CHtml::closeTag('textArea');

        $this->registerScript();
    }

    protected static function createDir($path)
    {
        if (!file_exists($path)) {
            mkdir($path , 0755);
            return true;
        }else{
            return false;
        }
    }


    protected function registerScript()
    {
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR ;
        $assets = Yii::app()->getAssetManager()->publish($dir);

        $cs=Yii::app()->getClientScript();

        //$cs->registerCoreScript('jquery');

        $cs->registerScriptFile($assets.'/tinymce.min.js',CClientScript::POS_END);


        if($this->filemanager){
                Yii::setPathOfAlias('filemanager_path','/protected/extensions/filemanager');
                Yii::setPathOfAlias('filemanager_plugin','plugins/responsivefilemanager/plugin.js');
                $external_filemanager_path = Yii::getPathOfAlias('filemanager_path');
                $filemanager_plugin = Yii::getPathOfAlias('filemanager_plugin');
        }

$js = <<<EOP
tinymce.init({
    selector: "#{$this->selector}",
    height: "{$this->height}",
    width: "{$this->width}%",
    language: '{$this->language}',
    menubar: {$this->menubar},
    plugins: [
         "advlist  link image lists charmap print preview hr anchor pagebreak responsivefilemanager contextmenu ",
         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking spellchecker",
   ],
    toolbar: {$this->toolbar},
    relative_urls: false,
    image_advtab: true,
    filemanager_crossdomain: true,
    external_filemanager_path: "{$external_filemanager_path}/",
    filemanager_title : "Responsive Filemanager",
    external_plugins : {"filemanager":"{$filemanager_plugin}"},
     paste_process : function(pl, o) {
            // Content DOM node containing the DOM structure of the clipboard
            alert(o.node.innerHTML);
          
     }
 
});
EOP;

        $cs->registerScript('Yii.' . get_class($this) . '#' . $this->attribute, $js,CClientScript::POS_END);
    }


    protected function getDefaultPlugins()
    {
        return array('advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste code');
    }

    protected function getDefaultToolbars()
    {
        return array('code undo redo styleselect bold italic alignleft aligncenter alignright alignjustify bullist numlist outdent indent');
    }
}