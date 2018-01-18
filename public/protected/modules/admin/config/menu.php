<?php

return array(
    'main'=>array(
        'label' => Yii::t('main', 'Кабинет'),
        'url'  => Yii::app()->createUrl('/admin'),
        'icon'  => 'fa fa-home',
        'position' => 1,
        'linkOptions' => array(
            'class'       => 'hidden',
        ),
    ),
    'settings'=>array(
        'label' => Yii::t('main', 'Капча'),
        'url'  => Yii::app()->createUrl('/admin/default/capcha'),
        'icon'  => 'fa fa-cog',
        'position' => 2,
//        'linkOptions' => array(
//            'class'       => 'hidden',
//        ),
    ),
    'linkForModeratoe'=>array(
        'label' => Yii::t('main', 'Ссылка'),
        'url'  => Yii::app()->createUrl('/admin/default/link'),
        'icon'  => 'fa fa-cog',
        'position' => 1,
//        'linkOptions' => array(
//            'class'       => 'hidden',
//        ),
    ),

);