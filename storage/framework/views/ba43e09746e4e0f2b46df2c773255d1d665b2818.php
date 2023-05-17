<div class="hidden">
    <div class="filter-box right-side-filter-container" style="<?php echo $style; ?>"  id="<?php echo e($filterID, false); ?>">
        <form action="<?php echo $action; ?>" class="form-horizontal grid-filter-form" pjax-container method="get">
            <div class="mb-1" style="height: 55px">
                <div class="p-1 position-fixed d-flex justify-content-between header">
                    <div>
                        <button type="submit" class=" btn btn-sm btn-primary submit">
                            <i class="feather icon-search"></i> &nbsp;<?php echo e(__('admin.search'), false); ?>

                        </button>&nbsp;
                        <?php if(!$disableResetButton): ?>
                            <a href="<?php echo $action; ?>" class="reset btn btn-sm btn-white">
                                <i class="feather icon-rotate-ccw"></i> &nbsp;<?php echo e(__('admin.reset'), false); ?>

                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php $__currentLoopData = $layout->columns(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $column->filters(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $filter->render(); ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </form>
    </div>
</div>
<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/filter/right-side-container.blade.php ENDPATH**/ ?>