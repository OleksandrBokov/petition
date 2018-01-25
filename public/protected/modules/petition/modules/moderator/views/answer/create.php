<?php
$this->breadcrumbs = array(
    array(
        'label'=>'<span class="text-capitalize">'.$this->pageTitle.'</span>',
        'url'=>Yii::app()->createUrl('moderator/petition/answer/create')
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
                        'action' => Yii::app()->createUrl('moderator/petition/answer/create'),
                        'enableClientValidation' => true,
                        'method' => 'POST',
                        'htmlOptions'=>array('class'=>'form-horizontal registration')
                    ));
                    ?>

<!--                    <div class="form-group">-->
<!---->
<!--                        --><?php //echo $form->textField($model,'title', array('class' => 'form-control', 'placeholder' => 'Назва')); ?>
<!--                        --><?php //echo $form->error($model,'title'); ?>
<!--                    </div>-->
                    <div class="form-group">
                        <?php
                        echo $form->dropDownList($model, 'petition_id', CHtml::listData( Petition::model()->findAll(),'id','title'),
                            array('empty'=>array(' '=>'Назва петиції'),'class'=>'form-control'));
                        ?>
                        <?php echo $form->error($model, 'petition_id'); ?>
                    </div>
                    <div class="form-group">

                        <?php echo $form->textArea($model,'answer', array('class' => 'form-control', 'placeholder' => Yii::t('main','Полный текст ответа'), 'rows' => 8)); ?>
                        <?php echo $form->error($model,'answer'); ?>
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
