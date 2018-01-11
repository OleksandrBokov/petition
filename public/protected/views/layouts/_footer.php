<footer>
    <div class="container-fluid no-padding  footer-menu">
        <div class="container no-padding">
            <div class="row border-for-row">
                <div class="col-xs-5 logo-footer">
                    <img src="<?php echo Yii::app()->request->hostInfo?>/images/site/footer-logo.png" alt="">
                </div>
                <div class="col-xs-7 menu-list navbar-default">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">правила</a></li>
                        <li><a href="#">контакты</a></li>
                        <li><a href="#">о нас</a></li>
                    </ul>
                </div>
            </div>
            <div class="row contacts">
                <div class="col-xs-7">
                    <ul class="pull-left">
                        <li>
                            <a href="mailto:<?php //echo Yii::app()->config->get('siteEmail')?>">
									<span class="footer-icon">
										<i class="fa fa-envelope" aria-hidden="true"></i>
									</span>
                                <?php //echo Yii::app()->config->get('siteEmail')?>
                            </a>
                        </li>
                        <li>
                            <a href="tel:<?php //echo str_replace(' ','',Yii::app()->config->get('sitePhone'))?>">
									<span class="footer-icon">
										<i class="fa fa-phone" aria-hidden="true"></i>
									</span>
                                <?php //echo Yii::app()->config->get('sitePhone')?>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-5 footer-icons">
                    <ul class="pull-right mob-icons">
                        <li>
                            <a href="#">
                                <img src="<?php echo Yii::app()->request->hostInfo?>/images/site/vimeo-icon.png" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="<?php echo Yii::app()->request->hostInfo?>/images/site/facebook-icon.png" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="<?php echo Yii::app()->request->hostInfo?>/images/site/twitter-icon.png" alt="">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-lower">
            <div class="container no-padding">
                <div class="footer-lower-menu">
                    <div class="row">
                        <div class="col-xs-6">
                            <p class="text no-mb">Copyright &copy; 2017 <?php echo Yii::app()->name?></p>
                        </div>
                        <div class="col-xs-6">
                            <ul class="pull-right no-mb" style="text-transform: uppercase;">
                                <span class="icon-l pull-left"><img src="<?php echo Yii::app()->request->hostInfo?>/images/site/footer-icon.png" alt=""></span>
                                <?php  //$this->widget('SLanguageSwitcherWidget');?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer - end -->