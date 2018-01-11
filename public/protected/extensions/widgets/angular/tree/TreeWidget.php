<?php

/**
 * @author Yaroslav Fedan <yaroslav.fd@gmail.com>
 * @link https://github.com/YaroslavFedan
 */
Yii::import('application.extensions.widgets.angular.AngularWidget');
Yii::import('application.extensions.widgets.angular.TemplateView');


class TreeWidget extends AngularWidget implements TemplateView
{

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


        $cs->registerScriptFile($assets.'/js/angular-ui-tree.min.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/tree.js', CClientScript::POS_END);

        $cs->registerCssFile($assets .'/css/angular-ui-tree.css');
    }


    protected function renderHtml()
    {
        $content = '';

        $content .= CHtml::openTag('div',[
            'id'=>'simple-tree',
            'data-ng-controller'=>'simple-tree',
            'class'=>'ng-cloak',
            'data-ng-init'=>"init({$this->config})",]);
        $content .= '<div tree-view ></div>';

        $content .= '<script type="text/ng-template" id="simple-tree.html">';

        $content .= CHtml::openTag('div',['ui-tree-handle'=>'ui-tree-handle']);
        $content .= '<[node.title]>';
        $content .= CHtml::closeTag('div');

        $content .= CHtml::openTag('ol',['ui-tree-nodes'=>'', 'ng-model'=>'node.nodes']);

        $content .= '<li ng-repeat="node in node.nodes" ui-tree-node ng-include="\'simple-tree.html\'"></li>';

        $content .= CHtml::closeTag('ol');

        $content .= '</script>';

        $content .= '<div ui-tree data-nodrop-enabled="true">';
        $content .= CHtml::openTag('ol',['ui-tree-nodes'=>'', 'ng-model'=>'list', 'id'=>"tree-root"]);


        $content .= '<li ng-repeat="node in list" ui-tree-node ng-include="\'simple-tree.html\'" ></li>';

        $content .= CHtml::closeTag('ol');
        $content .='</div>';

        $content .= CHtml::closeTag('div');

        return $content;
    }


    public function createTemplate() {

    }
}