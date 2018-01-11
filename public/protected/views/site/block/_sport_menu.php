<ul class="entity-list">
    <li class="col-xs-3 "><a href="<?php echo Yii::app()->createUrl('/playground/index');?>"><?php echo Yii::t('main','n==1#площадки |n<=4#площадка |n>=10#площадок', 1)?></a></li>
    <li class="col-xs-3 "><a href="#section" ><?php echo Yii::t('main','n==1#секция |n<=4#секции |n>=10#секций', 4)?></a></li>
    <li class="col-xs-3 active"><a href="<?php echo Yii::app()->createUrl('/place/index');?>" ><?php echo Yii::t('main','n==1#клуб |n<=4#клуба |n<=10#клубов |n>=11#клубы', 12)?></a></li>
    <li class="col-xs-3"><a href="#developments"><?php echo Yii::t('main','n==1#событие|n==2#события', 2)?></a></li>
</ul>