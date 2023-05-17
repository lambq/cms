<div class="<?php echo e($viewClass['form-group'], false); ?>">

    <label class="<?php echo e($viewClass['label'], false); ?> control-label"><?php echo $label; ?></label>

    <div class="<?php echo e($viewClass['field'], false); ?>">

        <?php echo $__env->make('admin::form.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <select class="form-control <?php echo e($class, false); ?>" style="width: 100%;" name="<?php echo e($name, false); ?>[]" multiple="multiple" data-placeholder="<?php echo e($placeholder, false); ?>" <?php echo $attributes; ?> >
            <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($keyAsValue ? $key : $option, false); ?>" <?php echo e(in_array($option, $value) ? 'selected' : '', false); ?>><?php echo e($option, false); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <input type="hidden" name="<?php echo e($name, false); ?>[]" />

        <?php echo $__env->make('admin::form.help-block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
</div>

<script init="<?php echo $selector; ?>" require="@select2?lang=<?php echo e(config('app.locale') === 'en' ? '' : str_replace('_', '-', config('app.locale')), false); ?>">
    var options = {
        tags: true,
        createTag: function(params) {
            if (/[,;，； ]/.test(params.term)) {
                var str = params.term.trim().replace(/[,;，；]*$/, '');
                return { id: str, text: str }
            } else {
                return null;
            }
        }
    };

    <?php if(isset($ajax)): ?>
    options = $.extend(options, {
        ajax: {
            url: "<?php echo $ajax['url']; ?>",
            dataType: 'json',
            delay: 250,
            cache: true,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: $.map(data.data, function (d) {
                        d.id = d.<?php echo e($ajax['idField'], false); ?>;
                        d.text = d.<?php echo e($ajax['textField'], false); ?>;
                        return d;
                    }),
                    pagination: {
                        more: data.next_page_url
                    }
                };
            },
        },
        escapeMarkup: function (markup) {
            return markup;
        },
    });
    <?php endif; ?>

    $this.select2(options);
</script>


<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/form/tags.blade.php ENDPATH**/ ?>