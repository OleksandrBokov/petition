<?php
$this->breadcrumbs = array(
    array(
        'label'=>'<span class="text-capitalize">'.$this->pageTitle.'</span>',
        'url'=>Yii::app()->createUrl('moderator/petition/answer')
    ),
);
?>

<div class="box-body table-responsive no-padding">

    <div class="box ">
        <div class="box-header">
            <h3 class="box-title"><span class="text-capitalize"><?=$this->pageTitle?></span></h3>
            <?php
            $answer = PetitionAnswer::model()->findAll();
            if(!sizeof($answer)):
                ?>
                <div class="box-tools pull-right">
                    <a href="<?php echo Yii::app()->createUrl("/moderator/petition/answer/create");?>" class="btn  btn-primary">
                        <?php echo Yii::t('main', 'Создать')?> <?php echo Yii::t('main', 'Ответ');?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <div class="box-body table-responsive " style="padding-left: 30px; padding-right: 30px">
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'answer-grid',
                'dataProvider' => $model->search(),
                'itemsCssClass' => 'table table-hover dataTable',
                'cssFile' => false,
                //'filter' => $model,
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
                        'header' => ucfirst(Yii::t("main", "Петиция")),
                        'value' => '$data->petition->title'
                    ),
                    array(
                        'type' => 'raw',
                        'header' => 'Дата',
//                        'value' => '$data->date_create'
                        'value' => 'DateHelper::convertTimeStamp($data->date_create, "H:i d-m-Y")'
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'template'=>'{s_delete}',
                        'buttons'=>array(
                            's_delete'=>array(
                                'label'=>'<i class="fa fa-trash-o" ></i>',
                                'url'=>'Yii::app()->controller->createUrl("delete",array("id"=>$data->id))',
                                'options' => array(
                                    'rel' => 'tooltip',
                                    'data-toggle' => 'tooltip',
                                    'title'  => Yii::t('main','удалить'),
                                    'style'=>'margin-right:10px;'
                                ),
                                'click' => '
                                    function(){
                                        if(confirm("Дійсно видалити?"))
                                            return true;
                                        else
                                            return false;
                                    }
                                ',
                            ),
                        )

                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>
