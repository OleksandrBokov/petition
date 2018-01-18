<?php
$this->breadcrumbs = array(
    array(
        'label'=>'<span class="text-capitalize">'.$this->pageTitle.'</span>',
        'url'=>Yii::app()->createUrl('moderator/petition/default')
    ),
);
?>

<div class="box-body table-responsive no-padding">

    <div class="box ">
        <div class="box-header">
            <h3 class="box-title"><span class="text-capitalize"><?=$this->pageTitle?></span></h3>

            <div class="box-tools pull-right">
                <a href="<?php echo Yii::app()->createUrl("/admin/config/default/update");?>" class="btn  btn-primary">
                    <?php echo Yii::t('main', 'Редагувати')?>
                </a>
            </div>

        </div>
        <div class="box-body table-responsive " style="padding-left: 30px; padding-right: 30px">
            <?php
            foreach ($items as $item){
                $this->widget('zii.widgets.CListView', array(
                    'summaryText'=>false,
                    'dataProvider'=>$item,
                    'itemView'=>'_view',
                    'itemsTagName'=>'ul',
                    'itemsCssClass'=>'config-list clearfix',
                ));
            }

            ?>
        </div>
    </div>
</div>
