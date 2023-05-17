<div class="<?php echo e($configData['horizontal_menu'] ? 'header-navbar navbar-expand-sm navbar navbar-horizontal' : 'main-menu', false); ?>">
    <div class="main-menu-content">
        <aside class="<?php echo e($configData['horizontal_menu'] ? 'main-horizontal-sidebar' : 'main-sidebar shadow', false); ?> <?php echo e($configData['sidebar_style'], false); ?>">

            <?php if(! $configData['horizontal_menu']): ?>
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mr-auto">
                        <a href="<?php echo e(admin_url('/'), false); ?>" class="navbar-brand waves-effect waves-light">
                            <span class="logo-mini"><?php echo config('admin.logo-mini'); ?></span>
                            <span class="logo-lg"><?php echo config('admin.logo'); ?></span>
                        </a>
                    </li>
                </ul>
            </div>
            <?php endif; ?>

            <div class="p-0 <?php echo e($configData['horizontal_menu'] ? 'pl-1 pr-1' : 'sidebar pb-3', false); ?>">
                <ul class="nav nav-pills nav-sidebar <?php echo e($configData['horizontal_menu'] ? '' : 'flex-column', false); ?>"
                    <?php echo $configData['horizontal_menu'] ? '' : 'data-widget="treeview"'; ?>

                     style="padding-top: 10px">
                    <?php echo admin_section(Dcat\Admin\Admin::SECTION['LEFT_SIDEBAR_MENU_TOP']); ?>


                    <?php echo admin_section(Dcat\Admin\Admin::SECTION['LEFT_SIDEBAR_MENU']); ?>


                    <?php echo admin_section(Dcat\Admin\Admin::SECTION['LEFT_SIDEBAR_MENU_BOTTOM']); ?>

                </ul>
            </div>
        </aside>
    </div>
</div><?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/partials/sidebar.blade.php ENDPATH**/ ?>