<h3 class="box-title"><span class="text-capitalize"><?=$this->pageTitle?></span></h3>
<div class="box-tools pull-right">
    <?php
    echo CHtml::openTag('a',['href'=>$this->prevPage,'class'=>'btn btn-sm btn-default btn-nav text-capitalize']);
    echo CHtml::openTag('span',['class'=>'glyphicon glyphicon-arrow-left btn-span ']).CHtml::closeTag('span');
    echo Yii::t('main','назад');
    echo CHtml::closeTag('a');

    echo CHtml::openTag('button',['type'=>'submit','class'=>'btn btn-sm btn-default btn-nav text-capitalize']);
    echo CHtml::openTag('span',['class'=>'glyphicon  glyphicon-ok-circle btn-span ']).CHtml::closeTag('span');
    echo Yii::t('main','сохранить');
    echo CHtml::closeTag('button');

    if(!$model->isNewRecord){
        echo CHtml::openTag('a',[
            'class'=>'btn btn-sm btn-default btn-nav',
            'onclick'=>'(function(e) {
            if(confirm("'.Yii::t('main', 'Удалить').' ?")){
                $.ajax({
                        "url": "'.Yii::app()->controller->createUrl("delete",array("id"=>$model->primaryKey)).'",
                        "type": "POST",
                        "dataType": "json",
                        "success": function(data){ 
                            //window.location.href = data.url
                            console.log(data);
                            }
                    });
                }
            })();',
        ]);
        echo CHtml::openTag('span',['class'=>'glyphicon glyphicon-trash btn-span']).CHtml::closeTag('span');
        echo Yii::t('main','Удалить');
        echo CHtml::closeTag('a');
    }
    ?>
</div>