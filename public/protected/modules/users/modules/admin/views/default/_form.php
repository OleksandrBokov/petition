
<?php if(!$model->isNewRecord):?>
    <ul class="nav nav-tabs" role="tablist" style="margin-right: -15px;margin-left: -15px;">
        <li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab"><?=Yii::t('app','info')?></a></li>
        <li role="presentation"><a href="#new_password" aria-controls="meta" role="tab" data-toggle="tab"><?=Yii::t('app','change password')?></a></li>
    </ul>
<?php endif;?>
<?php
$action = ($model->isNewRecord) ? Yii::app()->controller->createUrl('create') : Yii::app()->controller->createUrl("update",array("id"=>$model->primaryKey));
$form=$this->beginWidget('CActiveForm', array(
    'id'=>'station-form',
    'action'=>$action,
    'enableAjaxValidation' => false,
    'htmlOptions'=>array('class'=>'form-horizontal')
));
?>

<div class="tab-content" style="margin-top: 15px;">
    <div role="tabpanel" class="tab-pane active" id="info">
        <div class="form-group">
            <label class="control-label text-capitalize"> <?=$model->getAttributeLabel('lastName')?> </label>
            <?php echo $form->textField($model,'lastName',[
                'class'=>'form-control',
            ]);?>
            <?php echo $form->error($model,'lastName'); ?>
        </div>
        <div class="form-group">
            <label class="control-label text-capitalize"> <?=$model->getAttributeLabel('firstName')?> </label>
            <?php echo $form->textField($model,'firstName',[
                'class'=>'form-control',
            ]);?>
            <?php echo $form->error($model,'firstName'); ?>
        </div>
        <div class="form-group">
            <label class="control-label text-capitalize"> <?=$model->getAttributeLabel('email')?> <i class="text-red">*</i> </label>
            <?php echo $form->textField($model,'email',[
                'class'=>'form-control',
            ]);?>
            <?php echo $form->error($model,'email'); ?>
        </div>

        <?php if($model->isNewRecord):?>
            <div class="form-group">
                <label class="control-label text-capitalize"> <?=$model->getAttributeLabel('password')?> <i class="text-red">*</i> </label>

                <?php echo $form->textField($model,'password',[
                    'class'=>'form-control input-password',
                ]);?>
                <?php echo CHtml::link(Yii::t('app','generate'), "#",array('id'=>'generate','class'=>'pull-right'));
                ?>
                <?php echo $form->error($model,'password'); ?>
            </div>
        <?php else:?>
            <div class="form-group">
                <label class="control-label text-capitalize"> <?=$model->getAttributeLabel('status')?>  </label>

                <div class="pull-left col-sm-12 " style="padding-left: 0">
                    <?php $this->widget('application.widgets.switch.SwitchWidget',array(
                        'model'=>$model,
                        'attribute'=>'status',
                        'on_label'=>false,
                        'onText'=>Yii::t('app','n==0#not_authorized|n==1#authorized|n==3#blocked',User::STATUS_AUTHORIZED),
                        'offText'=>Yii::t('app','n==0#not_authorized|n==1#authorized|n==3#blocked',User::STATUS_BLOCKED),
                        'onValue'=>User::STATUS_AUTHORIZED,
                        'offValue'=>User::STATUS_BLOCKED,
                        'onColor'=>'success',
                        'offColor'=>'danger',
                    ))?>
                </div>


            </div>
        <?php endif;?>
    </div>
    <div role="tabpanel" class="tab-pane " id="new_password">
        <div class="form-group">
            <label class="control-label text-capitalize"> <?=$model->getAttributeLabel('password')?> </label>

            <?php echo $form->textField($model,'new_password',[
                'class'=>'form-control input-password',
            ]);?>
            <?php echo CHtml::link(Yii::t('app','generate'), "#",array('id'=>'generate','class'=>'pull-right'));
            ?>
            <?php echo $form->error($model,'new_password'); ?>
        </div>
    </div>

    <div class=" pull-right">
        <?php
        $this->widget('application.widgets.buttons.ButtonWidget',[
            'link'=>false,
            'label'=>($model->isNewRecord) ? Yii::t('app','save') : Yii::t('app','edit'),
            'htmlOptions'=>['type'=>'submit','class'=>'btn btn-sm btn-success btn-nav text-capitalize', 'style'=>'margin-right: -15px; margin-top: 15px;' ]
        ]);
        ?>
    </div>

</div>

<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerScript('generate','
    $("#generate").on("click", function(e){
        $.ajax({type :  "get", url  : "/site/generate",
            success: function(data){ $(".input-password").val(data); }
        })
        e.preventDefault();
    })
', CClientScript::POS_END);
?>



