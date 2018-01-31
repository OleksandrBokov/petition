<?php

return array(
    'petition'=>array(
        'label'    => Yii::t('main', 'Петиции'),
        'url'      => Yii::app()->createUrl('/moderator/petition/default'),
        'icon' =>'fa fa-map-o',
        'position' => 1,
//        'linkOptions' => array(
//            'class'       => !count($entityModel) ? 'hidden' : '',
//        ),
    ),
    'answer'=>array(
        'label'    => Yii::t('main', 'Ответ'),
        'url'      => Yii::app()->createUrl('/moderator/petition/answer'),
        'icon' =>'fa fa-map-o',
        'position' => 2,
//        'linkOptions' => array(
//            'class'       => !count($entityModel) ? 'hidden' : '',
//        ),
    )
);