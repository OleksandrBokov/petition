<aside class="main-sidebar  max-width">
    <!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
        </div>
        <div class="pull-left info">
            <p><?php //echo Yii::app()->user->name?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <ul class="sidebar-menu">
        <?php
        $this->widget('application.extensions.widgets.mbmenu.SMenu', array('module'=>'user')); ?>
    </ul>
</section>
    <!-- /.sidebar -->
</aside>
