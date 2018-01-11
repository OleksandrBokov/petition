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

);