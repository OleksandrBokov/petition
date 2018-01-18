
<div class="flexbox">

    <div class="container-full-width "><!--bg-balls-4-->
        <div class="add-object-form">
           <h3 class="contact-success"><?php echo Yii::app()->user->getFlash('message'); ?></h3>
            <?php echo CHtml::link(Yii::t('main','На главную'), '/',['class'=>'btn btn-regastration','style'=>'margin-bottom:15px;'])?>
        </div>
    </div>
</div>
<?php
//$this->renderPartial('application.views.layouts._footer');
?>