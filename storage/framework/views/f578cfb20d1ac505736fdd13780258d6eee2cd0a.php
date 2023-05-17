<div class="input-group input-group-sm quick-form-field">
    <select class="form-control <?php echo e($class, false); ?>" style="width: 100%;" name="<?php echo e($name, false); ?>" <?php echo $attributes; ?> >

        <option value=""></option>
        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $select => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($select, false); ?>" <?php echo e(Dcat\Admin\Support\Helper::equal($select, old($column, $value)) ?'selected':'', false); ?>><?php echo e($option, false); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<?php echo $__env->make('admin::form.select-script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/grid/quick-create/select.blade.php ENDPATH**/ ?>