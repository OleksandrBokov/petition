<?php
$this->breadcrumbs = array(
    array(
        'label'=>'<span class="text-capitalize">'.$this->pageTitle.'</span>',
        'url'=>Yii::app()->createUrl('/admin/default/capcha')
    ),
);
?>

<div class="box-body table-responsive no-padding">

    <div class="box ">
        <div class="box-header">
            <h3 class="box-title"><span class="text-capitalize"><?=$this->pageTitle?></span></h3>
        </div>
        <div class="box-body table-responsive " style="padding-left: 30px; padding-right: 30px">
            <div class="tab-pane active">
                <div class="col-md-8">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' =>'moderator-petition-form',
                        'action' => Yii::app()->createUrl('/admin/default/capcha'),
                        //'enableClientValidation' => true,
                        'method' => 'POST',
                        'htmlOptions'=>array('class'=>'form-horizontal registration')
                    ));
                    ?>

                    <div class="form-group">

                        <?php echo $form->textField($capchaKey,'capchaKey', array('class' => 'form-control', 'placeholder' => 'Ключ')); ?>
                        <?php //echo $form->error($model,'capchaKey'); ?>
                    </div>

                    <div class="form-group">

                        <?php echo $form->textArea($capchaSecretKey,'capchaSecretKey', array('class' => 'form-control', 'placeholder' => 'Секретный ключ')); ?>
                        <?php //echo $form->error($model,'capchaSecretKey'); ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-regastration"><?php echo Yii::t('main','Обновить')?></button>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
