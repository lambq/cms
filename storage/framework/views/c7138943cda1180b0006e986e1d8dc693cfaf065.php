<div style="margin-bottom: 10px"><?php echo e($value, false); ?></div>

<?php if($row->version && empty($row->new_version)): ?>
    <?php echo e(trans('admin.version').' '.$row->version, false); ?>


    <?php if($settingAction): ?>
        &nbsp;|&nbsp;
        <?php echo $settingAction; ?>

    <?php endif; ?>
<?php else: ?>
    <?php echo $updateAction; ?>


    <?php if($settingAction && $row->new_version): ?>
        &nbsp;|&nbsp;
        <?php echo $settingAction; ?>

    <?php endif; ?>
<?php endif; ?>
&nbsp;|&nbsp;

<a href="javascript:void(0)"><?php echo e(trans('admin.view'), false); ?></a><?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/grid/displayer/extensions/description.blade.php ENDPATH**/ ?>