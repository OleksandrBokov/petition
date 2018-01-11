<?php
Yii::import('application.extensions.widgets.angular.drag-and-drop.DADWidget');

class TagsWidget extends DADWidget
{
    public function createTemplate()
    {
        $content = '';
        $content .= CHtml::openTag('div',['class'=>'col-sm-12']);
        $content .= CHtml::openTag('div',['class'=>'row']);

        /** used **/
        $content .= CHtml::openTag('div',['class'=>'col-sm-6 ']);
        $content .= CHtml::openTag('h5',['class'=>'box-title text-capitalize']);
        $content .= $this->usedTitle;
        $content .= CHtml::openTag('span',['class'=>'badge bg-yellow','style'=>'margin-left:10px']).'<[config.items.used.length]>'.CHtml::closeTag('span');
        $content .=CHtml::closeTag('h5');
        /** search **/
        if($this->search){
            $content .= CHtml::textField('used','',[
                'class'=>'form-control draggable-search',
                'placeholder' =>Yii::t('main','поиск').' ...',
                'data-ng-model'=>'searchUsed'
            ]);
        }
        /** end search **/
        $content .= CHtml::openTag('div',['class'=>'draggable-content overflow']);
        $content .= CHtml::openTag('ul',['class'=>'draggable-list']);
        /**** items ***/
        $content .= CHtml::openTag('li',[
            'data-ng-repeat'=>'used in config.items.used | orderBy:['.$this->order_field.'] | filter: searchUsed',
            'class'=>'draggable-item'
        ]);
        /**** inner content ****/

        $content .= CHtml::openTag('span',['style'=>'margin-left:20px']);
        $content .=' <[used.name]> <small><[used.description]></small>';
        $content .= CHtml::closeTag('span');

        $content .= CHtml::openTag('a', [
            'class'=>'item-btn pointer',
            'data-ng-click'=>'toAvailable(used.tag_id)',
            'data-toggle'=>'tooltip',
            'title'=>Yii::t('main','')
        ]);
        $content .= CHtml::openTag('i',['class'=>'fa fa-minus-circle text-yellow']).CHtml::closeTag('i');
        $content .= CHtml::closeTag('a');
        $content .= CHtml::closeTag('li');


       /* $content .= CHtml::openTag('span',[
                'style'=>'background-color: <[used.colour]>',
                'class'=>'item-icon',
                'data-toggle'=>'tooltip',
                'data-placement'=>'right',
                'title'=>'<[used.branch_name]> '.Yii::t('main','ветка')
            ]).CHtml::closeTag('span');

        $content .= CHtml::openTag('span',['class'=>'hidden']);
        $content .= '<[used.branch_name]>';
        $content .= CHtml::closeTag('span');

        $content .= CHtml::openTag('span',['style'=>'margin-left:20px']);
        $content .=' <[used.station_name]>';
        $content .= CHtml::closeTag('span');
        $content .= CHtml::openTag('a', [
            'class'=>'item-btn pointer',
            'data-ng-click'=>'toAvailable(used.branch_station_id)',
            'data-toggle'=>'tooltip',
            'title'=>Yii::t('main','')
        ]);
        $content .= CHtml::openTag('i',['class'=>'fa fa-minus-circle text-yellow']).CHtml::closeTag('i');
        $content .= CHtml::closeTag('a');
        $content .= CHtml::closeTag('li');*/
        /**** end inner content ****/
        /**** end items ***/
        $content .= CHtml::closeTag('ul');
        $content .= CHtml::closeTag('div');
        $content .= CHtml::closeTag('div');
        /** end used **/


        /** available **/
        $content .= CHtml::openTag('div',['class'=>'col-sm-6']);
        $content .= CHtml::openTag('h5',['class'=>'box-title text-capitalize']);
        $content .= $this->availableTitle;
        $content .= CHtml::openTag('span',['class'=>'badge bg-light-blue','style'=>'margin-left:10px']).'<[config.items.available.length]>'.CHtml::closeTag('span');
        $content .=CHtml::closeTag('h5');
        /** search **/
        if($this->search){
            $content .= CHtml::textField('available','',[
                'class'=>'form-control draggable-search',
                'placeholder' => Yii::t('main','поиск').' ...',
                'data-ng-model'=>'searchAvailable'
            ]);
        }
        /** end search **/
        $content .= CHtml::openTag('div',['class'=>'draggable-content overflow']);
        $content .= CHtml::openTag('ul', ['class'=>'draggable-list']);
        /**** items ***/
        $content .= CHtml::openTag('li', [
            'data-ng-repeat'=>'available in config.items.available | orderBy:['.$this->order_field.'] | filter: searchAvailable',
            'class'=>'draggable-item'
        ]);
        $content .= CHtml::openTag('span',['style'=>'margin-left:20px']);
        $content .=' <[available.name]> <small><[available.description]></small>';
        $content .= CHtml::closeTag('span');
       /* $content .= CHtml::openTag('span',[
                'style'=>'background-color: <[available.colour]>',
                'class'=>'item-icon',
                'data-toggle'=>'tooltip',
                'data-placement'=>'right',
                'title'=>'<[available.branch_name]> '.Yii::t('main','ветка')
            ]).CHtml::closeTag('span');
        $content .= CHtml::openTag('span',['class'=>'hidden']);
        $content .= '<[available.branch_name]>';
        $content .= CHtml::closeTag('span');
        $content .= CHtml::openTag('span',['style'=>'margin-left:20px']);
        $content .=' <[available.station_name]>';
        $content .= CHtml::closeTag('span');*/
        $content .= CHtml::openTag('a', [
            'class'=>'item-btn pointer',
            'data-ng-click'=>'toUsed(available.tag_id)',
            'data-toggle'=>'tooltip',
            'title'=>Yii::t('main','')
        ]);
        $content .= CHtml::openTag('i',['class'=>'fa fa-plus-circle text-blue']).CHtml::closeTag('i');
        $content .= CHtml::closeTag('a');
        $content .= CHtml::closeTag('li');
        /**** end items ***/
        $content .= CHtml::closeTag('ul');
        $content .= CHtml::closeTag('div');
        $content .= CHtml::closeTag('div');
        /** end available **/

        $content .= CHtml::closeTag('div');

        $content .= $this->renderSaveButton(); //parent save button

        $content .= CHtml::closeTag('div');
        return $content;
    }
}