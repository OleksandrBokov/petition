<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'registration-form',
    'action' => Yii::app()->createUrl('/login/registration'),
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'method' => 'POST',
    'htmlOptions'=>array('class'=>'form-horizontal registration')
));
?>
<div class="form-group">

    <?php echo $form->textField($model,'firstName', array('class' => 'form-control', 'placeholder' => Yii::t('main','Имя')."*")); ?>
    <?php echo $form->error($model,'firstName'); ?>
</div>

<div class="form-group">

    <?php echo $form->textField($model,'lastName', array('class' => 'form-control', 'placeholder' => Yii::t('main','Фамилия')."*")); ?>
    <?php echo $form->error($model,'lastName'); ?>
</div>

<div class="form-group">

    <?php echo $form->textField($model,'patronymic', array('class' => 'form-control', 'placeholder' => Yii::t('main','Отчество')."*")); ?>
    <?php echo $form->error($model,'patronymic'); ?>
</div>

<div class="form-group">
    <?php echo $form->textField($model,'birthday', array('class' => 'form-control birthday-input-mask', 'placeholder' => Yii::t('main','Дата рождения')."*")); ?>
    <?php echo $form->error($model,'birthday'); ?>
</div>

<div class="form-group">
    <?php echo $form->textField($model,'address', array('class' => 'form-control', 'placeholder' => Yii::t('main','Адрес')."*")); ?>
    <?php echo $form->error($model,'address'); ?>
</div>

<div class="form-group">
    <?php echo $form->textField($model,'inn', array('class' => 'form-control', 'placeholder' => Yii::t('main','ИНН')."*")); ?>
    <?php echo $form->error($model,'inn'); ?>
</div>

<div class="form-group">
    <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => Yii::t('main','Э-почта')."*")); ?>
    <?php echo $form->error($model, 'email'); ?>
</div>
<div class="form-group">
    <?php echo $form->textField($model, 'phone', array('class' => 'form-control phone-input-mask', 'placeholder' => Yii::t('main','Номер мобильного телефона')."*")); ?>
    <?php echo $form->error($model, 'phone'); ?>
</div>
<div class="form-group">
    <?php echo $form->textField($model, 'social_status', array('class' => 'form-control', 'placeholder' => Yii::t('main','Социальный статут'))); ?>
    <?php echo $form->error($model, 'social_status'); ?>
</div>
<div class="form-group">
    <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'Пароль'."*")); ?>
    <?php echo $form->error($model, 'password'); ?>
</div>
<p class="text-form">
        <?php echo Yii::t('main','Нажимая на кнопку «Зарегистрироваться», вы подтверждаете свое согласие с условиями предоставления услуг {link} (пользовательское соглашение) {/link}',
            ['{link}'=>'<a href="#" target="_blank"><span class="text-green">', '{/link}'=>'</span></a>'])?>
</p>

<div class="form-group">
    <?php echo CHtml::ajaxSubmitButton(Yii::t('main','Зарегистрироватся'),CHtml::normalizeUrl(array(Yii::app()->createUrl('/login/registration'),'render'=>true)),
        array(
            'dataType'=>'json',
            'type'=>'post',
            'success'=>'function(data) {
                if (data.status=="success") {
                    $("#sign-up").empty().append(data.message);  
                }     
            }'
        ),array('class'=>'btn btn-regastration')); ?>
</div>

<?php $this->endWidget(); ?>

