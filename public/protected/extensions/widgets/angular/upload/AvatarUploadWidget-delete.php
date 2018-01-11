<?php

/**
 * @author Yaroslav Fedan <yaroslav.fd@gmail.com>
 * @link https://github.com/YaroslavFedan
 */
Yii::import('application.extensions.widgets.angular.upload.UploadWidget');

class AvatarUploadWidget extends UploadWidget
{

    public $initConfig;

    public $item;

    public $model = false;
    public $attribute = false;

    public $defaultItem = array(
        'label'=>'',
        'alt'=>'',
        'labelHtmlOptions'=>array(''),
        'itemPreviewOptions'=>array('')
    );


    public $assets;

    public function init()
    {
        if(!$this->model) throw new CException(Yii::t('yiiext','The model can not be empty.'));

    //    if(!$this->attribute) throw new CException(Yii::t('yiiext','The attribute can not be empty.'));

//        echo "<pre>";
//        print_r($this->model);
//        echo "</pre>";
//        echo "<pre>";
//        print_r($this->attribute);
//        echo "</pre>";

        $this->item = CMap::mergeArray($this->defaultItem, $this->item);

        $this->initConfig = json_encode($this->config);

        $this->maxSize = $this->maxSize * 1000000;

        $this->registerScript();

        echo $this->renderHtml();
    }

    public  function registerScript()
    {
        parent::registerScript();

        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $this->assets = Yii::app()->getAssetManager(['linkAssets'=>true])->publish($dir,false, -1, YII_DEBUG);
        $cs=Yii::app()->getClientScript();

        $cs->registerScriptFile($this->assets.'/js/ng-file-upload-shim.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($this->assets.'/js/ng-file-upload.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($this->assets.'/js/'.$this->script.'.js', CClientScript::POS_END);
        $cs->registerCssFile($this->assets .'/css/avatar.css');
    }

    protected function renderHtml()
    {
        $content = '';

        $content .= CHtml::openTag('div',[
            'id'=>$this->script,
            'data-ng-controller'=>$this->script,
            'class'=>'ng-cloak',
            'data-ng-init'=>"init({$this->initConfig})"]);


        $content .= CHtml::openTag('div',['class'=>'form-group']);
        /** label item **/
        $content .= CHtml::openTag('label',($this->item['labelHtmlOptions']) ? $this->item['labelHtmlOptions']: array());
        $content .= ($this->item['label']) ? $this->item['label'] : '';
        $content .= CHtml::closeTag('label');
        /** end label item **/

        /** item preview **/
        $content .= CHtml::openTag('div',['class'=>'col-sm-7', 'style'=>'position:relative;text-align:center;',
            'ng-form'=>'ng-form', 'name'=>"avatarForm"]);

        /*** show default picture ***/
        $content .= CHtml::openTag('div',['ng-show'=>'!photo.file']);
        $content .= CHtml::image($this->assets.'/img/camera_200.png',
            (isset($this->item['alt'])) ? $this->item['alt'] : '',
            ($this->item['itemPreviewOptions']) ? $this->item['itemPreviewOptions']: array());
        $content .= CHtml::closeTag('div');
        /*** end show default picture ***/
        /*** show upload fie ***/
        $content .= CHtml::openTag('div',['ng-show'=>'photo.file']);
        $content .= CHtml::image('','',[
            'style'=>'width:100px;height:100px; border-radius:50px',
            'ngf-thumbnail'=>'photo.base64',
            'class'=>'thumb'
        ]);
        $content .= CHtml::closeTag('div');
        /*** end show upload fie ***/

        /*** upload button ***/

        $content .= CHtml::openTag('input', [
            'type'=>'file',
            'class'=>'upload-photo',
            'ngf-select'=>'ngf-select',
            'ng-model'=>'files',
            'name'=>'file',
            'ngf-pattern'=>"'image/*'",
            'ngf-accept'=>"'image/*'",
            'ngf-max-size'=>"{$this->maxSize}",
        ]);

        /*** end upload button***/

        $content .= CHtml::openTag('div',['class'=>'clearfix']).CHtml::closeTag('div');
        /*** error file size***/
        $content .= CHtml::openTag('span',['data-ng-show'=>'avatarForm.file.$error.maxSize', 'class'=>'errorMessage']);
        $content .= $this->maxSizeErrorMessage;
        $content .= CHtml::closeTag('span');
        /*** end error file size***/

        $content .= CHtml::closeTag('div');
        /** end item preview **/
        $content .= CHtml::activeTextArea($this->model, 'byte_code' ,['value'=>'<[photo.base64]>', 'class'=>'hidden']);


        $content .= CHtml::closeTag('div');
        $content .= CHtml::closeTag('div');

        return $content;
    }
}