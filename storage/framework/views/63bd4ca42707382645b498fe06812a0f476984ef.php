
<div class="dcat-box">

    <div class="d-block pb-0">
        <?php echo $__env->make('admin::grid.table-toolbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <?php echo $grid->renderFilter(); ?>


    <?php echo $grid->renderHeader(); ?>


    <div class="<?php echo $grid->formatTableParentClass(); ?>">
        <table class="<?php echo e($grid->formatTableClass(), false); ?>" id="<?php echo e($tableId, false); ?>" >
            <thead>
            <?php if($headers = $grid->getVisibleComplexHeaders()): ?>
                <tr>
                    <?php $__currentLoopData = $headers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $header): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $header->render(); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            <?php endif; ?>
            <tr>
                <?php $__currentLoopData = $grid->getVisibleColumns(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th <?php echo $column->formatTitleAttributes(); ?>><?php echo $column->getLabel(); ?><?php echo $column->renderHeader(); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            </thead>

            <?php if($grid->hasQuickCreate()): ?>
                <?php echo $grid->renderQuickCreate(); ?>

            <?php endif; ?>

            <tbody>
            <?php $__currentLoopData = $grid->rows(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr <?php echo $row->rowAttributes(); ?>>
                    <?php $__currentLoopData = $grid->getVisibleColumnNames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td <?php echo $row->columnAttributes($name); ?>><?php echo $row->column($name); ?></td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($grid->rows()->isEmpty()): ?>
                <tr>
                    <td colspan="<?php echo count($grid->getVisibleColumnNames()); ?>">
                        <div style="margin:5px 0 0 10px;"><span class="help-block" style="margin-bottom:0"><i class="feather icon-alert-circle"></i>&nbsp;<?php echo e(trans('admin.no_data'), false); ?></span></div>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php echo $grid->renderFooter(); ?>


    <?php echo $grid->renderPagination(); ?>


</div>
<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/grid/table.blade.php ENDPATH**/ ?>