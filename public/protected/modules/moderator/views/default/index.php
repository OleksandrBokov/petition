<?php
//$this->breadcrumbs = array(
//    array(
//        'label'=>'<span class="text-capitalize">'.$this->pageTitle.'</span>',
//        'url'=>Yii::app()->createUrl('moderator/')
//    ),
//);
//
////echo "<pre>";
////print_r($model->orderSchedules);
////echo "</pre>";die;
//?>
<!--<div class="col-xs-4 col-md-12">-->
<!--    <div class="box ">-->
<!--        <div class="box-header">-->
<!--            <h3 class="box-title"><span class="text-capitalize">--><?php // echo $this->pageTitle?><!--</span></h3>-->
<!--            <div class="box-tools pull-right">-->
<!--                --><?php
//                $petition = Petition::model()->findAll();
//                if(!sizeof($petition)):
//                    ?>
<!--                    <div class="box-tools pull-right">-->
<!--                        <a href="--><?php //echo Yii::app()->createUrl("/moderator/petition/default/create")?><!--" class="btn  btn-primary">-->
<!--                            --><?php //echo Yii::t('main', 'Создать')?><!-- --><?php //echo Yii::t('main', 'Петицию')?>
<!--                        </a>-->
<!--                    </div>-->
<!--                --><?php //endif; ?>
<!--            </div>-->
<!--        </div>-->
<!--        <div class="box-body table-responsive no-padding ">-->
<!--            --><?php
//            $this->widget('zii.widgets.grid.CGridView', array(
//                'id' => 'petition-grid',
//                'dataProvider' => $model->search(),
//                'itemsCssClass' => 'table table-hover dataTable',
//                'cssFile' => false,
//                'filter' => $model,
//                'ajaxUpdate' => false,
//                'template' => '{items}<div class="pull-right">{pager}</div>',
//                'pager'=> array(
//                    'header' => '',
//                    'firstPageLabel' => false,
//                    'lastPageLabel'  => false,
//                    'prevPageLabel' => '&laquo; ',
//                    'nextPageLabel' => ' &raquo;',
//                    'maxButtonCount' => 4,
//                    'htmlOptions' => array(
//                        'class' => 'pagination',
//                        'style' => 'margin-right:30px;'
//                    ),
//                ),
//                'columns' => array(
//                    array(
//                        'type' => 'raw',
//                        'header' => ucfirst(Yii::t("main", "Название")),
//                        'value' => '$data->title'
//                    ),
//                    array(
//                        'type' => 'raw',
//                        'header' => 'Дата',
////                        'value' => '$data->date_create'
//                        'value' => 'DateHelper::convertTimeStamp($data->date_create, "H:i d-m-Y", true)'
//                    )
//                ),
//            ));
//            ?>
<!---->
<!--        </div>-->
<!---->
<!--    </div>-->
<!--</div>-->