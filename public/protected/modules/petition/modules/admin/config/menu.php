<?php

return array(
    'section'=>array(
        'label'    => Yii::t('main', 'Петиции'),
        'url'      => Yii::app()->createUrl('/admin/petition/default'),
        'icon' =>'fa fa-map-o',
        'position' => 1,
//        'linkOptions' => array(
//            'class'       => !count($entityModel) ? 'hidden' : '',
//        ),
    )
);