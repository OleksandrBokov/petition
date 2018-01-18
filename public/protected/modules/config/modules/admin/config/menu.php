<?php

return array(
    'config'=>array(
        'label'    => Yii::t('main', 'Конігурація'),
        'url'      => Yii::app()->createUrl('/admin/config'),
        'icon' =>'fa fa-cogs',
        'position' => 1,
//        'linkOptions' => array(
//            'class'       => !count($entityModel) ? 'hidden' : '',
//        ),
    ),
);