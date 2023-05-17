<?php if($rows): ?>
    <div class="ml-2 mb-2 mr-2" style="margin-top: -0.5rem">
        <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $row->render(); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($field instanceof Dcat\Admin\Form\Field\Hidden): ?>
                <?php echo $field->render(); ?>

            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php elseif($layout->hasColumns()): ?>
    <?php echo $layout->build(); ?>

<?php else: ?>
    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $field->render(); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/form/fields.blade.php ENDPATH**/ ?>