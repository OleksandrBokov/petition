<div style="margin-top: 9%;margin-left: 30%; text-align: center;" class="tab-pane active" id="moderator-sign-up-form">
    <div class="col-md-8">
        <h3 class="contact-success"><?php echo Yii::app()->user->getFlash('message'); ?></h3>
        <?php echo CHtml::link(Yii::t('main','На главную'), '/',['class'=>'btn btn-success','style'=>'margin-top:15px;'])?>
    </div>
</div>