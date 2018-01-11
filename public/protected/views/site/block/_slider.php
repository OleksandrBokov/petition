<!-- Carousel -->
<div class="home-lead">
    <div id="myCarousel" class="carousel carousel-home slide">
        <div class="carousel-inner">
            <?php
            $h1 = Yii::t('main','все на спорт!');
            $h3 = Yii::t('main','тренировки, площадки и спорт-клубы');
            for ($i = 0; $i < 9; $i++):?>
                <?php $active = ($i == 0)? 'active': ''?>
                <div class="item <?=$active?>">
                    <img src="<?php echo Yii::app()->request->hostInfo?>/images/site/carousel/slider<?=$i+1?>.jpg">
                    <div class="container">
                        <div class="carousel-caption">
                            <h2 style="text-transform: uppercase;"><?=$h1?></h2>
                            <h3 style="text-transform: uppercase;"><?=$h3?></h3>
                        </div>
                    </div>
                </div>
            <?php endfor;?>
        </div>
    </div>
</div>
<!-- /Carousel -->

