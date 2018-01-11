<?php

Yii::import('application.extensions.widgets.angular.AngularWidget');
class EntityWidget extends AngularWidget
{

    public $dataProvider = null;
    public $config = array();

    public $showPrice = true;

    public $model = null;

    public function init()
    {
        $entities = array();
        if($this->model){
            is_array($this->model) or $this->model = array($this->model);
            $entities = $this->getDataByProvider($this->model);
        }

        if($this->dataProvider){
            $model = $this->dataProvider->getData();
            $entities = $this->getDataByProvider($model);
        }


        $entities = json_encode(CMap::mergeArray($entities, $this->config));

        $content = CHtml::openTag('div',[ 'id'=>'entity-map', 'data-ng-controller'=>'entity-map', 'class'=>'ng-cloak', 'data-ng-init'=>"init({$entities})",
            'style'=>'width:100%; height:100%;']);
        $content .= "<div id='map-canvas' style='width:100%; height:100%;' google-map ></div>";
        $content .= CHtml::closeTag('div');
        echo $content;

        $this->registerScript();

    }
    

    protected function getDataByProvider($model)
    {

        $data = array();

        foreach ($model as $key=>$value)
        {
            $data['entities'][$key]['id']=$value['id'];

            if($this->config['showPrice']){
                $data['entities'][$key]['min_price'] = Yii::t('main','от').' '.Entity::model()->getMinPrice($value['id']).' '.Yii::t('main','грн/час');
            }

            $data['entities'][$key]['photo'] = GalleryEntity::model()->getPhoto($value['id']);//$value->galleryEntities[0]->item;
            $data['entities'][$key]['lat'] = $value->info->lat;
            $data['entities'][$key]['lng'] = $value->info->lng;
            $data['entities'][$key]['name'] = $value->info->name;
            $data['entities'][$key]['address'] = $value->info->address;
            $data['entities'][$key]['link'] = Yii::app()->createUrl('/'.TypeEntity::getTypeNameById($value->type_entity_id).'/'.$value['id']);
            $data['entities'][$key]['countComments'] = '';
            $data['entities'][$key]['rating'] = 0;
        }

        return $data;
    }


    public  function registerScript()
    {
        parent::registerScript();

        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assets = Yii::app()->getAssetManager(['linkAssets'=>true])->publish($dir,false, -1, YII_DEBUG);
        $cs=Yii::app()->getClientScript();

        $cs->registerScriptFile('https://maps.google.com.ua/maps/api/js?key='.$this->config['ApiKey'].'&language='.$this->config['language'],
            CClientScript::POS_END);

        $cs->registerScriptFile($assets.'/js/markerclusterer.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/entity-map.js', CClientScript::POS_END);

        $cs->registerCssFile($assets .'/css/map.css');

    }
}