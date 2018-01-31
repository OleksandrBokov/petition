<?php
/** path to assets in current module **/
$baseUrl = $this->assetsUrl;

/** path to assets in current theme **/
$themeAssetsUrl = $this->themeAssetsUrl;

$cs = Yii::app()->clientScript;

$js_version = 1;
$css_version = 1;

$cs->scriptMap = array(
    'styles.min.css' => false,
    'bootstrap.min.js' => $themeAssetsUrl.'/js/bootstrap.min.js?' . $js_version,
    'bootstrap.min.css' => $themeAssetsUrl.'/css/bootstrap.min.css?' . $css_version,
);


/* INPUT mask*/
$cs->registerScriptFile($themeAssetsUrl.'/js/inputmask/jquery.inputmask.js');

Yii::app()->clientScript->registerScript('phone-mask',"
$(document.body).on('mouseenter','[data-toggle=mask]', function(e){
    
    $(this).inputmask('".Yii::app()->config->get('formatPhoneNumber')."',{'clearIncomplete':true});
});
",CClientScript::POS_READY);

Yii::app()->clientScript->registerScript('bd-mask',"
$(document.body).on('mouseenter','[data-toggle=bd-mask]', function(e){
    
    $(this).inputmask('99.99.9999',{'clearIncomplete':true});
});
",CClientScript::POS_READY);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo Yii::app()->name?> | <?php echo Yii::t('main','Login')?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a ><b><?php echo Yii::app()->name?></b> </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <div class="text">
            <p style="text-align: center"><strong><?php echo Yii::t('main', 'Регистрация');?></strong></p>
            <ol style="padding-left: 5px; text-align: justify">
                <li><span style="color: #d01717">Любий</span> текст</li>
                <li><span style="color: #d01717">Любий</span> текст</li>
                <li><span style="color: #d01717">Любий</span> текст</li>
            </ol>
        </div>
<!--        <h2 class="line">--><?php //echo Yii::t('main', 'Регистрация');?><!--</h2>-->
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' =>'moderator-registration-form',
            'action' => Yii::app()->createUrl('/user/registration'),
            'enableClientValidation' => true,
            'method' => 'POST',
            'htmlOptions'=>array('class'=>'form-horizontal registration', 'style'=>'padding: 0 15px;')
        ));
        ?>
        <?php
//        echo "<pre>";
//        print_r($model->getErrors());
//        echo "</pre>";
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
            <?php echo $form->textField($model,'birthday', array('class' => 'form-control','data-toggle'=>'bd-mask', 'placeholder' => Yii::t('main','Дата рождения'))); ?>
            <?php echo $form->error($model,'birthday'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model,'postIndex', array('class' => 'form-control', 'placeholder' => 'Поштовий індекс')); ?>
            <?php echo $form->error($model,'postIndex'); ?>
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
            <?php echo $form->textField($model, 'phone', array('data-toggle'=>'mask','class' => 'form-control', 'placeholder' => Yii::t('main','Номер мобильного телефона'))); ?>
            <?php echo $form->error($model, 'phone'); ?>
        </div>
        <div class="form-group">
            <?php echo $form->textField($model, 'social_status', array('class' => 'form-control', 'placeholder' => Yii::t('main','Социальный статут'))); ?>
            <?php echo $form->error($model, 'social_status'); ?>
        </div>
        <div class="form-group">
            <?php
            $this->widget('application.ext.yiiReCaptcha.ReCaptcha', array(
                'model'     => $model,
                'attribute' => 'verifyCode',
            ));
            ?>
            <?php echo $form->error($model, 'verifyCode'); ?>
        </div>
        <p class="text-form">
            Натискаючи на кнопку "Зареєструватися", ви підтверджуєте свою згоду з умовами <a href="#" target="_blank"><span class="text-green"> (згода користувача) </span></a></p>
        <div class="form-group">
            <?php if(!is_null($model->getError('userVote'))): ?>
                <h4 style="text-align: center; text-transform: uppercase;"><?php echo $form->error($model, 'userVote'); ?></h4>
                <a href="/" class="btn btn-regastration">На головну</a>
            <?php else: ?>
                <button type="submit" class="btn btn-regastration"><?php echo Yii::t('main','Зарегистрироватся')?></button>
            <?php endif; ?>
        </div>
        <?php $this->endWidget(); ?>

    </div>
    <!-- /.login-box-body -->
</div>

<?php
/**** JS scripts ****/
Yii::app()->clientScript->registerCoreScript('jquery', CClientScript::POS_END);
// Bootstrap
$cs->registerCssFile($themeAssetsUrl.'/css/bootstrap.min.css');
$cs->registerScriptFile($themeAssetsUrl.'/js/bootstrap.min.js', CClientScript::POS_END);
/*-- iCheck --*/
$cs->registerScriptFile($baseUrl.'/iCheck/icheck.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($baseUrl.'/iCheck/icheck.min.js',CClientScript::POS_END,['async'=>'async',
    'onload'=>"$('input#iCheck').iCheck({checkboxClass: 'icheckbox_square-blue',radioClass: 'iradio_square-blue',increaseArea: '20%' });"]);


/**** CSS styles ****/
$cs->registerCssFile($baseUrl.'/css/AdminLTE.min.css');
$cs->registerCssFile($baseUrl.'/iCheck/blue.css');
$cs->registerCssFile($baseUrl.'/css/style.css');


?>

</body>
</html>