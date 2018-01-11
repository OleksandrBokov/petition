<?php
$this->breadcrumbs = array(
    array(
        'label'=>'<span class="text-capitalize">'.$this->pageTitle.'</span>',
        'url'=>Yii::app()->createUrl('admin/petition/default')
    ),
);
?>

    <div class="box-body table-responsive no-padding">
        <?php

        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'user-form',
            'action'=>Yii::app()->createUrl('/admin/petition/default/update'),
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'htmlOptions'=>array('class'=>'form-horizontal'/*, 'enctype'=>'multipart/form-data'*/),
            'method' => 'POST',
        ));
        ?>
        <div class="box ">
            <div class="box-header">
                <h3 class="box-title"><span class="text-capitalize"><?=$this->pageTitle?></span></h3>
            </div>
            <div class="box-body table-responsive " style="padding-left: 30px; padding-right: 30px">

<!--                <div class="form-group ">-->
<!--                    <label for="" class="control-label"></label>-->
<!--                    --><?php
//                    $this->widget('application.extensions.widgets.avatar.AvatarWidget',array(
//                        'image'=>array(
//                            'src'=>$model->avatar,
//                            'alt'=>$model->lastName.' '.$model->firstName,
//                            'base_url'=>Yii::app()->request->hostInfo,
//                            'upload'=>false,
//                            'htmlOptions'=>array('class'=>'avatar-default'),
//                            'itemOptions'=>array('style'=>'font-size: 75px;line-height: 125px;')
//                        ),
//                        'color'=>'#bb0289',
//                    ));
//                    ?>
<!--                    <div class="errorMessage ManagerCoach_upload_image"></div>-->
<!---->
<!--                </div>-->


                <div class="form-group">
                    <label class="col-sm-3 control-label"> <?=$model->getAttributeLabel('title')?> </label>
                    <div class="col-sm-9">
                        <?php echo $form->textField($model,'title',[
                            'class'=>'form-control',
                        ]);?>
                        <?php echo $form->error($model,'title'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"> <?=$model->getAttributeLabel('full_text')?> </label>
                    <div class="col-sm-9">
                        <?php echo $form->textArea($model,'full_text',[
                            'class'=>'form-control',
                        ]);?>
                        <?php echo $form->error($model,'full_text'); ?>
                    </div>
                </div>

                <?php echo CHtml::openTag('button',['type'=>'submit','class'=>'btn btn-sm btn-default btn-nav text-capitalize']);
                echo CHtml::openTag('span',['class'=>'glyphicon  glyphicon-ok-circle btn-span ']).CHtml::closeTag('span');
                echo Yii::t('main','сохранить');
                echo CHtml::closeTag('button');
                ?>
            </div>

        </div>
        <?php $this->endWidget(); ?>
    </div>

