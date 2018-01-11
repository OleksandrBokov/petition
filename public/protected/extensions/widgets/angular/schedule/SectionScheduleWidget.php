<?php

Yii::import('application.extensions.widgets.angular.schedule.PlaygroundScheduleWidget');


class SectionScheduleWidget extends PlaygroundScheduleWidget
{

    public $init = array();

    public function init()
    {
        $error['errorList'] = $this->getErrors();
        $this->init = CMap::mergeArray($this->init,$error);

        $this->init = json_encode($this->init);

        $this->registerScript();

        echo $this->renderHtml();
    }


    public  function registerScript()
    {
        parent::registerScript();

        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assets = Yii::app()->getAssetManager(['linkAssets'=>true])->publish($dir,false, -1, YII_DEBUG);
        $cs = Yii::app()->getClientScript();

        $cs->registerScriptFile($assets.'/js/section-schedule.js', CClientScript::POS_END);

    }


    protected function renderHtml()
    {
        $content = '';
        $content .= CHtml::openTag('div',[
            'id'=>'section-schedule',
            'data-ng-controller'=>'section-schedule',
            'class'=>'ng-cloak',
            'data-ng-init'=>"init({$this->init})"]);
        $content .= '<div section-schedule-view></div>';

        /** table **/
        $content .= $this->renderModal();
        /** table **/
        $content .= CHtml::openTag('div',['class'=>'table']);
        /** table header **/
        $content .= CHtml::openTag('div',['class'=>'section-schedule-header']);

        $content .= CHtml::closeTag('div');
        /** end table header **/

        $content .= $this->renderBody();

        $content .= CHtml::closeTag('div');
        /** end table **/
        $content .= CHtml::closeTag('div');

        return $content;
    }

    protected function renderModal()
    {
        $content = '';

        $content .= CHtml::openTag('div',['class'=>'modal-error','ng-class'=>'(modalFadeIn) ? "fade-in": "" ']);
        $content .= CHtml::openTag('div',['class'=>'modal-content']);
        $content .= CHtml::openTag('div',['class'=>'modal-body']);

        $content .= CHtml::openTag('h3').'<[error.title]>'.CHtml::closeTag('h3');
        $content .= CHtml::openTag('h4').'<[error.number]>'.CHtml::closeTag('h4');
        $content .= CHtml::openTag('p').'<[error.text]>'.CHtml::closeTag('p');

        $content .= CHtml::closeTag('div');

        $content .= CHtml::openTag('div',['class'=>'modal-footer']);

        $content .= CHtml::openTag('button',['class'=>'btn btn-primary', 'ng-click'=>'modalFadeIn = false']);
        $content .= '<[error.button]>';
        $content .= CHtml::closeTag('button');

        $content .= CHtml::closeTag('div');

        $content .= CHtml::closeTag('div');
        $content .= CHtml::closeTag('div');

        return $content;
    }

    protected function renderBody()
    {
        $content = '';

        $content .= CHtml::openTag('div',['class'=>'section-schedule-body']);

        /** prev button**/
        $content .= CHtml::openTag('div',['class'=>'prev']);
        $content .= CHtml::openTag('span',['class'=>'pointer', 'data-ng-click'=>'updateSchedule( 1, schedule.startWeek)',
            'data-ng-hide'=>'hidePrevButton', 'data-ng-show'=>'!hidePrevButton']);
        $content .= CHtml::openTag('i', ['class'=>'fa fa-chevron-left']).CHtml::closeTag('i');
        $content .= CHtml::closeTag('span');
        $content .= CHtml::closeTag('div');
        /** /prev button**/


        /*** table-cell ***/
        $content .= CHtml::openTag('div',['class'=>'table-cell', 'data-ng-repeat'=>'day in schedule.week']);


        $content .= CHtml::openTag('div',['class'=>'week weekday-<[day.day_number]>']);
        $content .= ' <[day.day]> <[day.month]> <span style="text-align:center;display:block;width: 100%"><[day.day_name]>.</span>';
        $content .= CHtml::closeTag('div');

        /*** panel ***/
        $content .= CHtml::openTag('div',['class'=>'panel', 'data-ng-repeat'=>'item in day.items | orderByStack']);

        /*** panel-heading ***/
        $content .= CHtml::openTag('div',['class'=>'panel-heading','style'=>'padding-bottom:3px; padding-top:3px;']);

        $content .= CHtml::openTag('div',['class'=>'panel-title text-center']);
        $content .= '<[item.time_start]>-<[item.time_finish]>';
        $content .= CHtml::closeTag('div');

        $content .= CHtml::closeTag('div');
        /***  end panel-heading ***/

        /*** panel-body ***/
        $content .= CHtml::openTag('div',['class'=>'panel-body']);
        $url = Yii::app()->createUrl('/section/order');


        $content .= CHtml::openTag('div', [
            'class'=>'btn btn-success section-success',
            'data-ng-hide'=>'!checkAvailableItemByCurrentTime(item)',
            'data-ng-show'=>'checkAvailableItemByCurrentTime(item)',
            'data-ng-click'=>"reservation('{$url}', item)",
        ] );
        $content .= Yii::t('main','Записаться');
        $content .= CHtml::closeTag('div');

//        $content .= CHtml::link(Yii::t('main','Записаться'), '#',
//            ['class'=>'btn btn-success section-success',
//             'data-ng-click'=>"reservation('{$url}', item)",
//             'data-ng-hide'=>'!checkAvailableItemByCurrentTime(item)',
//             'data-ng-show'=>'checkAvailableItemByCurrentTime(item)'
//        ]);

        $content .= CHtml::openTag('div', [
                    'data-ng-hide'=>'checkAvailableItemByCurrentTime(item)',
                    'data-ng-show'=>'!checkAvailableItemByCurrentTime(item)',
                    'style'=>'font-size:12px; color:#9b9b9b;line-height:26px; '
                ] );
        $content .= Yii::t('main','Занятие прошло');
        $content .= CHtml::closeTag('div');

        $content .= CHtml::closeTag('div');
        /*** end panel-body ***/

        /*** panel-footer ***/
        $content .= CHtml::openTag('div',['class'=>'panel-footer','data-ng-show'=>'item.description', 'data-ng-hide'=>'!item.description']);
        $content .= '<[item.description]>';
        $content .= CHtml::closeTag('div');
        /*** end panel-footer ***/

        $content .= CHtml::closeTag('div');
        /*** end panel ***/

        $content .= CHtml::closeTag('div');
        /*** end table-cell ***/

        /** next button**/
        $content .= CHtml::openTag('div',['class'=>'next']);
        $content .= CHtml::openTag('span',['class'=>'pointer','data-ng-click'=>'updateSchedule( 0, schedule.finishWeek)']);
        $content .= CHtml::openTag('i', ['class'=>'fa fa-chevron-right']).CHtml::closeTag('i');
        $content .= CHtml::closeTag('span');
        $content .= CHtml::closeTag('div');
        /** /next button**/

        //$content .= CHtml::openTag('div',['class'=>'table-cell','style'=>'width:56px;']).CHtml::closeTag('div');
        $content .= CHtml::closeTag('div');

        return $content;





    }
}