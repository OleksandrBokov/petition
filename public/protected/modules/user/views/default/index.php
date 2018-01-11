<?php
$this->breadcrumbs = array(
    array(
        'label'=>'<span class="text-capitalize">'.$this->pageTitle.'</span>',
        'url'=>Yii::app()->createUrl('user')
    ),
);

//echo "<pre>";
//print_r($model->orderSchedules);
//echo "</pre>";die;
?>
<div class="col-xs-4 col-md-12">
    <div class="box ">
        <div class="box-header">
            <h3 class="box-title"><span class="text-capitalize"><?=$this->pageTitle?></span></h3>
        </div>
        <div class="box-body table-responsive no-padding ">

            <?php
//            echo 123;die;
//            echo "<pre>";
//            print_r($model->getData());
//            echo "</pre>";die;
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
//                    array(
//                        'name' => 'id',
//                        'value' => '$data["id"]',
//                    ),
                    array(
                        'name' => 'Название',
                        'value' => '$data["name"]'
                    ),
                    array(
                        'name' => 'От',
                        'value' => '$data["start_time"]'
                    ),
                    array(
                        'name' => 'до',
                        'value' => '$data["end_time"]'
                    ),
                    array(
                        'name' => 'Цена',
                        'value' => '$data["price"]'
                    ),
                )
            ));
            ?>


        </div>

    </div>
</div>