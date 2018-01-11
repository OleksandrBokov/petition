<?php
$this->breadcrumbs = array(
    array(
        'label'=>'<span class="text-capitalize">'.Yii::t('main', 'Профиль').'</span>',
        'url'=>Yii::app()->createUrl('/user/profile')
    ),
    array(
        'label'=>'<span class="text-capitalize">'.$this->pageTitle.'</span>',
        'url'=>Yii::app()->createUrl('/user/profile/default/update')
    ),
);

?>

<div class="col-xs-12 col-md-4">
    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'user-form',
        'action'=>Yii::app()->createUrl('/user/profile/default/update'),
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'htmlOptions'=>array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'),
        'method' => 'POST',
    ));
    ?>
    <div class="box ">
        <div class="box-header">
            <h3 class="box-title"><span class="text-capitalize"><?=$this->pageTitle?></span></h3>
        </div>
        <div class="box-body table-responsive " style="padding-left: 30px; padding-right: 30px">

            <div class="form-group ">
                <label for="" class="control-label"></label>
                <?php
                $this->widget('application.extensions.widgets.avatar.AvatarWidget',array(
                    'image'=>array(
                        'src'=>$model->avatar,
                        'alt'=>$model->lastName.' '.$model->firstName,
                        'base_url'=>Yii::app()->request->hostInfo,
                        'upload'=>false,
                        'htmlOptions'=>array('class'=>'avatar-default'),
                        'itemOptions'=>array('style'=>'font-size: 75px;line-height: 125px;')
                    ),
                    'color'=>'#bb0289',
                ));
                ?>
                    <div class="errorMessage ManagerCoach_upload_image"></div>

            </div>


            <div class="form-group">
                <label class="col-sm-3 control-label"> <?=$model->getAttributeLabel('email')?> </label>
                <div class="col-sm-9">
                    <?php echo $form->textField($model,'email',[
                        'class'=>'form-control',
                    ]);?>
                    <?php echo $form->error($model,'email'); ?>
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
<div class="col-xs-12 col-md-4">
    <div class="box ">
        <div class="box-header">
            <h3 class="box-title"><span class="text-capitalize"><?php echo Yii::t('main','Изменить пароль')?></span></h3>
        </div>
        <div class="box-body table-responsive " style="padding-left: 30px; padding-right: 30px">
            <?php $form=$this->beginWidget('CActiveForm',
                array(
                    'id'=>'changePass-form',
                    'action'=>Yii::app()->createUrl('/user/profile/default/update'),
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'htmlOptions'=>array('class'=>'form-horizontal'),
                    'method' => 'POST',
                )
            ); ?>

            <div class="form-group">
                <label class="col-sm-5 control-label"> <?=$changePasswordForm->getAttributeLabel('current_password')?> </label>
                <div class="col-sm-7">
                    <?php echo $form->passwordField($changePasswordForm,'current_password',[
                        'class'=>'form-control',
                    ]);?>
                    <?php echo $form->error($changePasswordForm,'current_password'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 control-label"> <?=$changePasswordForm->getAttributeLabel('new_password')?> </label>
                <div class="col-sm-7">
                    <?php echo $form->passwordField($changePasswordForm,'new_password',[
                        'class'=>'form-control',
                    ]);?>
                    <?php echo $form->error($changePasswordForm,'new_password'); ?>
                </div>
            </div>
            <?php echo CHtml::openTag('button',['type'=>'submit','class'=>'btn btn-sm btn-default btn-nav text-capitalize']);
            echo CHtml::openTag('span',['class'=>'glyphicon  glyphicon-ok-circle btn-span ']).CHtml::closeTag('span');
            echo Yii::t('main', 'Изменить пароль');
            echo CHtml::closeTag('button');
            ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>


<?php
//Yii::app()->clientScript->registerScript('uploadPhoto',"
//    $('.upload-photo').change(function(){
//        readURL(this, $(this).attr('id'));
//    });
//    function readURL(input, ID) {
//        if (input.files && input.files[0]) {
////            console.log(input.files);
////            console.log(ID);
//            if(checkUploadValidFile(input.files[0], ID)){
//                var reader = new FileReader();
//                reader.onload = function (e) {
//                    $('img.'+ID).attr('src', e.target.result);
//                    $('textarea.'+ID).val( e.target.result);
//                }
//                reader.readAsDataURL(input.files[0]);
//            }/**/
//        }
//    }
//    function checkUploadValidFile(file, ID){
//        var response = true;
//        var filename = file.name;
//        var filesize = file.size;
//        var maxFileSize = ".Yii::app()->config->get('file_size')." * 1000000; //1Mb = 1000000;
//        var extension = filename.replace(/^.*\./, '');
//
//        if (!file.type.match('image.*')) {
//            response = response && false;
//             setError('".Yii::t('main','Не верный формат загруженного вами файла ')."', ID);
//        }
//        if(!(parseInt(filesize) < parseInt(maxFileSize))){
//            response = response && false;
//            var size = parseFloat((filesize/1000000).toFixed(1));
//            setError(  '".Yii::t('main','Файл слишком большой : {alias} MB максимум',array('{alias}' =>Yii::app()->config->get('file_size')))."', ID);
//        }
//        if(response) clearError(ID);
//        return response;
//    }
//    function setError(error, ID){
//
//        var errorHtml = $('.errorMessage.'+ID);
//        errorHtml.empty();
//        errorHtml.append(error);
//    }
//    function clearError(ID){
//        var errorHtml = $('.errorMessage.'+ID);
//        errorHtml.empty();
//    }
//",CClientScript::POS_READY)
?>
