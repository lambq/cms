<?php if(! $isHoldSelectAllCheckbox): ?>
<div class="btn-group dropdown  <?php echo e($selectAllName, false); ?>-btn" style="display:none;margin-right: 3px;z-index: 100">
    <button type="button" class="btn btn-white dropdown-toggle btn-mini" data-toggle="dropdown">
        <span class="d-none d-sm-inline selected"></span>
        <span class="caret"></span>
        <span class="sr-only"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($action instanceof Dcat\Admin\Grid\Tools\ActionDivider): ?>
                <li class="dropdown-divider"></li>
            <?php else: ?>
                <li class="dropdown-item">
                    <?php echo $action->render(); ?>

                </li>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>

<script>
Dcat.init('.<?php echo e($parent->getRowName(), false); ?>-checkbox', function ($this) {
    $this.on('change', function () {
        var btn = $('.<?php echo e($selectAllName, false); ?>-btn'), selected = Dcat.grid.selectedRows('<?php echo e($parent->getName(), false); ?>').length;

        if (selected) {
            btn.show()
        } else {
            btn.hide()
        }
        setTimeout(function () {
            btn.find('.selected').html("<?php echo trans('admin.grid_items_selected'); ?>".replace('{n}', selected));
        }, 50)
    })
})
</script>
<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/grid/batch-actions.blade.php ENDPATH**/ ?>