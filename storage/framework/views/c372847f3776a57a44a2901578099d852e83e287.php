<div class="d-flex">
    <?php if($row->logo): ?>
        <img data-action='preview-img' src='<?php echo $row->logo; ?>' style='max-width:40px;max-height:40px;cursor:pointer' class='img img-thumbnail' />&nbsp;&nbsp;
    <?php endif; ?>

    <span class="ext-name">
        <?php if($row->homepage): ?>
            <a href='<?php echo $row->homepage; ?>' target='_blank' class="feather <?php echo e($linkIcon, false); ?>"></a>
        <?php endif; ?>

        <?php if($row->alias): ?>
            <?php echo e($row->alias, false); ?> <br><small class="text-80"><?php echo e($value, false); ?></small>
        <?php else: ?>
            <?php echo e($value, false); ?>

        <?php endif; ?>
    </span>

    <?php if($row->new_version || ! $row->version): ?>
        &nbsp;
        <span class="badge bg-primary">New</span>
    <?php endif; ?>
</div>

<div style="height: 10px"></div>

<?php if($row->type === Dcat\Admin\Extend\ServiceProvider::TYPE_THEME): ?>
    <span><?php echo e(trans('admin.theme'), false); ?></span>
<?php endif; ?>

<?php if($row->version): ?>
    <?php if($row->type === Dcat\Admin\Extend\ServiceProvider::TYPE_THEME): ?>
        &nbsp;|&nbsp;
    <?php endif; ?>

    <?php if($row->enabled): ?>
        <?php echo $disableAction; ?>

    <?php else: ?>
        <?php echo $enableAction; ?>

    <?php endif; ?>

    <span class="hover-display" onclick="$(this).css({display: 'inline'})">
        | <?php echo $uninstallAction; ?>

    </span>

<?php endif; ?>

<style>
    .badge {
        max-height: 22px
    }
    .hover-display {
        display:none;
    }
    table tbody tr:hover .hover-display {
        display: inline;
    }
    .ext-name {
        font-size: 1.15rem;
    }
</style>
<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/grid/displayer/extensions/name.blade.php ENDPATH**/ ?>