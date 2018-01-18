<header>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container with-min-block">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo Yii::app()->createUrl('/')?>">
<!--                    <img  class="logo" src="--><?php //echo Yii::app()->request->hostInfo?><!--/images/site/naSPORTua-logo.png" alt="logo">-->
                </a>
            </div>
            <div class="menu-block" id="menu">
                <ul class="nav navbar-nav navbar-right">
                    <?php if(Yii::app()->user->isGuest): ?>
                        <li><a href="<?php echo Yii::app()->createUrl('/user/login')?>" class="add-object" ><?php echo Yii::t('main','Вход')?></a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('/user/registration')?>" class="add-object" ><?php echo Yii::t('main','Регистрация')?></a></li>

                    <?php else: ?>
                        <?php if(Yii::app()->user->role != User::ROLE_USER):?>
                        <li><a href="<?php echo Yii::app()->createUrl('/'.Yii::app()->user->role);?>" class="add-object" ><?php echo Yii::t('main','Кабинет');?></a></li>
                        <?php endif;?>
                        <li><a href="<?php echo Yii::app()->createUrl('/logout');?>" class="add-object" ><?php echo Yii::t('main','Выход');?></a></li>
                    <?php endif; ?>
<!--                    <li><a href="--><?php //echo Yii::app()->createUrl('/site/playground')?><!--" class="add-object" >--><?php ////echo Yii::t('main','Добавить объект')?><!--</a></li>-->

                    <?php
//                    $this->widget('application.extensions.widgets.room.PersonalArea', array(
//                        'items'=>array(
////                            array('label'=>'Мои заказы', 'url'=>'#', 'role'=>['user']),
////                            array('label'=>'Документы', 'url'=>'#', 'role'=>['user']),
////                            array('label'=>Yii::t('main','Профиль'), 'url'=>Yii::app()->createUrl('/user/profile'), 'role'=>['user']),
////                            array('label'=>'Мои оценки', 'url'=>'#', 'role'=>['user']),
//                            array('label'=>Yii::t('main','Кабинет'), 'url'=>Yii::app()->createUrl('/admin'), 'role'=>['administrator']),
//                            array('label'=>Yii::t('main','Кабинет'), 'url'=>Yii::app()->createUrl('/moderator'), 'role'=>['moderator']),
////                            array('label'=>Yii::t('main','Кабинет'), 'url'=>Yii::app()->createUrl('/user'), 'role'=>['user']),
////                            array('label'=>Yii::t('main','Кабинет'), 'url'=>Yii::app()->createUrl('/owner'), 'role'=>['moderator']),
//                            array('label'=>Yii::t('main','Выход'), 'url'=>Yii::app()->createUrl('/logout'), 'role'=>['user', 'moderator', 'manager', 'administrator']),
//                        )
//                    ));
                    //$this->widget('SLanguageSwitcherWidget');
                    ?>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>
    <?php
//    echo "<pre>";
//    var_dump(Yii::app()->user->role);
//    echo "</pre>";
    ?>
</header>