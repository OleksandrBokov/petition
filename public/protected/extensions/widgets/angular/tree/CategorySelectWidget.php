<?php


Yii::import('application.extensions.widgets.angular.AngularWidget');

class CategorySelectWidget extends AngularWidget
{

    public $search = true;

    public $config = array();

    public function init()
    {
        $this->config = json_encode($this->config);

        $this->registerScript();

        echo $this->renderHtml();
    }

    public  function registerScript()
    {
        parent::registerScript();

         $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
         $assets = Yii::app()->getAssetManager(['linkAssets'=>true])->publish($dir,false, -1, YII_DEBUG);
         $cs=Yii::app()->getClientScript();

         $cs->registerScriptFile($assets.'/js/category-select.js', CClientScript::POS_END);
         $cs->registerCssFile($assets .'/css/category-select.css');
    }

    protected function renderHtml()
    {
        $content = '';

        $content .= CHtml::openTag('div',['class'=>'col-sm-12']);

        $content .= CHtml::openTag('div',[
            'id'=>'category-select',
            'data-ng-controller'=>'category-select',
            'class'=>'ng-cloak',
            'data-ng-init'=>"init({$this->config})",]);

        $content .= '<div category-select-view ></div>';

        $content .= '<script type="text/ng-template" id="category-select.html">';

        $content .= $this->createTemplate();

        $content .= '</script>';


        if($this->search){
            $content .= CHtml::textField('search','',[
                'class'=>'form-control',
                'placeholder' => Yii::t('main','поиск').' ...',
                'data-ng-model'=>'searchCategory',
            ]);
        }

        $content .= CHtml::openTag('div',['class'=>'col-sm-12 category-widget overflow']);

        $content .= CHtml::openTag('ol', ['class'=>'checkbox-list']);
        $content .= '<li ng-repeat="node in list | filter: searchCategory" ng-include="\'category-select.html\'" ></li>';
        $content .= CHtml::closeTag('ol');

        $content .= CHtml::closeTag('div');

        $content .= $this->renderButton();

        $content .= CHtml::closeTag('div');

        $content .= CHtml::closeTag('div');

        return $content;
    }

    public function createTemplate() {

        $content = '';

        $content .= CHtml::openTag('input',[
                'type'=>'checkbox',
                'class'=>'checkbox',
                'id'=>"checkbox-<[node.id]>",
                'ng-checked'=>'node.checked',
                'ng-click'=>'setToggleChecked(node.id)'
            ]);

        $title = '<[node.title]>';
        $content .= CHtml::label($title,'checkbox-<[node.id]>',['data-ng-click'=>'setChecked(node.id)']);

        $content .= CHtml::openTag('ol',[ 'ng-model'=>'node.nodes', 'class'=>'checkbox-list']);

        $content .= '<li ng-repeat="node in node.nodes" ng-include="\'category-select.html\'" ></li>';

        $content .= CHtml::closeTag('ol');

        return $content;
    }

    public function renderButton()
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
}