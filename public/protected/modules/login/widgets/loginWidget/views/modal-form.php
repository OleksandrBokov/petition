<li class="dropdown login"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Yii::t('main','Вход')?></a>
    <div class="login-form dropdown-menu">
        <ul id="myTab" class="nav nav-tabs come-in">
            <li class="active"><a href="#log-in" data-toggle="tab"><?php echo Yii::t('main','Вход')?></a></li>
            <li><a href="#sign-up" data-toggle="tab"><?php echo Yii::t('main','Регистрация')?></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">

            <div class="tab-pane active" id="log-in">

                <?php /*$this->widget('application.modules.login.widgets.eauth.EAuthWidget', array(
                    'action' => '/login/ajax',
                    'viewWidget'=>'application.modules.login.widgets.loginWidget.views.auth_social'
                ));*/?>
                <h2 class="line"><?php echo Yii::t('main','или')?></h2>

                <?php $this->render('application.modules.login.widgets.loginWidget.views._authorization', array('authForm' => $authForm));?>
            </div>

            <div class="tab-pane" id="sign-up">

                <?php /*$this->widget('application.modules.login.widgets.eauth.EAuthWidget', array(
                    'action' => '/login/ajax',
                    'viewWidget'=>'application.modules.login.widgets.loginWidget.views.auth_social'
                ));*/?>
                <h2 class="line"><?php echo Yii::t('main','или')?></h2>
                <?php $this->render('application.modules.login.widgets.loginWidget.views._registration', array('model' => $model));?>
            </div>

        </div>
    </div>
</li>