<div class="<?php echo e($viewClass['form-group'], false); ?>">

    <label class="<?php echo e($viewClass['label'], false); ?> control-label"><?php echo $label; ?></label>

    <div class="<?php echo e($viewClass['field'], false); ?>">

        <?php echo $__env->make('admin::form.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <input name="<?php echo e($name, false); ?>" type="hidden" value="0" />
        <input type="checkbox" name="<?php echo e($name, false); ?>" class="<?php echo e($class, false); ?>" <?php echo e($value == 1 ? 'checked' : '', false); ?> <?php echo $attributes; ?> />

        <?php echo $__env->make('admin::form.help-block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
</div>

<script require="@switchery" init="<?php echo $selector; ?>">
    $this.parent().find('.switchery').remove();

    $this.each(function() {
        new Switchery($(this)[0], $(this).data())
    })
</script>
<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/form/switchfield.blade.php ENDPATH**/ ?>