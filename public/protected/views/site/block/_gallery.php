
<div class="col-xs-9 description-club description-club-width">
    <div class="carousel-t">
        <div id="carousel-example-generic" class="carousel slide new-c" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner ">
                <?php
                    $active = true;
                    $photos = GalleryEntity::model()->getPhoto($model->id, 'all');

                    if ($photos){
                        foreach (GalleryEntity::model()->getPhoto($model->id, 'all') as $item){
                            $active = ($active) ? 'active':'';
                            echo CHtml::openTag('div',['class'=>"item {$active}"]);
                            echo CHtml::image(Yii::app()->request->hostInfo.$item['photo'],'',['style'=>'width:100%;']);
                            echo CHtml::closeTag('div');
                            $active = false;
                        }
                    }

                ?>
            </div>
            <!-- Controls -->
            <?php if(count($model->galleryEntities) > 1):?>
            <a class="left carousel-control carousel-l" href="#carousel-example-generic" data-slide="prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </a>
            <a class="right carousel-control carousel-l" href="#carousel-example-generic" data-slide="next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>
            <?php endif;?>
        </div>
        <!-- /carousel -->
    </div>
</div>
