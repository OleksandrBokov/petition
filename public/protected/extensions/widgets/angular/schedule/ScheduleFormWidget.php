<?php

Yii::import('application.extensions.widgets.angular.AngularWidget');
Yii::import('application.extensions.widgets.angular.schedule.models.ScheduleActiveRecords');

class ScheduleFormWidget extends AngularWidget
{
    public $init = array();

    public $getData;
    public $setData;

    public function init()
    {
        $this->init = array( 'getData'=>$this->getData, 'setData'=>$this->setData );
        $this->init = json_encode(CMap::mergeArray($this->init, array('buttonSave'=>Yii::t('main','сохранить'))));

        $this->registerScript();

        echo $this->renderHtml();
    }

    public  function registerScript()
    {
        parent::registerScript();

        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assets = Yii::app()->getAssetManager(['linkAssets'=>true])->publish($dir,false, -1, YII_DEBUG);
        $cs=Yii::app()->getClientScript();

        $cs->registerScriptFile($assets.'/js/schedule-form.js', CClientScript::POS_END);

        $cs->registerCssFile($assets .'/css/schedule-form.css');
    }


    protected function renderHtml()
    {
        $content = '';
        $content .= CHtml::openTag('div',[
            'id'=>'schedule-form',
            'data-ng-controller'=>'schedule-form',
            'class'=>'ng-cloak',
            'data-ng-init'=>"init({$this->init})"]);
        $content .= '<div schedule-form-view></div>';

        $content .= $this->renderTable();

        $content .= $this->renderForm();

        $content .= CHtml::closeTag('div');

        return $content;
    }


    protected function renderTable()
    {
        $content = '';

        /*** table ***/
        $content .= CHtml::openTag('table',['cellpadding'=>0, 'cellspacing'=>0, 'class'=>'table table-hover table-bordered']);
        /*** thead ***/
        $content .= CHtml::openTag('thead');
        $content .= CHtml::openTag('tr');
        /** empty td **/
        $content .= CHtml::openTag('td');
        $content .= CHtml::closeTag('td');
        /** end empty td **/
        $content .= CHtml::openTag('td',['data-ng-repeat'=>'(k, v) in schedule.days']);
        $content .= CHtml::openTag('div',['ng-click'=>'toggleColumnSelected(k)','ng-class'=>'(toggleColumnClass( k ))']);
        $content .= '<[v.name]>';
        $content .= CHtml::closeTag('div');
        $content .= CHtml::closeTag('td');
        $content .= CHtml::closeTag('tr');
        $content .= CHtml::closeTag('thead');
        /*** end thead ***/
        /*** tbody ***/
        $content .= CHtml::openTag('tbody');
        $content .= CHtml::openTag('tr', ['data-ng-repeat'=>'(key, value) in schedule.times']);
        $content .= CHtml::openTag('td');
        $content .= CHtml::openTag('div',['ng-click'=>'toggleRowSelected( key )','ng-class'=>'(toggleRowClass( key ))']);
        $content .= '<[value.time]>';
        $content .= CHtml::closeTag('div');
        $content .= CHtml::closeTag('td');
        $content .= CHtml::openTag('td', ['data-ng-repeat'=>'(k, v) in schedule.days']);
        $content .= CHtml::openTag('div',['ng-click'=>'toggleSelected( key, k )', 'ng-class'=>'(toggleClass( key, k ))', 'class'=>'item']);//'

        $content .= '<[setItem(key, k)]>';

        $content .= CHtml::closeTag('div');
        $content .= CHtml::closeTag('td');
        $content .= CHtml::closeTag('tr');
        $content .= CHtml::closeTag('tbody');
        /*** end tbody ***/
        $content .= CHtml::closeTag('table');
        /*** end table ***/

        return $content;
    }


    protected function renderForm()
    {

        $content = '';
        /*** form ***/
        $content .= CHtml::openTag('form',['novalidate'=>'novalidate', 'name'=>'scheduleForm', 'class'=>'form-horizontal', 'style'=>'margin-top:30px;']);

        $content .= CHtml::openTag('div',['class'=>'form-group']);

        $content .= CHtml::openTag('label', ['class'=>'col-sm-5 control-label']);
        $content .= 'цена';
        $content .= CHtml::closeTag('label');

        $content .= CHtml::openTag('div',['class'=>'col-sm-7']);
        $content .= '<input type="number" ng-model="price" required="required" class="form-control"/>';
        $content .= CHtml::openTag('div',['class'=>'errorMessage','ng-show'=>'scheduleForm.$error.required']);
        $content .= CHtml::closeTag('div');
        $content .= CHtml::openTag('div',['class'=>'errorMessage','ng-show'=>'scheduleForm.$error.number']);
        $content .= 'Not valid number!';
        $content .= CHtml::closeTag('div');
        $content .= CHtml::closeTag('div');
        $content .= CHtml::closeTag('div');

        $content .= CHtml::openTag('div', ['class'=>'pull-right']);
        $content .= CHtml::openTag('div',['class'=>'loader', 'data-ng-show'=>'loaderShow']).CHtml::closeTag('div');
        $content .= CHtml::submitButton('<[ config.buttonSave ]>',[
                'ng-click'=>'updateSchedule(price)',
                'ng-disabled'=>'(!scheduleForm.$valid)',
                'class'=>'btn btn-success btn-sm'
            ]
        );
        $content .= CHtml::closeTag('div');

        $content .= CHtml::closeTag('form');
        /*** end form ***/

        return $content;
    }

}