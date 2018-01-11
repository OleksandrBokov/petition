<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' =>'login-form',
    'action' => Yii::app()->createUrl('/login/default'),
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'method' => 'POST',
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' =>  'js:function(form, data, hasError) { if (!hasError) {location.reload();} }'
    ),
    'htmlOptions'=>array('class'=>'form-horizontal registration')
));
?>
<div class="form-group">
    <?php echo $form->textField($authForm, 'username', array('class' => 'form-control', 'placeholder' => Yii::t('main','Э-почта'))); ?>
    <?php echo $form->error($authForm, 'username'); ?>
</div>
<div class="form-group">
    <?php echo $form->passwordField($authForm, 'password', array('class' => 'form-control', 'placeholder' => 'Пароль')); ?>
    <?php echo $form->error($authForm, 'password'); ?>
    <p class="text-pass pull-right">
        <a href="<?php echo Yii::app()->createUrl('/login/reset/password')?>" class="pull-right" target="_blank"><?php echo Yii::t('main','Забыли пароль ?') ?></a>
    </p>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-regastration"><?php echo Yii::t('main','Вход')?></button>
</div>
<div class="remember-me fuelux">
    <label class="checkbox-custom" data-initialize="checkbox" id="myCheckbox7">
        <?php  echo $form->checkBox($authForm, 'rememberMe', array('class' => 'sr-only'));?>
       <p class="checkbox-label"><?php echo Yii::t('main','Запомнить меня');?></p>
    </label>
</div>
<?php $this->endWidget(); ?>
