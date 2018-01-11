<?php
$baseUrl = $this->assetsUrl;
$cs = Yii::app()->clientScript;

$js_version = 1;
$css_version = 1;

$cs->scriptMap = array(
    'styles.min.css' => false,
    'bootstrap.min.js' => $baseUrl.'/js/bootstrap.min.js?' . $js_version,
    'bootstrap.min.css' => $baseUrl.'/css/bootstrap.min.css?' . $css_version,
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
    <style>
        .modal-backdrop{
            z-index: 1;
        }
    </style>
</head>

<body>
<?php
$this->renderPartial('/layouts/_header');
?>


<div class="container" style="margin-top: 100px;">

    <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        )); ?><!-- breadcrumbs -->
    <?php endif?>

    <?php echo $content; ?>
</div>

<!-- /.container -->
<?php
Yii::app()->clientScript->registerCoreScript('jquery', CClientScript::POS_END);
// Bootstrap
$cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
$cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js', CClientScript::POS_END);


?>
</body>

</html>