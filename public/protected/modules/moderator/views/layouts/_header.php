<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo Yii::app()->createUrl('/moderator')?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>N</b>S</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b><?php echo Yii::app()->name?></b> </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li><a href="<?php echo Yii::app()->createUrl('/')?>"><?php echo Yii::t('main', 'На главную')?></a></li>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                        <?php
                        $model = User::model()->findByPk(Yii::app()->user->id);
                        ?>
                        <span class="hidden-xs"><?php echo Yii::app()->user->name?></span>
                    </a>
                    <ul class="dropdown-menu" style="width: auto;">
                        <li>
                            <a href="<?php echo Yii::app()->createUrl('/logout')?>">
                                <i class="fa fa-sign-out"></i>
                                <?php echo Yii::t('main','Выйти')?>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>