<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'registration-form',
    'action' => Yii::app()->createUrl('/login/registration'),
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'method' => 'POST',
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' =>  'js:function(form, data, hasError) {
            if (!hasError) {
              $("#sign-up").empty().append(data.message);
            }
        }'
    ),
    'htmlOptions'=>array('class'=>'form-horizontal registration')
));
?>
<div class="form-group">
    <?php echo $form->textField($model, 'firstName', array('class' => 'form-control', 'placeholder' => Yii::t('main','Имя'))); ?>
    <?php echo $form->error($model, 'firstName'); ?>
</div>
<div class="form-group">
    <?php echo $form->textField($model, 'lastName', array('class' => 'form-control', 'placeholder' => Yii::t('main','Фамилия'))); ?>
    <?php echo $form->error($model, 'lastName'); ?>
</div>
<div class="form-group">
    <?php echo $form->emailField($model, 'email', array('class' => 'form-control', 'placeholder' => Yii::t('main','Э-почта'))); ?>
    <?php echo $form->error($model, 'email'); ?>
</div>
<div class="form-group">
    <?php echo $form->textField($model, 'phone', array('class' => 'form-control phone-input-mask', 'placeholder' => Yii::t('main','Телефон'))); ?>
    <?php echo $form->error($model, 'phone'); ?>
</div>
<div class="form-group">
    <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => Yii::t('main','Пароль'))); ?>
    <?php echo $form->error($model, 'password'); ?>
    <p class="text-pass pull-right"><?php echo Yii::t('main','Минимум {alias} символов',['{alias}'=>Yii::app()->config->get('password_length')])?></p>
</div>
<p class="text-form">
        <?php echo Yii::t('main','Нажимая на кнопку «Зарегистрироваться», вы подтверждаете свое согласие с условиями предоставления услуг {link} (пользовательское соглашение) {/link}',
            ['{link}'=>'<a href="#" target="_blank"><span class="text-green">', '{/link}'=>'</span></a>'])?>
</p>

<div class="form-group">
    <button type="submit" class="btn btn-regastration"><?php echo Yii::t('main','Зарегистрироватся')?></button>
</div>

<?php $this->endWidget(); ?>

