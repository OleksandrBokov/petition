<?php

Yii::import('application.extensions.widgets.angular.AngularWidget');

class CategorySearchWidget extends AngularWidget
{

    public $type_entity = false;
    public $language = false;
    public $name ='';
    public $value ='';

    public $htmlOptions = array( );
    public $defaultHtmlOptions = array();

    protected $_categories = array();

    public function init()
    {
        if(!$this->language)
            $this->language = Yii::app()->language;

        if(!$this->type_entity)
            throw new CException(Yii::t('yiiext','The type_entity can not be empty.'));

        $this->_categories = $this->findCategories();
        $data['categories'] = $this->_categories;
        $data['sport'] = $this->value;

        $this->_categories = json_encode($data);

        $this->defaultHtmlOptions = array(
            'class'=>'live-search',
            'type'=>'text',
            'placeholder'=>Yii::t('main','выберите вид спорта'),
            'maxlength'=>255,
            'ng-model'=>'query',
            'ng-click'=>'clearQuery()'
        );

        $htmlOptions = CMap::mergeArray( $this->defaultHtmlOptions, $this->htmlOptions);

        $this->registerScript();
        echo $this->renderHtml($htmlOptions);
    }

    public  function registerScript()
    {
        parent::registerScript();

        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assets = Yii::app()->getAssetManager(['linkAssets'=>true])->publish($dir,false, -1, YII_DEBUG);
        $cs=Yii::app()->getClientScript();

        $cs->registerScriptFile($assets.'/js/search.js', CClientScript::POS_END);

        $cs->registerCssFile($assets .'/css/search.css');
    }


    protected function renderHtml()
    {
        $content = '';
        $content .= CHtml::openTag('div',[
            'id'=>'category-search',
            'data-ng-controller'=>'category-search',
            'class'=>'ng-cloak',
            'data-ng-init'=>"init({$this->_categories})"]);
        $content .= CHtml::textField('', '', $this->defaultHtmlOptions);
        $content .= CHtml::textField($this->name, $this->value, ['ng-model'=>'sport',  'class'=>'hidden']);

        $content .= CHtml::openTag('ul',['id'=>'search-list', 'data-ng-hide'=>'!query', 'data-ng-show'=>'query']);
        $content .= CHtml::openTag('li',['data-ng-repeat'=>'item in categories | search: this as results' ,//query as results
            'ng-bind-html'=>"item | highlight: query", 'ng-click'=>"setQuery(item)" ]);
        $content .= '<[item.name]>';
        $content .= CHtml::closeTag('li');
        $content .= CHtml::openTag('li',['data-ng-hide'=>'results.length || sport.length']);
        $content .= '<em>'.Yii::t('main','Совпадений не найдено').'</em>';
        $content .= CHtml::closeTag('li');

        $content .= CHtml::closeTag('ul');

        $content .= CHtml::closeTag('div');

        return $content;
    }

    protected function findCategories()
    {
        return Yii::app()->db->createCommand()
            ->select('t.url, COALESCE( NULLIF(cl.l_name,""), t.name) AS name')
            ->from('category t')
            ->join('category_lang cl','cl.owner_id = t.id')
            ->where(' t.type_entity_id =:type_entity_id AND cl.lang_id =:lang_id AND show_in_search = :show',[
                ':type_entity_id'=>$this->type_entity,
                ':lang_id'=>$this->language,
                ':show'=>true
            ])->queryAll();
    }
}