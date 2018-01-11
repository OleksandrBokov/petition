<?php
$this->breadcrumbs = array(
    array(
        'label'=>'<span class="text-capitalize">Профиль</span>',
        'url'=>Yii::app()->createUrl('/admin/personal')
    ),
    array(
        'label'=>'<span class="text-capitalize">'.$this->pageTitle.'</span>',
        'url'=>Yii::app()->controller->id
    ),
);
$form=$this->beginWidget('CActiveForm', array(
    'id'=>'admin-form',
    'action'=>Yii::app()->createUrl('/admin/profile/default/update'),
    'enableAjaxValidation' => false,
    'htmlOptions'=>array('class'=>'form-horizontal')
));
?>

<div class="col-xs-4">
    <div class="box ">
        <div class="box-header">
            <h3 class="box-title"><span class="text-capitalize"><?=$this->pageTitle?></span></h3>
            <div class="box-tools">


            </div>
        </div>
        <div class="box-body table-responsive " style="padding-left: 30px; padding-right: 30px">

            <div class="form-group ">
                <label for="" class="control-label"></label>

                    <?php
                    if(!empty($model->photo)){
                        $preview = Yii::app()->request->hostInfo.$model->photo;
                    }else{
                        $preview = Yii::app()->request->hostInfo.'/images/camera_200.png';
                    }
                    echo CHtml::image($preview, '', [
                        'class'=>'avatar-default ManagerCoach_upload_image',
                    ]);
                    echo $form->fileField($model, 'avatar',['class'=>'upload-photo']);

                    ?>
                    <div class="errorMessage ManagerCoach_upload_image"></div>

            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"> <?=$model->getAttributeLabel('firstName')?> </label>
                <div class="col-sm-9">
                    <?php echo $form->textField($model,'firstName',[
                        'class'=>'form-control',
                    ]);?>
                    <?php echo $form->error($model,'firstName'); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"> <?=$model->getAttributeLabel('lastName')?> </label>
                <div class="col-sm-9">
                    <?php echo $form->textField($model,'lastName',[
                        'class'=>'form-control',
                    ]);?>
                    <?php echo $form->error($model,'lastName'); ?>
                </div>
            </div>


        </div>
    </div>
</div>
<?php $this->endWidget(); ?>