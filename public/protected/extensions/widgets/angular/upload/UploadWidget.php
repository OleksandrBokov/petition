<?php

Yii::import('application.extensions.widgets.angular.AngularWidget');

class UploadWidget extends AngularWidget
{

    public $script;

    public $maxSize = '2';

    public $minHeight = '100';

    public $maxSizeErrorMessage = 'File to large: max 2MB';

    public $buttonUpload = array(
        'label'=>'select',
        'class'=>'btn btn-primary btn-sm pull-right'
    );


    public $config = array();

    public function init()
    {

        $this->config = json_encode($this->config);

        $this->maxSize = $this->maxSize * 1000000;

        $this->registerScript();

        echo $this->renderHtml();
    }
    
    public  function registerScript()
    {
        parent::registerScript();

        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assets = Yii::app()->getAssetManager(['linkAssets'=>true])->publish($dir,false, -1, YII_DEBUG);
        $cs=Yii::app()->getClientScript();

        $cs->registerScriptFile($assets.'/js/ng-file-upload-shim.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/ng-file-upload.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/'.$this->script.'.js', CClientScript::POS_END);
        $cs->registerCssFile($assets .'/css/upload.css');
    }


    protected function renderHtml()
    {
        $content = '';

        $content .= CHtml::openTag('div',[
            'id'=>$this->script,
            'data-ng-controller'=>$this->script,
            'class'=>'ng-cloak',
            'data-ng-init'=>"init({$this->config})"]);

        /*** form to upload ***/
        $content .= CHtml::openTag('form',[
            'name'=>'form',
            'novalidate'=>'novalidate'
        ]);
         /*** upload button ***/
        $content .= CHtml::openTag('div', [
            'class'=>$this->buttonUpload['class'],
            'ngf-select'=>'ngf-select',
            'ng-model'=>'files',
            'name'=>'file',
            'ngf-pattern'=>"'image/*'",
            'ngf-accept'=>"'image/*'",
            'ngf-max-size'=>"{$this->maxSize}",
          //  'ngf-resize'=>"{width: 200, height: 200}"
        ]);
        $content .= $this->buttonUpload['label'];
        $content .= CHtml::closeTag('div');
        /*** end upload button***/

        $content .= CHtml::openTag('div',['class'=>'clearfix']).CHtml::closeTag('div');
        /*** preview upload picture ***/
        $content .= CHtml::openTag('div',['class'=>'row upload-list', 'data-ng-show'=>"uploadList.length" ]);

        $content .= CHtml::openTag('div',['class'=>'col-sm-2 upload-item','data-ng-repeat'=>"(key, item) in uploadList"]);

        $content .= '<img ngf-thumbnail="item.file" class="thumb" style="width: 100%">';//

        $content .= CHtml::openTag('span',[
            'class'=>'remove-upload-item',
            'data-ng-click'=>'removeUploadItem($index)',
            'data-toggle'=>'tooltip',
            'title'=>'Удалить'
        ]);
        $content .= CHtml::openTag('i',['class'=>'fa fa-close']).CHtml::closeTag('i');
        $content .= CHtml::closeTag('span');

        $content .= CHtml::closeTag('div');

        $content .= CHtml::openTag('div',['class'=>'clearfix']).CHtml::closeTag('div');
        $content .= CHtml::closeTag('div');
        /*** end preview upload picture ***/

        /*** error file size***/
        $content .= CHtml::openTag('span',['data-ng-show'=>'form.file.$error.maxSize', 'class'=>'errorMessage']);
        $content .= $this->maxSizeErrorMessage;
        $content .= CHtml::closeTag('span');
        /*** end error file size***/


        $content .= CHtml::openTag('div', ['class'=>'box-footer', 'style'=>'padding-right:0', 'data-ng-show'=>'uploadList.length ']);//'data-ng-show'=>"uploadList.length"
        $content .= CHtml::openTag('div', ['class'=>'pull-right']);

        $content .= CHtml::openTag('div',['class'=>'loader', 'data-ng-show'=>'loaderShow']).CHtml::closeTag('div');
        $content .= CHtml::openTag('button ',['class'=>'btn btn-success btn-sm', 'data-ng-click'=>'uploadFiles()', "ng-disabled"=>"checked"]);
        $content .= "<[ buttonSave ]>";
        $content .= CHtml::closeTag('button');
        $content .= CHtml::closeTag('div');
        $content .= CHtml::closeTag('div');


        $content .= CHtml::closeTag('form');
        /***  end form ***/


        /*** picture list ***/
        $content .= CHtml::openTag('div',['class'=>'row picture-list', 'data-ng-show'=>"pictureList.length" ]);

        $content .= CHtml::openTag('div',['class'=>'col-sm-6 upload-item','data-ng-repeat'=>"(key, item) in pictureList"]);

        $content .= '<img ngf-src="item.item" ng-if="item.item" style="width: 100%"/>';//
        $content .= '<img ngf-thumbnail="item.byte_code" ng-if="!item.item" style="width: 100%"/>';//

        $content .= CHtml::openTag('span',[
            'class'=>'remove-upload-item',
            'data-ng-click'=>'deletePicture($index)',
            'data-toggle'=>'tooltip',
            'title'=>'Удалить'
        ]);
        $content .= CHtml::openTag('i',['class'=>'fa fa-close']).CHtml::closeTag('i');
        $content .= CHtml::closeTag('span');

        $content .= CHtml::closeTag('div');

        $content .= CHtml::closeTag('div');
        /*** end picture list ***/


        $content .= CHtml::closeTag('div');

        return $content;
    }


}