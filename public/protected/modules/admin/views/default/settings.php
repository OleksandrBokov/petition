<?php
$this->breadcrumbs = array(
    array(
        'label'=>'<span class="text-capitalize">'.$this->pageTitle.'</span>',
        'url'=>Yii::app()->createUrl('admin/default/settings')
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
//                    'id'
                    array(
                        'type' => 'raw',
                        'header' => ucfirst(Yii::t("main", "Название")),
                        'value' => '$data->param'
                    ),
                    array(
                        'type' => 'raw',
                        'header' => ucfirst(Yii::t("main", "Значение")),
                        'value' => '$data->value'
                    ),
                    array(
                        'type' => 'raw',
                        'header' => ucfirst(Yii::t("main", "Значение по умолчанию")),
                        'value' => '$data->default'
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>
