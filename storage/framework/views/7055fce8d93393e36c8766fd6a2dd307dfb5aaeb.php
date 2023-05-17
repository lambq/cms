<?php echo $start; ?>

    <div class="box-body fields-group pl-0 pr-0 pt-1" style="padding: 0 0 .5rem">
        <?php if(! $tabObj->isEmpty()): ?>
            <?php echo $__env->make('admin::form.tab', compact('tabObj'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($field instanceof \Dcat\Admin\Form\Field\Hidden): ?>
                    <?php echo $field->render(); ?>

                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <?php echo $__env->make('admin::form.fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </div>

    <?php echo $footer; ?>

<?php echo $end; ?>

<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/widgets/form.blade.php ENDPATH**/ ?>