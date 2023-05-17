<div class="<?php echo e($viewClass['form-group'], false); ?>">

    <label class="<?php echo e($viewClass['label'], false); ?> control-label"><?php echo $label; ?></label>

    <div class="<?php echo e($viewClass['field'], false); ?> <?php echo e($class, false); ?>">

        <?php echo $__env->make('admin::form.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="input-group" style="width:100%">
            <input <?php echo e($disabled, false); ?> type="hidden" class="hidden-input" name="<?php echo e($name, false); ?>" />

            <div class="jstree-wrapper">
                <div class="d-flex">
                    <?php echo $checkboxes; ?>

                </div>
                <div class="da-tree" style="margin-top:10px"></div>
            </div>
        </div>

        <?php echo $__env->make('admin::form.help-block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
</div>

<script require="@jstree" init="<?php echo $selector; ?>">
    var $tree = $this.find('.jstree-wrapper .da-tree'),
        $input = $this.find('.hidden-input'),
        opts = <?php echo admin_javascript_json($options); ?>,
        parents = <?php echo json_encode($parents); ?>;

    opts.core = opts.core || {};
    opts.core.data = <?php echo json_encode($nodes); ?>;

    $this.find('input[value=1]').on("click", function () {
        $(this).parents('.jstree-wrapper').find('.da-tree').jstree($(this).prop("checked") ? "check_all" : "uncheck_all");
    });
    $this.find('input[value=2]').on("click", function () {
        $(this).parents('.jstree-wrapper').find('.da-tree').jstree($(this).prop("checked") ? "open_all" : "close_all");
    });

    $tree.on("changed.jstree", function (e, data) {
        var i, selected = [];

        $input.val('');

        for (i in data.selected) {
            if (Dcat.helpers.inObject(parents, data.selected[i])) { // 过滤父节点
                continue;
            }
            selected.push(data.selected[i]);
        }

        selected.length && $input.val(selected.join(','));
    }).on("loaded.jstree", function () {
        <?php if($expand): ?> $(this).jstree('open_all'); <?php endif; ?>
    }).jstree(opts);
</script><?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/form/tree.blade.php ENDPATH**/ ?>