<?php

Yii::import('application.extensions.widgets.angular.schedule.PlaygroundScheduleWidget');

class CartWidget extends PlaygroundScheduleWidget
{
    public $init = array();


    public $link = '';

    public function init()
    {
        $error['errorList'] = $this->getErrors();

        if(isset( $this->init['link'] ))
            $this->link = $this->init['link'];

        $this->init = CMap::mergeArray($this->init,$error);
        $this->init = json_encode($this->init);

        $this->registerScript();

        echo $this->renderCart();
    }

    protected function renderCart()
    {
        $content = '';
        $content .= CHtml::openTag('div',[
            'data-ng-init'=>"init({$this->init})"]);
        $content .= '<div playground-schedule-view></div>';

        $content .= $this->renderModal();

        $content .= '<div schedule-cart></div>';

        /** Cart content **/
        $content .= CHtml::openTag('div',['class'=>'schedule-cart-container',
            'data-ng-show'=>'checkStack(stack)',
            'data-ng-hide'=>'!checkStack(stack)',
            'style'=>'border:0; min-height:200px; height:200px; margin-top:20px;'
        ]);

        $content .= CHtml::openTag('table', ['class'=>'table']);
        $content .= CHtml::openTag('tbody');
        $content .= CHtml::openTag('tr', [
            'dir-paginate'=>' (sortKey, item) in stack | orderByStack | itemsPerPage: 3 ']);
        $content .= CHtml::openTag('td').'<[item[0].day]> <[translite(item[0].month)]>, <[item[0].day_name]>'.CHtml::closeTag('td');
        $content .= CHtml::openTag('td').'<[ setTimeInterval(item) ]> '.CHtml::closeTag('td'); //9:00 - 10:00
        $content .= CHtml::openTag('td').'<[ countStackPrice(item) ]> &#8372;'.CHtml::closeTag('td');

        $content .= CHtml::closeTag('tr');

        $content .= CHtml::closeTag('tbody');
        $content .= CHtml::closeTag('table');

        $content .= CHtml::openTag('div',['class'=>'total-payment pull-right']);
        $content .= CHtml::openTag('p').Yii::t('main','Всего').':&nbsp;&nbsp; <[total]>  &#8372;'.CHtml::closeTag('p');
        $content .= CHtml::closeTag('div');
        $content .= CHtml::openTag('div',['class'=>'clearfix']).CHtml::closeTag('div');
        $content .='<dir-pagination-controls max-size="5" direction-links="true" boundary-links="true" class="pull-right"></dir-pagination-controls>';

        $content .= CHtml::closeTag('div');

        $content .= CHtml::closeTag('div');

        return $content;
    }
    
    protected function renderModal()
    {
        $content = '';

        $content .= CHtml::openTag('div',['class'=>'modal-error', 'ng-class'=>'(modalFadeIn) ? "fade-in": "" ']);
        $content .= CHtml::openTag('div',['class'=>'modal-content']);
        $content .= CHtml::openTag('div',['class'=>'modal-body']);

        $content .= CHtml::openTag('h3').'<[error.title]>'.CHtml::closeTag('h3');
        $content .= CHtml::openTag('h4').'<[error.number]>'.CHtml::closeTag('h4');
        $content .= CHtml::openTag('p').'<[error.text]>'.CHtml::closeTag('p');

        $content .= CHtml::closeTag('div');

        $content .= CHtml::openTag('div',['class'=>'modal-footer']);

        $content .= CHtml::openTag('a',['class'=>'btn btn-primary', 'href'=>$this->link]);
        $content .= '<[error.button]>';
        $content .= CHtml::closeTag('a');

        $content .= CHtml::closeTag('div');

        $content .= CHtml::closeTag('div');
        $content .= CHtml::closeTag('div');

        return $content;
    }

}