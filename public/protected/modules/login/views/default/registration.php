<div style="margin-left: 30%;" class="tab-pane active" id="moderator-sign-up-form">
    <div class="col-md-8">
        <h2 class="line"><?php echo Yii::t('main', 'Регистрация');?></h2>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' =>'moderator-registration-form',
            'action' => Yii::app()->createUrl('/moderator/registration'),
            'enableClientValidation' => true,
            'method' => 'POST',
            'htmlOptions'=>array('class'=>'form-horizontal registration')
        ));
        ?>

        <div class="form-group">
            <?php echo $form->textField($model,'firstName', array('class' => 'form-control', 'placeholder' => Yii::t('main','Имя'))); ?>
            <?php echo $form->error($model,'firstName'); ?>
        </div>

        <div class="form-group">

            <?php echo $form->textField($model,'lastName', array('class' => 'form-control', 'placeholder' => Yii::t('main','Фамилия'))); ?>
            <?php echo $form->error($model,'lastName'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model,'patronymic', array('class' => 'form-control', 'placeholder' => Yii::t('main','Отчество'))); ?>
            <?php echo $form->error($model,'patronymic'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model,'birthday', array('class' => 'form-control birthday-input-mask', 'placeholder' => Yii::t('main','Дата рождения'))); ?>
            <?php echo $form->error($model,'birthday'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model,'address', array('class' => 'form-control', 'placeholder' => Yii::t('main','Адрес'))); ?>
            <?php echo $form->error($model,'address'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model,'inn', array('class' => 'form-control', 'placeholder' => Yii::t('main','ИНН'))); ?>
            <?php echo $form->error($model,'inn'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => Yii::t('main','Э-почта'))); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>
        <div class="form-group">
            <?php echo $form->textField($model, 'phone', array('class' => 'form-control phone-input-mask', 'placeholder' => Yii::t('main','Номер мобильного телефона'))); ?>
            <?php echo $form->error($model, 'phone'); ?>
        </div>
        <div class="form-group">
            <?php echo $form->textField($model, 'social_status', array('class' => 'form-control', 'placeholder' => Yii::t('main','Социальный статут'))); ?>
            <?php echo $form->error($model, 'social_status'); ?>
        </div>
        <div class="form-group">
            <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'Пароль')); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
        <div class="form-group">
            <?php
            $this->widget('application.ext.yiiReCaptcha.ReCaptcha', array(
                'model'     => $model,
                'attribute' => 'verifyCode',
                'key'=>Yii::app()->config->get('capchaKey'),//.'sasha',
                'secret'=>Yii::app()->config->get('capchaSecretKey'),
                //'isSecureToken' => true, //для нескольких доменов
            ));
            ?>
            <?php echo $form->error($model, 'verifyCode'); ?>
        </div>

        <p class="text-form">
            Натискаючи на кнопку "Зареєструватися", ви підтверджуєте свою згоду з умовами <a href="#" target="_blank"><span class="text-green"> (згода користувача) </span></a></p>
        <div class="form-group">
            <button type="submit" class="btn btn-regastration"><?php echo Yii::t('main','Зарегистрироватся')?></button>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>