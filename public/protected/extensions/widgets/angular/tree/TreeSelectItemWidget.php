<?php

Yii::import('application.extensions.widgets.angular.AngularWidget');
Yii::import('application.extensions.widgets.angular.tree.TreeWidget');

class TreeSelectItemWidget extends TreeWidget
{

    public $search = true;

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

       // $cs->registerScriptFile($assets.'/js/select-item-tree.js', CClientScript::POS_END);
       // $cs->registerCssFile($assets .'/css/select-tree.css');
    }

    protected function renderHtml()
    {

        $content = '';

        $content .= CHtml::openTag('div',[
            'id'=>'select-tree',
            'data-ng-controller'=>'select-tree',
            'class'=>'ng-cloak',
            'data-ng-init'=>"init({$this->config})",]);
        $content .= '<div select-tree-view ></div>';

        $content .= '<script type="text/ng-template" id="select-tree.html">';



        $content .= $this->createTemplate();

        $content .= '</script>';

        if($this->search){
            $content .= CHtml::textField('search','',[
                'class'=>'form-control',
                'placeholder' => Yii::t('main','поиск').' ...',
                'data-ng-model'=>'query',
                'ng-change'=>'findNodes()'
            ]);
        }

        $content .= '<div ui-tree data-nodrop-enabled="true" id="tree-root">';

        $content .= CHtml::openTag('ol',['ui-tree-nodes'=>'', 'ng-model'=>'list']);
        $content .= '<li ng-repeat="node in list" ui-tree-node ng-include="\'select-tree.html\'" ng-show="visible(node)"></li>';
        $content .= CHtml::closeTag('ol');

        $content .='</div>';

        $content .= CHtml::closeTag('div');

        return $content;
    }

    public function createTemplate() {

        $content = '';

        $content .= CHtml::openTag('div',['class'=>'tree-node tree-node-content']);

        $content .= CHtml::openTag('a',['class'=>'btn btn-success btn-xs', 'data-nodrag'=>'data-nodrag', ' ng-click'=>'toggle(this)', 'ng-show'=>'checkChildNode(node)']);

        $content .= CHtml::openTag('span',['class'=>'glyphicon', 'ng-class'=>"{'glyphicon-chevron-right': collapsed, 'glyphicon-chevron-down': !collapsed}"]);
        $content .= CHtml::closeTag('span');

        $content .= CHtml::closeTag('a');

        $content .= '<[node.title]>';
        $content .= CHtml::closeTag('div');

        $content .= CHtml::openTag('ol',['ui-tree-nodes'=>'', 'ng-model'=>'node.nodes', 'ng-class'=>"{hidden: collapsed}"]);

        $content .= '<li ng-repeat="node in node.nodes" ui-tree-node ng-include="\'select-tree.html\'" ng-show="visible(node)"></li>';

        $content .= CHtml::closeTag('ol');

        return $content;

    }

}