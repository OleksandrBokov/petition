<?php

Yii::import('application.extensions.widgets.angular.AngularWidget');
class GoogleMapWidget extends AngularWidget
{


    public $defaultConfig = array(
        'ApiKey'=>'',
        'language'=>'en',
        'map'=>array(
            'lat'=>'49.2882399',
            'lng'=>'30.1623471',
            'zoom'=>6,
        ),
        'markers'=>array(),
        'appController'=>'',
        'search'=>false,
        'showInfoBox'=>0
    );
    public $config = array(
//        'ApiKey'=>'',
//        'language'=>'en',
//        'map'=>array(
//            'lat'=>'49.2882399',
//            'lng'=>'30.1623471',
//            'zoom'=>6,
//        ),
//        'markers'=>array(),
//        'appController'=>'',
//        'search'=>false,
//        'showInfoBox'=>1
    );


    public $init= array();

    protected $cs;

    public $content = '';

    public function init()
    {

        if(empty($this->config['appController']))
            throw new CException(Yii::t('yiiext','The appController can not be empty.'));

        $this->config = CMap::mergeArray($this->defaultConfig, $this->config);


        $this->init = json_encode($this->config);

        $this->content .= CHtml::openTag('div',[ 'id'=>$this->config['appController'], 'data-ng-controller'=>$this->config['appController'], 'class'=>'ng-cloak']);

        $this->content .= $this->renderMap();

        if( $this->config['search'] ){
            $this->content .= $this->formSearch();
        }

        $this->content .= CHtml::closeTag('div');

        echo $this->content;

        $this->registerScript();
    }


    public function renderMap(){

        return "<div id='map-canvas' style='height: 500px;' google-map data-ng-init='init({$this->init})'></div>";
    }

    public function formSearch()
    {
        $content = '';
        $content .=  CHtml::openTag('span', ['class'=>'map-reload']);
            $content .=  CHtml::openTag('a', [
                'ng-click'=>'reload()',
                'data-toggle'=>'tooltip',
                'title'=>'Перезагрузить'
            ]);
            $content .=  CHtml::openTag('i', ['class'=>'fa fa-refresh']);
            $content .=  CHtml::closeTag('i');
            $content .=  CHtml::closeTag('a');
        $content .=CHtml::closeTag('span');

        $content .= CHtml::openTag('div',['class'=>'callout callout-info', 'style'=>'margin-top:15px;']);
        $content .= CHtml::openTag('p');
        $content .= Yii::t('main','Вы можете ввести адрес для поиска координат, или же кликнуть по адресу на карте.');
        $content .= CHtml::closeTag('p');
        $content .= CHtml::closeTag('div');

        $content .= CHtml::openTag('div',['class'=>'input-group', 'style'=>'margin-top:15px;']);
        $content .= CHtml::textField('find-to-map', '',[
            'class'=>'form-control',
            'id'=>'find-to-map',
            'data-ng-enter'=>'findAddress()',
            'placeholder'=>Yii::t('main','Введите адрес ...')
        ]);
        $content .= CHtml::openTag('div',[
            'class'=>'input-group-addon pointer',
            'data-ng-click'=>'findAddress()'
        ]);
        $content .= Yii::t('main','Найти');
        $content .= CHtml::closeTag('div');

        $content .= CHtml::closeTag('div');

        $content .= CHtml::openTag('div', ['class'=>'box-footer', 'style'=>'padding-right:0']);

        $content .= CHtml::openTag('div', ['class'=>'pull-right']);
        $content .= CHtml::openTag('div',['class'=>'loader', 'data-ng-show'=>'loaderShow']).CHtml::closeTag('div');
        $content .= CHtml::openTag('button ',['class'=>'btn btn-success btn-sm', 'data-ng-click'=>'saveMarker()', "ng-disabled"=>"checked"]);
        $content .= "<[ buttonSave ]>";
        $content .= CHtml::closeTag('button');
        $content .= CHtml::closeTag('div');
        $content .= CHtml::closeTag('div');

        return $content;
    }

    public  function registerScript()
    {
        parent::registerScript();

        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assets = Yii::app()->getAssetManager(['linkAssets'=>true])->publish($dir,false, -1, YII_DEBUG);
        $cs=Yii::app()->getClientScript();

        $cs->registerScriptFile('https://maps.google.com.ua/maps/api/js?key='.$this->config['ApiKey'].'&language='.$this->config['language'],
            CClientScript::POS_END);

        $cs->registerScriptFile($assets.'/js/'.$this->config['appController'].'.js', CClientScript::POS_END);

        $cs->registerCssFile($assets .'/css/def-map.css');

        if($this->config['showInfoBox'])
            $cs->registerCssFile($assets .'/css/map.css');

    }
}