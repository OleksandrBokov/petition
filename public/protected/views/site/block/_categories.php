<div class="change all-sports-tabs with-min-block">
    <button type="button" class="change-button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        <?php echo Yii::t('main','выбрать вид спорта')?>
    </button>
    <div class="collapse" id="collapseExample">
        <div class="all-sports-tabs">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#playground" aria-controls="playground" role="tab" data-toggle="tab">Площадки</a></li>
                <li role="presentation"><a href="#section" aria-controls="section" role="tab" data-toggle="tab">Занятия</a></li>
                <li role="presentation"><a href="#place" aria-controls="place" role="tab" data-toggle="tab">Клубы</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane tabs-list active" id="playground">
                    <?php
                    echo CHtml::openTag('div',['class'=>'col-xs-3','style'=>'text-align:left;']);
                    foreach ($model['playground'] as $k=>$v){
                        echo CHtml::link($v['title'], Yii::app()->createUrl('/playground/index',['Search[sport][id]'=>$v['id']]));
                        if($k != 0 && ($k % 1) == 0){
                            echo  CHtml::closeTag('div');
                            echo CHtml::openTag('div',['class'=>'col-xs-3', 'style'=>'text-align:left;']);
                        }
                    }
                    echo  CHtml::closeTag('div');
                    ?>
                </div>
                <div role="tabpanel" class="tab-pane tabs-list" id="section">
                    <?php
                    echo CHtml::openTag('div',['class'=>'col-xs-3', 'style'=>'text-align:left;']);

                    foreach ($model['section'] as $k=>$v){
                        echo CHtml::link($v['title'], Yii::app()->createUrl('/section/index',['Search[sport]'=>$v['url']]));
                        if($k != 0 && ($k % 1) == 0){
                            echo  CHtml::closeTag('div');
                            echo CHtml::openTag('div',['class'=>'col-xs-3', 'style'=>'text-align:left;']);
                        }
                    }
                    echo  CHtml::closeTag('div');
                    ?>
                </div>
                <div role="tabpanel" class="tab-pane tabs-list" id="place">
                    <?php
                    echo CHtml::openTag('div',['class'=>'col-xs-3', 'style'=>'text-align:left;']);
                    foreach ($model['place'] as $k=>$v){
                        echo CHtml::link($v['title'],  Yii::app()->createUrl('/place/index',['Search[sport][id]'=>$v['id']]));
                        if($k != 0 && ($k % 1) == 0){
                            echo  CHtml::closeTag('div');
                            echo CHtml::openTag('div',['class'=>'col-xs-3', 'style'=>'text-align:left;']);
                        }
                    }
                    echo  CHtml::closeTag('div');
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
