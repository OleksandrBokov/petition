<?php
if(!$data){
    $this->breadcrumbs = array(
        array(
            'label'=>'<span class="text-lowercase">'.Yii::t('app','n==1#user|n==2#user|n>=3#users', 3).'</span>',
            'url'=>Yii::app()->createUrl('/admin/users')
        )
    );
}else if($data && $data->isNewRecord){
    $this->breadcrumbs = array(
        array(
            'label'=>'<span class="text-lowercase">'.Yii::t('app','n==1#user|n==2#user|n>=3#users', 3).'</span>',
            'url'=>Yii::app()->createUrl('/admin/users')
        ),
        array(
            'label'=>'<span class="text-lowercase">'.$this->pageTitle.'</span>',
            'url'=>Yii::app()->createUrl('/admin/users/create')
        ),
    );
}else{
    $this->breadcrumbs = array(
        array(
            'label'=>'<span class="text-lowercase">'.Yii::t('app','n==1#user|n==2#user|n>=3#users', 3).'</span>',
            'url'=>Yii::app()->createUrl('/admin/users')
        ),
        array(
            'label'=>'<span class="text-lowercase">'.$this->pageTitle.'</span>',
            'url'=>Yii::app()->createUrl('/admin/users/update?id='.$data->id)
        ),
    );
}
?>

<div class="box ">
            <div class="box-header">
                <h3 class="box-title"><span class="text-capitalize"><?=$this->pageTitle?></span></h3>
                <div class="box-tools pull-right">
                    <?php
                    if(!$data){
                        $this->widget('application.widgets.buttons.ButtonWidget',[
                            'link'=>true,
                            'label'=>Yii::t('app','added|add',2),
                            'url'=>Yii::app()->createUrl('/admin/users/create'),
                            'iconOptions'=>array('class'=>'fa fa-plus')
                        ]);
                    }else{
                        $this->widget('application.widgets.buttons.ButtonWidget',[
                            'link'=>true,
                            'label'=>Yii::t('app','back'),
                            'url'=>Yii::app()->createUrl('/admin/users'),
                            'iconOptions'=>array('class'=>'fa fa-arrow-left')
                        ]);
                    }
                    ?>
                </div>
            </div>
            <div class="box-body ">

            <div class="col-md-8 col-xs-12 table-responsive">
                <?php $this->renderPartial('_table',['model'=>$model]);?>
            </div>

            <div class="col-md-3 col-xs-12 col-md-offset-1">
                <?php
                if($data){
                    $this->renderPartial('_form', array('model'=>$data));
                }
                ?>
            </div>

    </div>

</div>



