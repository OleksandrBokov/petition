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
    'dataTables.bootstrap.css' => $baseUrl.'/css/dataTables.bootstrap.css?' . $css_version,
//    'jquery.js'=>false,
);
$cs->coreScriptPosition = CClientScript::POS_END;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo Yii::app()->name?> | <?=$this->pageTitle?></title>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="skin-blue sidebar-mini" >
<?php
/** notice by new task **/
//if(Yii::app()->user->role == User::ROLE_ADMIN){
//   // $this->renderPartial('application.modules.task.widgets.views._newBid');
//}

?>

<div class="wrapper">
    <!-- Header -->
    <?php  $this->renderPartial($this->defaultViewPath.'layouts._header'); ?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php  $this->renderPartial($this->defaultViewPath.'layouts._left'); ?>
    <div class="content-wrapper">

        <section class="content-header">
            <?php $this->widget('application.extensions.ltebreadcrumbs.LTEBreadcrumbs', array(
                'items'=>CMap::mergeArray(
                    array(
                        array(
                            'label'=>Yii::t('main','Кабинет'),
                            'icon'=>'fa fa-dashboard',
                            'url' =>'/user'
                        )

                    ),$this->breadcrumbs
                ),
            ));
            ?><!-- breadcrumbs -->
        </section>
        <section class="content" style="margin-top: 30px;">

<!--            <div id="loader-wrapper" ng-cloak class="ng-cloak">-->
<!--                <div id="loader"></div>-->
<!--                <div class="loader-section section-left"></div>-->
<!--                <div class="loader-section section-right"></div>-->
<!--            </div>-->
            <?php echo $content; ?>
        </section>

    </div>
</div>

<?php

Yii::app()->clientScript->registerCoreScript('jquery');

/*-- Bootstrap -- */
$cs->registerCssFile($themeAssetsUrl.'/css/bootstrap.min.css');
$cs->registerScriptFile($themeAssetsUrl.'/js/bootstrap.min.js', CClientScript::POS_END);

/*-- AdminLTE -- */
$cs->registerCssFile($baseUrl.'/css/AdminLTE.min.css');
$cs->registerCssFile($baseUrl.'/css/skins/_all-skins.min.css');
$cs->registerScriptFile($baseUrl.'/js/app.min.js', CClientScript::POS_END);

/*-- iCheck --*/
$cs->registerCssFile($baseUrl.'/iCheck/blue.css');
$cs->registerScriptFile($baseUrl.'/iCheck/icheck.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile($baseUrl.'/iCheck/icheck.min.js',CClientScript::POS_END,['async'=>'async',
    'onload'=>"$('input#iCheck').iCheck({checkboxClass: 'icheckbox_square-blue',radioClass: 'iradio_square-blue',increaseArea: '20%' });"]);

/*-- FontAwesome 4.3.0 --*/
$cs->registerCssFile($baseUrl.'/fonts/font-awesome.min.css');

$cs->registerCssFile($baseUrl.'/css/style.css');
$cs->registerCssFile($baseUrl.'/css/loader.css');
$cs->registerCssFile($baseUrl.'/css/dataTables.bootstrap.css');

/*-- InputMask --*/
//$cs->registerScriptFile($themeAssetsUrl.'/js/inputmask/jquery.inputmask.js', CClientScript::POS_END);

/* INPUT mask*/
$cs->registerScriptFile($themeAssetsUrl.'/js/inputmask/jquery.inputmask.js', CClientScript::POS_END);
//['onload' =>"$('#AdminManager_phone').inputmask('".Yii::app()->config->get('formatPhoneNumber')."',{'clearIncomplete':true});"]
Yii::app()->clientScript->registerScript('phone-mask',"
$(document.body).on('mouseenter','[data-toggle=mask]', function(e){
    
    $(this).inputmask('".Yii::app()->config->get('formatPhoneNumber')."',{'clearIncomplete':true});
});
",CClientScript::POS_READY);

/*** Preloader ***/
//Yii::app()->clientScript->registerScript('loader',"
//$(window).on('load', function () {
//        var preloader = $('#loader-wrapper');
//        preloader.delay(350).fadeOut('slow');
//    });
//",CClientScript::POS_END)
?>

</body>

</html>

