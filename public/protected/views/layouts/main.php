<?php
$baseUrl = $this->assetsUrl;
$cs = Yii::app()->clientScript;
$cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
$cs->registerCssFile($baseUrl.'/css/fuelux.min.css');
$cs->registerCssFile($baseUrl.'/css/non-responsive.css');
$cs->registerCssFile($baseUrl.'/fonts/font-awesome.min.css');
$cs->registerCssFile($baseUrl.'/css/bootstrap-datepicker.css');
//$cs->registerCssFile($baseUrl.'/css/main.css');
$cs->registerCssFile($baseUrl.'/css/m.css');
$cs->registerCssFile($baseUrl.'/css/selectbox.css');
$cs->registerCssFile($baseUrl.'/css/custom.css');

Yii::app()->clientScript->registerCoreScript('jquery', CClientScript::POS_END);
Yii::app()->clientScript->registerCoreScript('jquery.ui', CClientScript::POS_END);

$cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/fuelux.min.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/datepicker/bootstrap-datepicker.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/datepicker/locales/bootstrap-datepicker.'.Yii::app()->language.'.min.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/tabs.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/popup.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/custom.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl.'/js/copy.js', CClientScript::POS_END);
//$cs->registerScriptFile($baseUrl.'/js/inputmask/jquery.inputmask.js', CClientScript::POS_END,
//    ['onload' =>"$('.phone-input-mask').inputmask('".Yii::app()->config->get('formatPhoneNumber')."',{'clearIncomplete':true});"]);
//
//$cs->registerScriptFile($baseUrl.'/js/main.js', CClientScript::POS_END);
//$cs->registerScript('date_script_picker',"
//   $('.input-daterange').datepicker({
//   format: 'dd.mm.yyyy',
//   language: $('.input-daterange').attr('data-lang'),
//   orientation: 'bottom',
//});
//
//", CClientScript::POS_END)
?>
<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8" />
  <title><?php echo Yii::app()->name?></title>

</head>
<body>

<?php
//$this->renderPartial('application.views.layouts._header');
echo $content;

?>

</body>
</html>