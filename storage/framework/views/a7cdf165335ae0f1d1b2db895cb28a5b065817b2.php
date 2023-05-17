<?php
    $depth = $item['depth'] ?? 0;

    $horizontal = config('admin.layout.horizontal_menu');

    $defaultIcon = config('admin.menu.default_icon', 'feather icon-circle');
?>

<?php if($builder->visible($item)): ?>
    <?php if(empty($item['children'])): ?>
        <li class="nav-item">
            <a data-id="<?php echo e($item['id'] ?? '', false); ?>" <?php if(mb_strpos($item['uri'], '://') !== false): ?> target="_blank" <?php endif; ?>
               href="<?php echo e($builder->getUrl($item['uri']), false); ?>"
               class="nav-link <?php echo $builder->isActive($item) ? 'active' : ''; ?>">
                <?php echo str_repeat('&nbsp;', $depth); ?><i class="fa fa-fw <?php echo e($item['icon'] ?: $defaultIcon, false); ?>"></i>
                <p>
                    <?php echo $builder->translate($item['title']); ?>

                </p>
            </a>
        </li>
    <?php else: ?>

        <li class="<?php echo e($horizontal ? 'dropdown' : 'has-treeview', false); ?> <?php echo e($depth > 0 ? 'dropdown-submenu' : '', false); ?> nav-item <?php echo e($builder->isActive($item) ? 'menu-open' : '', false); ?>">
            <a href="#"  data-id="<?php echo e($item['id'] ?? '', false); ?>"
               class="nav-link <?php echo e($builder->isActive($item) ? ($horizontal ? 'active' : '') : '', false); ?>

                    <?php echo e($horizontal ? 'dropdown-toggle' : '', false); ?>">
                <?php echo str_repeat('&nbsp;', $depth); ?><i class="fa fa-fw <?php echo e($item['icon'] ?: $defaultIcon, false); ?>"></i>
                <p>
                    <?php echo $builder->translate($item['title']); ?>


                    <?php if(! $horizontal): ?>
                        <i class="right fa fa-angle-left"></i>
                    <?php endif; ?>
                </p>
            </a>
            <ul class="nav <?php echo e($horizontal ? 'dropdown-menu' : 'nav-treeview', false); ?>">
                <?php $__currentLoopData = $item['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $item['depth'] = $depth + 1;
                    ?>

                    <?php echo $__env->make('admin::partials.menu', ['item' => $item], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </li>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/partials/menu.blade.php ENDPATH**/ ?>