<?php if($showHeader): ?>
    <div class="box-header with-border mb-1" style="padding: .65rem 1rem">
        <h3 class="box-title" style="line-height:30px"><?php echo $form->title(); ?></h3>
        <div class="pull-right"><?php echo $form->renderTools(); ?></div>
    </div>
<?php endif; ?>
<div class="box-body" <?php echo $tabObj->isEmpty() && !$form->hasRows() ? 'style="margin-top: 6px"' : ''; ?> >
    <?php if(!$tabObj->isEmpty()): ?>
        <?php echo $__env->make('admin::form.tab', compact('tabObj', 'form'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>
        <div class="fields-group">
            <?php echo $__env->make('admin::form.fields', ['rows' => $form->rows(), 'fields' => $form->fields(), 'layout' => $form->layout()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    <?php endif; ?>
</div>
<?php echo $form->renderFooter(); ?>


<?php echo $form->renderHiddenFields(); ?>

<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/form/container.blade.php ENDPATH**/ ?>