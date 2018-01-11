<?php if($model): ?>
<div class="container-fluid grey-block">
    <div class="with-min-block">
        <p class="title-name"><?php echo Yii::t('main','новые предложения')?></p>
        <div class="new-offers">
            <div class="row">
                <?php foreach ($model as $item):?>

                <?php if(!empty($item['photo'])): ?>
                    <div class="col-xs-4 new-offers-block">
                        <a href="<?php echo Yii::app()->createUrl($item['type_url'].'/'.$item['id'])?>">
                            <div class="new-offers-img">
                                <img src="<?php echo Yii::app()->request->hostInfo.$item['photo']?>" alt="">
                            </div>
                            <div class="new-offers-detail">
                                <h4><?=$item['name']?></h4>
                            </div>
                        </a>
                    </div>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
<!-- new-offers - end -->
<?php endif;?>