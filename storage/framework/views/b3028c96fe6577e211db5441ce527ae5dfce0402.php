<li class="dd-item <?php echo $expand ? '' : 'dd-collapsed'; ?>" data-id="<?php echo e($branch[$keyName], false); ?>">
    <div class="dd-handle">
        <?php echo $branchCallback($branch); ?>

        <span class="pull-right dd-nodrag">
            <?php echo $resolveAction($branch); ?>

        </span>
    </div>
    <?php if(isset($branch['children'])): ?>
    <ol class="dd-list">
        <?php $__currentLoopData = $branch['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make($branchView, $branch, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>
    <?php endif; ?>
</li>
<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/tree/branch.blade.php ENDPATH**/ ?>