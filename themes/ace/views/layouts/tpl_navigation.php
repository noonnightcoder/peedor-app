<?php
    $this->pageTitle = Yii::app()->name;
    $baseUrl = Yii::app()->theme->baseUrl;
?>
<div id="navbar" class="navbar navbar-default">
    <script type="text/javascript">
            try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container">
            <!-- #section:basics/sidebar.mobile.toggle -->
            <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
                    <span class="sr-only">Toggle sidebar</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>
            </button>

            <!-- /section:basics/sidebar.mobile.toggle -->
            <div class="navbar-header pull-left">
                    <!-- #section:basics/navbar.layout.brand -->
                    <!--<img src="<?/*=$baseUrl.'/images/logo/piidor_logo.png'*/?>" height="45px">-->
                     <a href="#" class="navbar-brand">
                        <small>
                            <!--<img src="/images/peedor_logo.png" width="20px">-->
                            <i class="fa fa-free-code-camp red bolder"></i>
                            <?= bizNameFirstUpper() . ' Smart Inventory' ?>
                        </small>
                    </a>
                    <!-- /section:basics/navbar.layout.brand -->

            </div>

            <!-- #section:basics/navbar.dropdown -->
            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">
                        <li class="white">
                            <a href="<?php echo Yii::app()->createUrl('site/logout'); ?>">
                                <i class="ace-icon fa fa-power-off"></i>
                                <?= Yii::t('app','Logout'); ?>
                            </a>
                        </li>


                        <li class="green">
                            <a href="#"><?php echo Yii::app()->settings->get('site', 'companyName'); ?>
                                <i class="ace-icon fa fa-bell icon-animated-bell"></i>
                                <span class="label label-xlg label-important"><?php echo "Main Outlet"; //Yii::app()->getsetSession->getLocationName(); ?></span>
                            </a>
                        </li>
                        <li class="light-blue">
                            <a>
                                <i class="glyphicon glyphicon-time"></i>
                                <?= date("H:i j M Y"); ?>
                            </a>
                        </li>
                       
                        <li class="light-blue">
                                <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                    <!-- <img class="nav-user-photo" alt="Jasos Photo" src="<?php //echo Yii::app()->theme->baseUrl . '/avatars/user.jpg'; ?>" /> -->
                                    <span class="user-info">
                                            <small> <?= Yii::t('app','Welcome'); ?>,</small>
                                            <?php echo CHtml::encode(ucwords(Yii::app()->user->name)); ?>
                                    </span>
                                    <i class="ace-icon fa fa-caret-down"></i>
                                </a>

                                <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                    <!--
                                    <li>
                                        <a href="<?php //echo Yii::app()->urlManager->createUrl('Employee/View', array('id' => Yii::app()->session['employeeid'])); ?>">
                                                <i class="ace-icon fa fa-user"></i>
                                                Profile
                                        </a>
                                    </li>
                                    -->
                                    <li>
                                        <a href="<?php echo Yii::app()->urlManager->createUrl('RbacUser/Update', array('id' => Yii::app()->user->id)); ?>">
                                                <i class="ace-icon fa fa-key"></i>
                                                <?= Yii::t('app','Change Password'); ?>
                                        </a>
                                    </li>
                                </ul>
                        </li>

                            <!-- /section:basics/navbar.user_menu -->
                    </ul>
            </div>

            <!-- /section:basics/navbar.dropdown -->
    </div><!-- /.navbar-container -->
</div>