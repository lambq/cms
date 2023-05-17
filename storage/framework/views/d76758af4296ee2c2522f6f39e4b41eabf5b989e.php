<script>
<?php $__env->startSection('admin.select-ajax'); ?>
    <?php if(isset($ajax)): ?>
        configs = $.extend(configs, {
        ajax: {
            url: "<?php echo e($ajax['url'], false); ?>",
            dataType: 'json',
            delay: 250,
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
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }
    });
    <?php endif; ?>
<?php $__env->stopSection(true); ?>
</script>


<?php if(isset($loads)): ?>

<script once>
    var selector = '<?php echo $selector; ?>';

    var fields = '<?php echo $loads['fields']; ?>'.split('^');
    var urls = '<?php echo $loads['urls']; ?>'.split('^');

    $(document).off('change', selector);
    $(document).on('change', selector, function () {
        Dcat.helpers.loadFields(this, {
            group: '<?php echo e($loads['group'] ?? '.fields-group', false); ?>',
            urls: urls,
            fields: fields,
            textField: "<?php echo e($loads['textField'], false); ?>",
            idField: "<?php echo e($loads['idField'], false); ?>",
        });
    });
    $(selector).trigger('change');
</script>
<?php endif; ?>

<script once>
    // on first focus (bubbles up to document), open the menu
    $(document).off('focus', '.select2-selection.select2-selection--single')
        .on('focus', '.select2-selection.select2-selection--single', function (e) {
            $(this).closest(".select2-container").siblings('select:enabled').select2('open');
        });

    // steal focus during close - only capture once and stop propogation
    $(document).off('select2:closing', 'select.select2')
        .on('select2:closing', 'select.select2', function (e) {
            $(e.target).data("select2").$selection.one('focus focusin', function (e) {
                e.stopPropagation();
            });
        });
</script>
<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/scripts/select.blade.php ENDPATH**/ ?>