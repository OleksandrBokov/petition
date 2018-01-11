<?php
$this->breadcrumbs = array(
    array(
        'label'=>'<span class="text-capitalize">'.$this->pageTitle.'</span>',
        'url'=>Yii::app()->createUrl('owner/section/default')
    ),
    array(
        'label'=>'<span class="text-capitalize">'.$section_name.'</span>',
        'url'=>Yii::app()->createUrl('owner/section/default/view', ['id'=>$_GET['id']])
    ),
);
?>
<div class="col-xs-4 col-md-12">
    <div class="box ">
        <div class="box-header">
            <h3 class="box-title"><span class="text-capitalize"><?php echo $section_name; ?></span></h3>
        </div>
        <div class="box-body table-responsive no-padding ">

            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'schedule-grid',
                'dataProvider' => $model,
                'itemsCssClass' => 'table table-hover dataTable',
                'cssFile' => false,
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
                        'name' => 'Время',
                        'value' => '$data["start_time"]'
                    ),
                    array(
                        'name' => 'Пользователь',
                        'value' => '$data["user"]->lastName." ".$data["user"]->	firstName'
                    ),
                    array(
                        'name' => 'Телефон',
                        'value' => 'CHtml::link($data["user"]->phone,"tel:".str_replace(" ", "", $data["user"]->phone))',
                        'type'  => 'raw',
                    ),
                    array(
                        'name' => 'Email',
                        'value' => 'CHtml::mailto($data["user"]->email)',
                        'type'=>'raw'
                    ),
                )
            ));
            ?>
        </div>
    </div>
</div>
