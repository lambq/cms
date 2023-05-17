
<?php echo admin_section(Dcat\Admin\Admin::SECTION['NAVBAR_BEFORE']); ?>


<nav class="header-navbar navbar-expand-lg navbar
    navbar-with-menu <?php echo e($configData['navbar_class'], false); ?>

    <?php echo e($configData['navbar_color'], false); ?>

        navbar-light navbar-shadow " style="top: 0;">

    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <?php if(! $configData['horizontal_menu']): ?>
            <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav">
                    <li class="nav-item mr-auto">
                        <a class="nav-link menu-toggle" data-widget="pushmenu" style="cursor: pointer;">
                            <i class="fa fa-bars font-md-2"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <?php endif; ?>

            <div class="navbar-collapse d-flex justify-content-between">
                <div class="navbar-left d-flex align-items-center">
                    <?php echo Dcat\Admin\Admin::navbar()->render('left'); ?>

                </div>

                <?php if($configData['horizontal_menu']): ?>
                <div class="d-md-block horizontal-navbar-brand justify-content-center text-center">
                    <ul class="nav navbar-nav flex-row">
                        <li class="nav-item mr-auto">
                            <a href="<?php echo e(admin_url('/'), false); ?>" class="waves-effect waves-light">
                                <span class="logo-lg"><?php echo config('admin.logo'); ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <?php endif; ?>

                <div class="navbar-right d-flex align-items-center">
                    <?php echo Dcat\Admin\Admin::navbar()->render(); ?>


                    <ul class="nav navbar-nav">
                        
                        <?php echo admin_section(Dcat\Admin\Admin::SECTION['NAVBAR_USER_PANEL']); ?>


                        <?php echo admin_section(Dcat\Admin\Admin::SECTION['NAVBAR_AFTER_USER_PANEL']); ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<?php echo admin_section(Dcat\Admin\Admin::SECTION['NAVBAR_AFTER']); ?><?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/partials/navbar.blade.php ENDPATH**/ ?>