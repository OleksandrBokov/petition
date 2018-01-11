<?php

Yii::import('application.models.User');

class PersonalArea extends CWidget
{

    protected $_userStatus;

    public $items = array();

    public $linkOptions = array();

    public function init()
    {
//        $this->items = array(
//            array('label'=>'Мои заказы', 'url'=>'#'),
//            array('label'=>'Документы', 'url'=>'#'),
//            array('label'=>'Профиль', 'url'=>'#'),
//            array('label'=>'Мои оценки', 'url'=>'#'),
//            array('label'=>'Выход', 'url'=>Yii::app()->createUrl('/logout')),
//        );

        $content = '';
        if(Yii::app()->user->isGuest){
            $this->widget('application.modules.login.widgets.loginWidget.ModalLoginWidget');
        }else{
            $content = $this->renderUserArea();
        }
//        switch (Yii::app()->user->role){
//
//            case User::ROLE_ADMIN:
//                $content = $this->renderAdministrationArea();
//                break;
//            case User::ROLE_MANAGER:
//                $content = $this->renderManagerArea();
//                break;
//            case User::ROLE_USER:
//                $content = $this->renderUserArea();
//                break;
//            case User::ROLE_OWNER:
//                $content = $this->renderOwnerArea();
//                break;
//            default :
//
//        }
        echo $content;
    }


//
//    protected function renderAdministrationArea()
//    {
//        $content = '';
//      //  $content .= CHtml::openTag('ul', ['class'=>'nav navbar-nav pull-right']);
//        $content .= CHtml::openTag('li',['class'=>'dropdown city-choose']);
//        $content .= CHtml::link('admin','#',['class'=>'dropdown-toggle', 'data-toggle'=>'dropdown']);
//        $content .= CHtml::openTag('ul',['class'=>'dropdown-menu']);
//        $content .= CHtml::openTag('li');
//        $content .= CHtml::link(Yii::t('main','кабинет'), Yii::app()->createUrl('/admin'));
//        $content .= CHtml::closeTag('li');
//        $content .= CHtml::openTag('li');
//        $content .= CHtml::link(Yii::t('main','Выход'), Yii::app()->createUrl('/logout'));
//        $content .= CHtml::closeTag('li');
//        $content .= CHtml::closeTag('ul');
//        $content .= CHtml::closeTag('li');
//      //  $content .= CHtml::closeTag('ul');
//
//        return $content;
//    }
//
//    protected function renderManagerArea()
//    {
//        $content = '';
//
//        $content .= CHtml::openTag('li',['class'=>'dropdown city-choose']);
//        $content .= CHtml::link(Yii::app()->user->role,'#',['class'=>'dropdown-toggle', 'data-toggle'=>'dropdown']);
//        $content .= CHtml::openTag('ul',['class'=>'dropdown-menu']);
//        $content .= CHtml::openTag('li');
//        $content .= CHtml::link(Yii::t('main','кабинет'), Yii::app()->createUrl('/manager'));
//        $content .= CHtml::closeTag('li');
//        $content .= CHtml::openTag('li');
//        $content .= CHtml::link(Yii::t('main','Выход'), Yii::app()->createUrl('/logout'));
//        $content .= CHtml::closeTag('li');
//        $content .= CHtml::closeTag('ul');
//        $content .= CHtml::closeTag('li');
//
//        return $content;
//    }


    protected function renderUserArea()
    {
        $content = '';

        //$content .= CHtml::openTag('ul', ['class'=>'nav navbar-nav pull-right']);
        $content .= CHtml::openTag('li',['class'=>'dropdown city-choose']);
        $content .= CHtml::openTag('a', ['class'=>'dropdown-toggle', 'data-toggle'=>'dropdown']);
        $content .= (trim(Yii::app()->user->name)) ? Yii::app()->user->name : Yii::app()->user->role;
        $content .= CHtml::openTag('span',['class'=>'caret']).CHtml::closeTag('span');
        $content .= CHtml::closeTag('a');

        $content .= CHtml::openTag('ul',['class'=>'dropdown-menu']);
        foreach($this->items as $item){

            if(in_array(Yii::app()->user->role, $item['role'])){
                $content .= CHtml::openTag('li');
                $content .= CHtml::link(Yii::t('main', $item['label']), $item['url']);
                $content .= CHtml::closeTag('li');
            }
        }
        $content .= CHtml::closeTag('ul');

     //   $content .= CHtml::closeTag('ul');

        return $content;
    }

    protected function renderOwnerArea()
    {
        $content = '';

        //$content .= CHtml::openTag('ul', ['class'=>'nav navbar-nav pull-right']);
        $content .= CHtml::openTag('li',['class'=>'dropdown city-choose']);
        $content .= CHtml::openTag('a', ['class'=>'dropdown-toggle', 'data-toggle'=>'dropdown']);
        $content .= Yii::app()->user->name;
        $content .= CHtml::openTag('span',['class'=>'caret']).CHtml::closeTag('span');
        $content .= CHtml::closeTag('a');

        $content .= CHtml::openTag('ul',['class'=>'dropdown-menu']);
        $content .= CHtml::openTag('li');
        $content .= CHtml::link(Yii::t('main','кабинет'), Yii::app()->createUrl('#'));
        $content .= CHtml::closeTag('li');
        $content .= CHtml::openTag('li');
        $content .= CHtml::link(Yii::t('main','Выход'), Yii::app()->createUrl('/logout'));
        $content .= CHtml::closeTag('li');
        $content .= CHtml::closeTag('ul');


        return $content;
    }


}