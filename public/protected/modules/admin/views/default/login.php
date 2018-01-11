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
$cs->coreScriptPosition = CClientScript::POS_END;
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
        <p class="login-box-msg"><?php echo Yii::t('main','Войти, чтобы начать сеанс')?></p>
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'admin-login-form',
            'enableClientValidation'=>true,
            'enableAjaxValidation'=>false,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            )
        )); ?>
        <div class="form-group has-feedback">

            <?php echo $form->textField($model,'username',
                array('class' => 'form-control form-control-solid placeholder-no-fix',
                    'placeholder' => Yii::t('main','E-mail').'*')); ?>
            <span class='glyphicon glyphicon-envelope form-control-feedback'></span>
            <?php echo $form->error($model,'username'); ?>
        </div>
        <div class="form-group has-feedback">
            <?php echo $form->passwordField($model,'password',
                array('class' => 'form-control form-control-solid placeholder-no-fix',
                    'placeholder' => Yii::t('main','Пароль').'*')); ?>
            <span class='glyphicon glyphicon-lock form-control-feedback'></span>
            <?php echo $form->error($model,'password'); ?>
        </div>
        <div class="row">
            <div class="col-xs-12 ">
                <div class="checkbox icheck no-margin">
                    <label>
                        <?php echo $form->checkBox($model,'rememberMe',array(
                            'checked'=>'checked','id'=>'iCheck'
                        )); ?> <?=$model->getAttributeLabel('rememberMe')?>
                    </label>
                </div>
            </div>
            <div class="clearfix" style="margin: 20px;"></div>
            <div class="col-xs-12">
                <input type="submit" class="btn btn-primary btn-block" style="padding-top:10px;padding-bottom: 10px;font-size: 18px;" value="<?php echo Yii::t('main','Войти')?>" />
            </div>
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


?>

</body>
</html>