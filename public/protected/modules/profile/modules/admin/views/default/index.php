<?php
$this->breadcrumbs = array(
    array(
        'label'=>'<span class="text-capitalize">'.$this->pageTitle.'</span>',
        'url'=>Yii::app()->controller->id
    ),
);
?>
<div class="col-xs-4">
<div class="box ">
    <div class="box-header">
        <h3 class="box-title"><span class="text-capitalize"><?=$this->pageTitle?></span></h3>
        <div class="box-tools">
            <a href="/admin/profile/default/update" class="btn btn-sm btn-default btn-nav text-capitalize">
               <span class="glyphicon  glyphicon-pencil btn-span "></span>
                Изменить
            </a>
            <a href="/admin/profile/default/password" class="btn btn-sm btn-default btn-nav text-capitalize">
                <span class="glyphicon glyphicon-lock btn-span "></span>
                сменить пароль
            </a>
        </div>
    </div>
    <div class="box-body table-responsive no-padding ">

        <div style="margin: 15px">
            <?php
            $this->widget('application.extensions.widgets.avatar.AvatarWidget',array(
                'image'=>array(
                    'src'=>$model->avatar,
                    'alt'=>'admin',//$model->firstName.' '.$model->lastName,//
                    'base_url'=>Yii::app()->request->hostInfo,
                    'upload'=>array(),
                ),
                'color'=>'#bb0289',
            ));
        ?>
        </div>
            <?php $this->widget('zii.widgets.CDetailView', array(
                'data'=>$model,
                'htmlOptions' => array('class'=>'table table-hover dataTable'),
                'cssFile' => false,
                'attributes'=>array(
                    'email',
                    'login',
                    'firstName',
                    'lastName',
                    'phone'
                ),
            )); ?>
        </div>

</div>
</div>