<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token(), false); ?>">

        <title>
            Totem
            <?php echo $__env->yieldContent('page-title'); ?>
        </title>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('/vendor/totem/css/app.css'), false); ?>">
        <?php echo $__env->yieldPushContent('style'); ?>
    </head>
    <body>
        <main id="root">
            <div class="uk-container uk-section">
                <div class="uk-grid">
                    <?php echo $__env->make('totem::partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <section class="uk-width-5-6@l">
                        <?php echo $__env->make('totem::partials.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->yieldContent('main-panel-before'); ?>
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-header">
                                <?php echo $__env->yieldContent('title'); ?>
                            </div>
                            <div class="uk-card-body">
                                <?php echo $__env->yieldContent('main-panel-content'); ?>
                            </div>
                            <div class="uk-card-footer">
                                <?php echo $__env->yieldContent('main-panel-footer'); ?>
                            </div>
                        </div>
                        <?php echo $__env->yieldContent('main-panel-after'); ?>
                        <?php echo $__env->yieldContent('additional-panels'); ?>
                        <div class="uk-margin-top">
                            <?php echo $__env->make('totem::partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </section>
                </div>
            </div>
        </main>
        <script src="<?php echo e(asset('/vendor/totem/js/app.js'), false); ?>"></script>
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>
</html>
<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/studio/laravel-totem/src/Providers/../../resources/views/layout.blade.php ENDPATH**/ ?>