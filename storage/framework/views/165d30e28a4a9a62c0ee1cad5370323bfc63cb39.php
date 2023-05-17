<div class="<?php echo e($viewClass['form-group'], false); ?>" style="margin-top: .3rem">
    <label class="<?php echo e($viewClass['label'], false); ?> control-label"><?php echo $label; ?></label>
    <div class="<?php echo e($viewClass['field'], false); ?>">
        <div class="box box-solid box-default no-margin">
            <div class="box-body">
                <div class="<?php echo e($class, false); ?>"><?php echo $value; ?>&nbsp;</div>
            </div>
        </div>

        <?php echo $__env->make('admin::form.help-block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
</div>
<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/form/display.blade.php ENDPATH**/ ?>