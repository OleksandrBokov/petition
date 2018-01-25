<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'user-grid',
    'itemsCssClass' => 'table table-hover dataTable text-center text-lowercase',
    'template' => '{items}<div class="pull-right">{pager}</div>',
    'ajaxUpdate'=>false,
    'pager'=> array(
        'header' => '',
        'firstPageLabel' => false,
        'lastPageLabel'  => false,
        'prevPageLabel' => '&laquo; ',
        'nextPageLabel' => ' &raquo;',
        'maxButtonCount' => 4,
        'htmlOptions' => array(
            'class' => 'pagination'
        ),
    ),
    'rowCssClassExpression' => '( $data->status == 2 ) ? "row-warning" : "" ',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array(
            'name'=>'email',
            'type'=>'html',
            'value'=>'CHtml::link($data->email,"mailto:".$data->email)'
        ),
        array(
            'name'=>'lastName',
            'type'=>'raw',
            'value'=>'($data->lastName) ? $data->lastName : "---"'
        ),
        array(
            'name'=>'firstName',
            'type'=>'raw',
            'value'=>'($data->firstName) ? $data->firstName : "---"'
        ),
        
        array(
            'name'=>'status',
            'type'=>'raw',
            'value'=>'Yii::t("app","n==0#not_authorized|n==1#authorized|n==2#blocked",$data->status)',
            'filter'=>CHtml::activeDropDownList($model,'status',array(
                User::STATUS_AUTHORIZED=>Yii::t("app","n==0#not_authorized|n==1#authorized|n==2#blocked", User::STATUS_AUTHORIZED),
                User::STATUS_BLOCKED=>Yii::t("app","n==0#not_authorized|n==1#authorized|n==2#blocked",User::STATUS_BLOCKED),
            ), array('empty'=>' ---- '))
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{m_edit}{m_delete}',
            'buttons'=>array(
                'm_edit'=>array(
                    'label'=>'<i class="fa fa-pencil " ></i>',
                    'url'=>'Yii::app()->controller->createUrl("update",array("id"=>$data->id))',
                    'options' => array(
                        'rel' => 'tooltip',
                        'data-toggle' => 'tooltip',
                        'title'  => Yii::t('app','edit'),
                        'style'=>'margin-right:10px;'
                    ),
                ),
                'm_delete'=>array(
                    'label'=>'<i class="fa fa-trash-o" ></i>',
                    'imageUrl'=>false,
                    'options' => array(
                        'rel' => 'tooltip',
                        'data-toggle' => 'tooltip',
                        'title'       => Yii::t('app','delete'),
                    ),
                    'click'=>"function(){
                        if(confirm('".Yii::t('app','delete this element')." ?')){
                            var link = $(this);
                            $.ajax({
                                type:'POST',
                                url:$(this).attr('href'),
                                success:function(data) {
                                console.log(data)
                                    var row = link.parent().parent();
                                    row.fadeOut('slow');
                                }
                            })
                        }
                        return false;
                        }",
                    'url'=>'Yii::app()->controller->createUrl("delete",array("id"=>$data->primaryKey))',
                )
            )
        ),
    ),
)); //, #datepicker_to_date

?>
<div class="box-footer">

    <div class="input-group ">
        <?php
        echo CHtml::dropDownList('userToPage', $model->search()->pagination->pageSize ,array(1=>1, 5=>5, 10=>10, 15=>15, 25=>25, 30=>30, 50=>50),array(
            'onchange'=>" $.fn.yiiGridView.update('user-grid',{ data:{userToPage: $(this).val() }})",
            'class'=>'result-per-page ','style'=>'margin-right:5px;margin-top:10px;'
        ));
        ?>
        <label class="control-label"> <?=Yii::t('app','Elements per page')?> </label>

    </div>
</div>
