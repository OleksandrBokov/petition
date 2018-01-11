
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'reset-password-form',
    'action'=>Yii::app()->createUrl('/login/reset/password'),
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
));
?>
<div class="form-group">
    <?php echo $form->label($model,'email');?>
    <div class="input-group">
        <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
        <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'Э-почта')); ?>
    </div>
    <?php echo $form->error($model, 'email'); ?>
</div>

<?php
echo CHtml::openTag('button', array('type' => 'submit', 'class' => 'btn btn-primary right'));
echo Yii::t('main','Отправить');
echo CHtml::closeTag('button');
?>
<?php $this->endWidget(); ?>



