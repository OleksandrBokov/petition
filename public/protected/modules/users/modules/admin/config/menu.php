<?php

return array(
    'manager'=>array(
        'label' => Yii::t('app', 'n==1#user|n==2#user|n>=3#users',3),
        'url'  => Yii::app()->createUrl('/admin/users'),
        'icon'  => 'fa fa-users',
        'position' => 3,
    ),
);