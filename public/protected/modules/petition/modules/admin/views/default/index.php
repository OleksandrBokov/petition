<?php
$this->breadcrumbs = array(
    array(
        'label'=>'<span class="text-capitalize">'.$this->pageTitle.'</span>',
        'url'=>Yii::app()->createUrl('admin/petition/default')
    ),
);
?>

<div class="box-body table-responsive no-padding">

    <div class="box ">
        <div class="box-header">
            <h3 class="box-title"><span class="text-capitalize"><?=$this->pageTitle?></span></h3>
        </div>
        <div class="box-body table-responsive " style="padding-left: 30px; padding-right: 30px">
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'petition-grid',
                'dataProvider' => $model->search(),
                'itemsCssClass' => 'table table-hover dataTable',
                'cssFile' => false,
                'filter' => $model,
                'ajaxUpdate' => false,
                'template' => '{items}<div class="pull-right">{pager}</div>',
                'pager'=> array(
                    'header' => '',
                    'firstPageLabel' => false,
                    'lastPageLabel'  => false,
                    'prevPageLabel' => '&laquo; ',
                    'nextPageLabel' => ' &raquo;',
                    'maxButtonCount' => 4,
                    'htmlOptions' => array(
                        'class' => 'pagination',
                        'style' => 'margin-right:30px;'
                    ),
                ),
                'columns' => array(
                    array(
                        'type' => 'raw',
                        'header' => ucfirst(Yii::t("main", "название")),
                        'value' => '$data->title'
                    ),
                    array(
                        'type' => 'raw',
                        'header' => 'Дата',
//                        'value' => '$data->date_create'
                        'value' => 'DateHelper::convertTimeStamp($data->date_create, "H:i d-m-Y", true)'
                    )
                ),
            ));
            ?>
        </div>
    </div>
</div>
