<?php
$this->breadcrumbs = array(
    array(
        'label'=>'<span class="text-capitalize">'.$this->pageTitle.'</span>',
        'url'=>Yii::app()->createUrl('moderator/petition/default/create')
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
                        'action' => Yii::app()->createUrl('moderator/petition/default/create'),
                        'enableClientValidation' => true,
                        'method' => 'POST',
                        'htmlOptions'=>array('class'=>'form-horizontal registration')
                    ));
                    ?>

                    <div class="form-group">

                        <?php echo $form->textField($model,'title', array('class' => 'form-control', 'placeholder' => 'Назва')); ?>
                        <?php echo $form->error($model,'title'); ?>
                    </div>

                    <div class="form-group">

                        <?php echo $form->textArea($model,'full_text', array('class' => 'form-control', 'placeholder' => 'Повный текст петиції', 'rows' => 8)); ?>
                        <?php echo $form->error($model,'full_text'); ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-regastration"><?php echo Yii::t('main','Создать')?></button>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
