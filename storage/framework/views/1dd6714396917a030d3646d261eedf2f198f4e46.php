<div class="<?php echo e($viewClass['form-group'], false); ?>">

    <label class="<?php echo e($viewClass['label'], false); ?> control-label"><?php echo $label; ?></label>

    <div class="<?php echo e($viewClass['field'], false); ?>">

        <?php echo $__env->make('admin::form.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <textarea class="form-control <?php echo e($class, false); ?>" name="<?php echo e($name, false); ?>" placeholder="<?php echo e($placeholder, false); ?>" <?php echo $attributes; ?> ><?php echo e($value, false); ?></textarea>

        <?php echo $__env->make('admin::form.help-block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
</div>

<script require="@tinymce" init="<?php echo $selector; ?>">
    var opts = <?php echo admin_javascript_json($options); ?>;

    opts.selector = '#'+id;

    if (! opts.init_instance_callback) {
        opts.init_instance_callback = function (editor) {
            editor.on('Change', function(e) {
                $this.val(String(e.target.getContent()).replace('<p><br data-mce-bogus="1"></p>', '').replace('<p><br></p>', ''));
            });
        }
    }

    tinymce.init(opts)
</script>
<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/form/editor.blade.php ENDPATH**/ ?>