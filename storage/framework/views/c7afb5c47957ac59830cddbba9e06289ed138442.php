<div class="card-header pb-1 with-border" style="padding:.9rem 1rem">

    <div>
        <div class="btn-group" style="margin-right:3px">
            <button class="btn btn-primary btn-sm <?php echo e($id, false); ?>-tree-tools" data-action="expand">
                <i class="feather icon-plus-square"></i>&nbsp;<span class="d-none d-sm-inline"><?php echo e(trans('admin.expand'), false); ?></span>
            </button>
            <button class="btn btn-primary btn-sm <?php echo e($id, false); ?>-tree-tools" data-action="collapse">
                <i class="feather icon-minus-square"></i><span class="d-none d-sm-inline">&nbsp;<?php echo e(trans('admin.collapse'), false); ?></span>
            </button>
        </div>

        <?php if($useSave): ?>
            &nbsp;<div class="btn-group" style="margin-right:3px">
                <button class="btn btn-primary btn-sm <?php echo e($id, false); ?>-save" ><i class="feather icon-save"></i><span class="d-none d-sm-inline">&nbsp;<?php echo e(trans('admin.save'), false); ?></span></button>
            </div>
        <?php endif; ?>

        <?php if($useRefresh): ?>
            &nbsp;<div class="btn-group" style="margin-right:3px">
                <button class="btn btn-outline-primary btn-sm" data-action="refresh" ><i class="feather icon-refresh-cw"></i><span class="d-none d-sm-inline">&nbsp;<?php echo e(trans('admin.refresh'), false); ?></span></button>
            </div>
        <?php endif; ?>

        <?php if($tools): ?>
            &nbsp;<div class="btn-group" style="margin-right:3px">
                <?php echo $tools; ?>

            </div>
        <?php endif; ?>
    </div>

    <div>
        <?php echo $createButton; ?>

    </div>

</div>

<div class="card-body table-responsive">
    <div class="dd" id="<?php echo e($id, false); ?>">
        <ol class="dd-list">
            <?php if($items): ?>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make($branchView, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <span class="help-block" style="margin-bottom:0"><i class="feather icon-alert-circle"></i>&nbsp;<?php echo e(trans('admin.no_data'), false); ?></span>
            <?php endif; ?>
        </ol>
    </div>
</div>

<script require="@jquery.nestable">
    var id = '<?php echo e($id, false); ?>';
    var tree = $('#'+id);

    tree.nestable(<?php echo admin_javascript_json($nestableOptions); ?>);

    $('.'+id+'-save').on('click', function () {
        var serialize = tree.nestable('serialize'), _this = $(this);
        _this.buttonLoading();
        $.post({
            url: '<?php echo e($url, false); ?>',
            data: {
                '<?php echo e(\Dcat\Admin\Tree::SAVE_ORDER_NAME, false); ?>': JSON.stringify(serialize)
            },
            success: function (data) {
                _this.buttonLoading(false);

                Dcat.handleJsonResponse(data)
            }
        });
    });

    $('.'+id+'-tree-tools').on('click', function(e){
        var action = $(this).data('action');
        if (action === 'expand') {
            tree.nestable('expandAll');
        }
        if (action === 'collapse') {
            tree.nestable('collapseAll');
        }
    });

    <?php if(! $expand): ?>
    tree.nestable('collapseAll')
    <?php endif; ?>
</script>
<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/tree/container.blade.php ENDPATH**/ ?>