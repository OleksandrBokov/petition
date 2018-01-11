<!-- offers-list - begin-->
<div class="container-fluid offers-list no-padding">
    <div class="offers-block">
        <a href="<?php echo Yii::app()->createUrl('/playground/index')?>" class="item-block">
            <div class="icon-block">
                <img  src="<?php echo Yii::app()->request->hostInfo?>/images/site/categories-1.png" alt="">
            </div>
            <p class="title"><?php echo Yii::t('main','аренда площадок')?></p>
            <p class="detail-text">
                <?php echo Yii::t('main','Бронируйте и арендуйте площадки {alias} для спортивных игр и занятий',['{alias}'=>'<br>'])?>
            </p>
        </a>
        <a href="<?php echo Yii::app()->createUrl('/section/index')?>" class="item-block">
            <div class="icon-block">
                <img  src="<?php echo Yii::app()->request->hostInfo?>/images/site/categories-2.png" alt="">
            </div>
            <p class="title"><?php echo Yii::t('main','спортивные занятия')?></p>
            <p class="detail-text">
                <?php echo Yii::t('main','Для детей и взрослых спортивные {alias} занятия, тренировки и секции',['{alias}'=>'<br>'])?>
            </p>
        </a>
        <a href="<?php echo Yii::app()->createUrl('/place/index')?>" class="item-block">
            <div class="icon-block">
                <img  src="<?php echo Yii::app()->request->hostInfo?>/images/site/categories-3.png" alt="">
            </div>
            <p class="title"><?php echo Yii::t('main','спортивные клубы')?></p>
            <p class="detail-text">
                <?php echo Yii::t('main','Найди свой клуб, {alias} школу танцев, студии йоги и пр.',['{alias}'=>'<br>'])?>
            </p>
        </a>
    </div>
</div>
<!-- offers-list - end-->