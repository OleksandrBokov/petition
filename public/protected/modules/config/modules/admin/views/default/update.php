<?php
$this->breadcrumbs = array(
    array(
        'label'=>'<span class="text-capitalize">'.$this->pageTitle.'</span>',
        'url'=>Yii::app()->createUrl('/admin/config/default/update')
    ),
);
$form = $this->beginWidget('CActiveForm', array(
    'id' =>'moderator-petition-form',
    'action' => Yii::app()->createUrl('/admin/config/default/update'),
    //'enableClientValidation' => true,
    'method' => 'POST',
    'htmlOptions'=>array('class'=>'form-horizontal registration')
));
?>
<?php
//echo "<pre>";
//print_r($model);
//echo "</pre>";
?>
<div class="box-body table-responsive no-padding">

    <div class="box ">
        <div class="box-header">
            <h3 class="box-title"><span class="text-capitalize"><?=$this->pageTitle?></span></h3>
            <div class="box-tools pull-right">
                <button type="submit" class="btn btn-regastration"><?php echo Yii::t('main','Обновить')?></button>
            </div>

        </div>
        <div class="box-body table-responsive " style="padding-left: 30px; padding-right: 30px">
            <?php foreach ($model as $m): ?>
                <div class="form-group">
                    <label class="control-label"><?php echo Yii::t('main', "{$m->label}"); ?></label>
                </div>
                <?php echo CHtml::activeTextField($m, "[$m->param]value", ['placeholder'=>$m->default, 'class'=>'form-control']); ?>
            <?php endforeach; ?>
<!--            <div class="form-group">-->
<!---->
<!--                --><?php //echo $form->textField($capchaKey,'capchaKey', array('class' => 'form-control', 'placeholder' => 'Ключ')); ?>
<!--                --><?php ////echo $form->error($model,'capchaKey'); ?>
<!--            </div>-->
<!---->
<!--            <div class="form-group">-->
<!---->
<!--                --><?php //echo $form->textArea($capchaSecretKey,'capchaSecretKey', array('class' => 'form-control', 'placeholder' => 'Секретный ключ')); ?>
<!--                --><?php ////echo $form->error($model,'capchaSecretKey'); ?>
<!--            </div>-->

        </div>
    </div>
</div>
    <?php $this->endWidget(); ?>