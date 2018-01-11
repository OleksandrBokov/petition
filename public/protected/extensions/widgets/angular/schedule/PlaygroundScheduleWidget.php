<?php

Yii::import('application.extensions.widgets.angular.AngularWidget');

class PlaygroundScheduleWidget extends AngularWidget
{
    protected $_local_time;

    public $init = array();
    /*getSchedule action  -  application.extensions.widgets.angular.schedule.actions.AjaxScheduleAction */
    /*setCart action  -  application.extensions.widgets.angular.schedule.actions.AjaxScheduleAction */

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

        $cs->registerScriptFile($assets.'/js/dirPagination.js', CClientScript::POS_END);
        $cs->registerScriptFile($assets.'/js/playground-schedule.js', CClientScript::POS_END);
        /** фиксирование корзины **/
//        $cs->registerScript('fixed-shedule-header',"
//        var schedule = $('.schedule-row');
//        if(typeof schedule !== typeof undefined){
//        var offsetSchedule = schedule.offset().top;
//        var headerFixed = $('#header-fixed');
//        var offsetHeaderFixed = headerFixed.offset().top;
//        $(window).scroll(function(){
//        if ($(window).scrollTop() >= offsetHeaderFixed && ! ($(window).scrollTop() >= (offsetSchedule + schedule.height() -300))) {
//        headerFixed.addClass('sticky');
//        } else {
//        headerFixed.removeClass('sticky');
//        }
//        });
//        }
//        ", CClientScript::POS_END);
    }


    protected function renderHtml()
    {
        $content = '';
        $content .= CHtml::openTag('div',[
            'id'=>'playground-schedule',
            'data-ng-controller'=>'playground-schedule',
            'class'=>'ng-cloak',
            'data-ng-init'=>"init({$this->init})"]);
        $content .= '<div playground-schedule-view></div>';
        $content .= $this->renderModal();
        /** table **/
        $content .= CHtml::openTag('div',['class'=>'table']);
        /** table header **/
        $content .= CHtml::openTag('div',['class'=>'schedule-header', 'id'=>'header-fixed']);
        $content .= $this->renderCart();
        $content .= CHtml::openTag('div',['class'=>'clearfix']).CHtml::closeTag('div');
        $content .= $this->renderDateHeader();
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


    protected function renderCart()
    {
        $content = '';

        $content .= CHtml::openTag('div',['class'=>'col-xs-12' ,'style'=>'padding-bottom:20px;']);

        $content .= '<div schedule-cart></div>';

        /** Cart content **/
        $content .= CHtml::openTag('div',['class'=>'col-xs-8 schedule-cart-container', 'data-ng-show'=>'checkStack(stack)',  'data-ng-hide'=>'!checkStack(stack)']);

        $content .= CHtml::openTag('table', ['class'=>'table']);
        $content .= CHtml::openTag('tbody' );

        $content .= CHtml::openTag('tr', [
            'dir-paginate'=>' (sortKey, item) in stack | orderByStack | itemsPerPage: 5 ']);

        $content .= CHtml::openTag('td').'<[item[0].day]> <[translite(item[0].month)]>, <[item[0].day_name]>'.CHtml::closeTag('td');//<[item[0].month]>
        $content .= CHtml::openTag('td').'<[ setTimeInterval(item) ]> '.CHtml::closeTag('td');
        $content .= CHtml::openTag('td').'<[ countStackPrice(item) ]> &#8372;'.CHtml::closeTag('td');
        $content .= CHtml::openTag('td',['data-ng-click'=>'removeByCart(item)']).'
                   <i class="fa fa-times" data-toggle="tooltip" title='.Yii::t('main','удалить').'></i>'.CHtml::closeTag('td');

        $content .= CHtml::closeTag('tr');
        $content .= CHtml::closeTag('tbody');
        $content .= CHtml::closeTag('table');


        $content .= CHtml::openTag('div',['class'=>'total-payment pull-right']);
        $content .= CHtml::openTag('p').Yii::t('main','Всего').':&nbsp;&nbsp; <[total]>  &#8372;'.CHtml::closeTag('p');
        $content .= CHtml::closeTag('div');
        $content .= CHtml::openTag('div',['class'=>'clearfix']).CHtml::closeTag('div');
        $content .='<dir-pagination-controls max-size="5" direction-links="true" boundary-links="true" class="pull-right"></dir-pagination-controls>';

        $content .= CHtml::closeTag('div');
        /** end Cart content **/

        $content .= CHtml::openTag('div',['class'=>'col-xs-8 choise-text', 'data-ng-hide'=>'checkStack(stack)', 'data-ng-show'=>'!checkStack(stack)']);
        $content .= CHtml::openTag('p');
        $content .= Yii::t('main','Выберите удобное время для занятий и нажмите "Забронировать"');
        $content .= CHtml::closeTag('p');
        $content .= CHtml::closeTag('div');

        $content .= CHtml::openTag('div',['class'=>'col-xs-4 ']);
        $content .= CHtml::openTag('div',['class'=>'description-location']);
        $content .= CHtml::button(Yii::t('main','забронировать'),[
            'class' =>'btn btn-schedule',
            'ng-disabled'=>'!checkStack(stack)',
            'ng-click'=>'reservationCart()']);
        $content .= CHtml::closeTag('div');
        $content .= CHtml::closeTag('div');

        $content .= CHtml::closeTag('div');

        return $content;
    }

    protected function renderDateHeader()
    {
        $content = '';
        $content .= CHtml::openTag('div',['class'=>'table-row header-date', ]);
        $content .= '<[showPrev]>';
        /** prev button**/
        $content .= CHtml::openTag('div',['class'=>'table-cell prev','style'=>'padding-right: 15px;' ]);
        $content .= CHtml::openTag('span',['class'=>'pointer', 'data-ng-click'=>'updateSchedule( 1, schedule.startWeek)',
            'data-ng-hide'=>'hidePrevButton', 'data-ng-show'=>'!hidePrevButton']);
        $content .= CHtml::openTag('i', ['class'=>'fa fa-chevron-left']).CHtml::closeTag('i');
        $content .= CHtml::closeTag('span');
        $content .= CHtml::closeTag('div');
        /** /prev button**/

        $content .= CHtml::openTag('div',['class'=>'table-cell weekday-<[item.day_number]>', 'data-ng-repeat'=>'item in schedule.week']);
        $content .= ' <[item.day]> <[item.month]> <span style="text-align:center;display:block;width: 100%"><[item.day_name]>.</span>';
        $content .= CHtml::closeTag('div');

        /** prev button**/
        $content .= CHtml::openTag('div',['class'=>'table-cell next','style'=>'padding-left: 15px;']);
        $content .= CHtml::openTag('span',['class'=>'pointer','data-ng-click'=>'updateSchedule( 0, schedule.finishWeek)']);
        $content .= CHtml::openTag('i', ['class'=>'fa fa-chevron-right']).CHtml::closeTag('i');
        $content .= CHtml::closeTag('span');
        $content .= CHtml::closeTag('div');
        /** /prev button**/

        $content .= CHtml::closeTag('div');

        return $content;
    }



    protected function renderBody()
    {
        $content = '';
        $content .= CHtml::openTag('div',['class'=>'schedule-row']);

        $content .= CHtml::openTag('div',['class'=>'table-row', 'data-ng-repeat'=>'(key, value) in schedule.times']);

        $content .= CHtml::openTag('div',['class'=>'table-cell']).'<[value.time]>'.CHtml::closeTag('div');

        $content .= CHtml::openTag('div',['class'=>'table-cell', 'data-ng-repeat'=>'item in schedule.week']);

        $content .= CHtml::openTag('button',['class'=>'item-table btn-sm ',
            'ng-disabled'=>'!checkAvailableItemByCurrentTime(key, item)',
            'data-ng-click'=>'addToCart(key, item)',
            'ng-class'=>'{active: checkActive(key,item)}'//schedule.items[setKey(key,item.day_number)]["selected"]
            ]);
        $content .= '<i class="fa fa-check"></i> <[setPrice( key, item.day_number )]>';
        $content .= CHtml::closeTag('button');

        $content .= CHtml::closeTag('div');

        $content .= CHtml::openTag('div',['class'=>'table-cell']).'<[value.time]>'.CHtml::closeTag('div');

        $content .= CHtml::closeTag('div');

        $content .= CHtml::closeTag('div');

        return $content;
    }


    protected function getErrors()
    {
        return array(
            '1'=>array(
                'title'=>Yii::t('main','Это время уже прошло или недоступно'),
                'number'=>Yii::t('main','Ошибка').' #1',
                'text'=>Yii::t('main','Выберите другое время.'),
                'button'=>Yii::t('main','Хорошо')
            ),
            '2'=>array(
                'title'=>Yii::t('main','Это время уже успели забронировать'),
                'number'=>Yii::t('main','Ошибка').' #2',
                'text'=>Yii::t('main','Кто-то успел это сделать раньше. Выберите другое время.'),
                'button'=>Yii::t('main','Хорошо')
            ),
            '3'=>array(
                'title'=>Yii::t('main','Выбранное вами время успели забронировать'),
                'number'=>Yii::t('main','Ошибка').' #3',
                'text'=>Yii::t('main','Мы удалили только занятое время из корзины. Выберите другое время для занятий.'),
                'button'=>Yii::t('main','Хорошо, найду свободное время')
            ),
            '4'=>array(
                'title'=>Yii::t('main','Выбранное вами время уже прошло или недоступо'),
                'number'=>Yii::t('main','Ошибка').' #4',
                'text'=>Yii::t('main','Мы удалили только недоступное время из корзины. Выберите другое время для занятий.'),
                'button'=>Yii::t('main','Хорошо, найду свободное время')
            )
        );
    }
}