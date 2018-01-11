<div class="flash-success" style="font-size: 18px; text-align: center; min-height: 130px;">
    <?php echo Yii::app()->user->getFlash('successful'); ?>
    <div class="text-right" style="margin-top: 50px;">
        <?=CHtml::link(Yii::t('main','На главную'), Yii::app()->createUrl('/'))?>
    </div>
</div>