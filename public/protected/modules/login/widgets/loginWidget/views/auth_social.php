
<?php
Yii::app()->user->setReturnUrl($_SERVER['REQUEST_URI']);

$icon =  array(
    'facebook'=>'fa fa-facebook',
    'google' => 'fa fa-google-plus',
    'google_oauth' => 'fa fa-google-plus',
    'vkontakte' => 'fa fa-vk',
);
$label = Yii::t('main','Регистрация с помощью');

switch(Yii::app()->controller->id) {
    case 'login':
        $label = Yii::t('main', 'Log in with');
        break;
    case 'registration':
        $label = Yii::t('main', 'Register with');
        break;
}

foreach ($services as $name => $service) {
    $html = CHtml::openTag('div', ['class'=>'form-group has-feedback auth-service '.$service->id]);
    $html .= CHtml::openTag('span', ['class'=>$icon[$service->id].' form-control-feedback-left']);
    $html .= CHtml::closeTag('span');
    $html .= CHtml::link($label.' <span style="text-transform:capitalize">'.$service->title.'</span>',array($action,'service' => $name),
        array('class' => 'btn btn-default btn-social auth-link ' . $service->id));
    $html .= CHtml::closeTag('div');
    echo $html;
}
?>

