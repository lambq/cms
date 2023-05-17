<?php if(session()->has('success')): ?>
    <uikit-alert type="success">
        <?php echo e(session()->get('success'), false); ?>

    </uikit-alert>
<?php endif; ?>
<?php if($errors->any()): ?>
    <uikit-alert type="danger">
        Please Correct the errors and try resubmitting.
    </uikit-alert>
<?php endif; ?><?php /**PATH /www/wwwroot/www.3cc0.com/vendor/studio/laravel-totem/src/Providers/../../resources/views/partials/alerts.blade.php ENDPATH**/ ?>