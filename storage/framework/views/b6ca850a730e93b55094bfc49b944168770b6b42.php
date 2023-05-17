
<?php echo $__env->make('admin::scripts.select', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script require="@select2?lang=<?php echo e(config('app.locale') === 'en' ? '' : str_replace('_', '-', config('app.locale')), false); ?>" init="<?php echo $selector; ?>">
    var configs = <?php echo admin_javascript_json($configs); ?>;

    <?php echo $__env->yieldContent('admin.select-ajax'); ?>

    <?php if(isset($remoteOptions)): ?>
    $.ajax(<?php echo admin_javascript_json($remoteOptions); ?>).done(function(data) {
        configs.data = data;

        $this.each(function (_, select) {
            select = $(select);

            select.select2(configs);

            var value = select.data('value') + '';

            if (value) {
                select.val(value.split(',')).trigger("change")
            }
        });
    });
    <?php else: ?>
    $this.select2(configs);
    <?php endif; ?>

    <?php echo $cascadeScript; ?>

</script>

<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/form/select-script.blade.php ENDPATH**/ ?>