<thead>
<tr class="<?php echo e($elementClass, false); ?> quick-create" style="cursor: pointer">
    <td colspan="<?php echo e($columnCount, false); ?>" style="background: <?php echo e(Dcat\Admin\Admin::color()->darken('#ededed', 1), false); ?>">
        <span class="create cursor-pointer" style="display: block;">
             <i class="feather icon-plus"></i>&nbsp;<?php echo e(__('admin.quick_create'), false); ?>

        </span>

        <form class="form-inline create-form" style="display: none;" method="post">
            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                &nbsp;<?php echo $field->render(); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                &nbsp;
            &nbsp;
            <button type="submit" class="btn btn-primary btn-sm"><?php echo e(__('admin.submit'), false); ?></button>&nbsp;
            &nbsp;
            <a href="javascript:void(0);" class="cancel"><?php echo e(__('admin.cancel'), false); ?></a>
        </form>
    </td>
</tr>
</thead>

<script>
    var ctr = $('.<?php echo $elementClass; ?>'),
        btn = $('.quick-create-button-<?php echo $uniqueName; ?>');

    btn.on('click', function () {
        ctr.toggle().click();
    });

    ctr.on('click', function () {
        ctr.find('.create-form').show();
        ctr.find('.create').hide();
    });

    ctr.find('.cancel').on('click', function () {
        if (btn.length) {
            ctr.hide();
            return;
        }

        ctr.find('.create-form').hide();
        ctr.find('.create').show();
        return false;
    });

    ctr.find('.create-form').submit(function (e) {
        e.preventDefault();

        if (ctr.attr('submitting')) {
            return;
        }

        var btn = $(this).find(':submit').buttonLoading();

        ctr.attr('submitting', 1);

        $.ajax({
            url: '<?php echo $url; ?>',
            type: '<?php echo $method; ?>',
            data: $(this).serialize(),
            success: function(data) {
                ctr.attr('submitting', '');
                btn.buttonLoading(false);

                Dcat.handleJsonResponse(data);
            },
            error:function(xhq){
                btn.buttonLoading(false);
                ctr.attr('submitting', '');
                var json = xhq.responseJSON;
                if (typeof json === 'object') {
                    if (json.message) {
                        Dcat.error(json.message);
                    } else if (json.errors) {
                        var i, errors = [];
                        for (i in json.errors) {
                            errors.push(json.errors[i].join("<br>"));
                        }

                        Dcat.error(errors.join("<br>"));
                    }
                }
            }
        });

        return false;
    });
</script><?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/grid/quick-create/form.blade.php ENDPATH**/ ?>