<?php if(!empty($default) || !empty($custom)): ?>
<div class="grid-dropdown-actions dropdown">
    <a href="#" style="padding:0 10px;" data-toggle="dropdown">
        <i class="feather icon-more-vertical"></i>
    </a>
    <ul class="dropdown-menu" style="left: -65px;">

        <?php $__currentLoopData = $default; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="dropdown-item"><?php echo Dcat\Admin\Support\Helper::render($action); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if(!empty($custom)): ?>

            <?php if(!empty($default)): ?>
                <li class="dropdown-divider"></li>
            <?php endif; ?>

            <?php $__currentLoopData = $custom; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="dropdown-item"><?php echo $action; ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </ul>
</div>
<?php endif; ?><?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/grid/dropdown-actions.blade.php ENDPATH**/ ?>