<?php


class ResFileManager extends CWidget
{

    public $subfolder;
    public $path;
    public $model;
    public $attr = array();
    public $type = 'image';
    public $filemanager_path = "/protected/extensions/filemanager/dialog.php";
    public $defaultImage = "";

    public function init()
    {
        if(!$this->defaultImage) {
            $this->defaultImage = Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('ext.filemanager.img').'/noimage.gif', false, -1, YII_DEBUG);
        }

        /** get default configuration **/
        $config = include_once 'config/config.php';
        if(!$config){
            extract($config, EXTR_OVERWRITE);
            $_SESSION["RF"]["upload_dir"] = $config['upload_dir'];
        }

        /**  if need  set folder to upload files **/
        $_SESSION["RF"]["subfolder"] = $this->subfolder;
        /** set path to upload files directory **/
        if(!isset($_SESSION["RF"]["upload_dir"])) $_SESSION["RF"]["upload_dir"]= '/uploads/';

        $this->path = $_SESSION["RF"]["upload_dir"].$this->subfolder.DIRECTORY_SEPARATOR;
        self::checkDir($this->path);
        $attribute =<<<EOP
        window.responsive_filemanager_callback = function(field_id){
        //console.log(field_id);
        var value_field = jQuery('#'+field_id).val();
        jQuery("#"+field_id+"_img").attr("src","/uploads/{$this->subfolder}/"+value_field);
        document.getElementById(field_id).value = "/uploads/{$this->subfolder}/"+value_field;
}
EOP;
            Yii::app()->clientScript->registerScript($attribute, $attribute, CClientScript::POS_END);
            $this->registerAssets();
            $this->generateHtml();

    }

    private function registerAssets() {

        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, -1, YII_DEBUG);

        /**@todo if use fancybox **/
        //if($this->crop){

        //}
        Yii::app()->getClientScript()->registerCssFile("{$baseUrl}/css/fancybox/jquery.fancybox.css");
        Yii::app()->getClientScript()->registerScriptFile("{$baseUrl}/helper/jquery-migrate-1.0.0.js", CClientScript::POS_END);
        Yii::app()->getClientScript()->registerScriptFile("{$baseUrl}/js/fancybox/jquery.fancybox.pack.js", CClientScript::POS_END);//,['async'=>'async','onload'=>'initFancyBox()']
    }


    public static function checkDir($path)
    {
        $arr = explode('/',$path);

        $dir = $_SERVER['DOCUMENT_ROOT'];
        for($i = 1; $i < count($arr); $i++)
        {
            $dir = $dir.'/'.$arr[$i];
            if(!empty($arr[$i])){
                self::createDir($dir);
            }
        }

        return true;
    }

    private static function  createDir($path)
    {
        if (!file_exists($path)) {
            mkdir($path , 0777);
            return true;
        }else{
            return false;
        }
    }

    public function generateHtml (){

        $types = [
            'image'=>1,
            'video'=>3,
            'all'=>2
        ];
        $html = '';
        foreach ($this->attr as $k => $v){

            $html .= CHtml::openTag('div',['class'=>'form-group', 'data-name'=>$v]);
            $html .= CHtml::openTag('label');
            $html .= $this->model->getAttributeLabel($v);
            $html .= CHtml::closeTag('label');
            $html .= CHtml::openTag('div',['class'=>$v.' upload-image', 'style'=>"height:200px; width: 100%; position: relative; "]);
            $html .= CHtml::openTag('i',['class'=>'fa fa-hand-pointer-o','style'=>'position: absolute;top: 50%; left: 50%; font-size: 18px; margin-top: -9px; margin-left: -9px;']);
            $html .= CHtml::closeTag('i');
            if(!empty($this->model->$v)){
                $html .= CHtml::image($this->model->$v,'',['class'=>$v, 'id'=>$v.'_img', 'style'=>'visibility: visible; width:200px; height: 200px;']);
            }
            else{
                $html .= CHtml::image($this->defaultImage,'',['id'=>$v.'_img', 'style'=>'visibility: visible; width:100%; height: 200px;']);
            }
            $html .= CHtml::closeTag('div');
            $html .= CHtml::textField(get_class($this->model).'['.$v.']',$this->model->$v,['id'=>$v,'type'=>'text','style'=>'display:none;', 'class'=>'form-control']);
            $html .= CHtml::error($this->model, $v);
            $html .= CHtml::closeTag('div');
            $filemanager_path = $this->filemanager_path . '?type='.$types[$this->type].'&field_id='.$v.'&relative_url=1&lang='.Yii::app()->language;
            $attribute =<<<EOP
                $('.{$v}').fancybox({
                    'width'		: '100%',
                    'height'    : '600',
                    'type'		: 'iframe',
                    'autoScale'    	: true,
                    'href': '{$filemanager_path}',
                
                });
EOP;
            Yii::app()->clientScript->registerScript($attribute, $attribute, CClientScript::POS_END);
        }
        echo $html;

    }
    
}