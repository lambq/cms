<?php $__env->startSection('page-title'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('page-title'); ?>
    - Tasks
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="uk-flex uk-flex-between uk-flex-middle">
        <h4 class="uk-card-title uk-margin-remove">Tasks</h4>
        <?php echo Form::open([
            'id' => 'totem__search__form',
            'url' => Request::fullUrl(),
            'method' => 'GET',
            'class' => 'uk-display-inline uk-search uk-search-default'
        ]); ?>

        <span uk-search-icon></span>
        <?php echo Form::text('q', request('q'), ['class' => 'uk-search-input', 'placeholder' => 'Search...']); ?>

        <?php echo Form::close(); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-panel-content'); ?>
    <table class="uk-table uk-table-responsive" cellpadding="0" cellspacing="0" class="mb1">
        <thead>
            <tr>
                <th><?php echo Html::columnSort('Description', 'description'); ?></th>
                <th><?php echo Html::columnSort('Average Runtime', 'average_runtime'); ?></th>
                <th><?php echo Html::columnSort('Last Run', 'last_ran_at'); ?></th>
                <th>Next Run</th>
                <th class="uk-text-center">Execute</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr is="task-row"
                    :data-task="<?php echo e($task, false); ?>"
                    showHref="<?php echo e(route('totem.task.view', $task), false); ?>"
                    executeHref="<?php echo e(route('totem.task.execute', $task), false); ?>">
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td class="uk-text-center" colspan="5">
                        <img class="uk-svg" width="50" height="50" src="<?php echo e(asset('/vendor/totem/img/funnel.svg'), false); ?>">
                        <p>No Tasks Found.</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-panel-footer'); ?>
    <div class="uk-flex uk-flex-between">
        <span>
            <a class="uk-icon-button uk-button-primary uk-hidden@m" uk-icon="icon: plus" href="<?php echo e(route('totem.task.create'), false); ?>"></a>
            <a class="uk-button uk-button-primary uk-button-small uk-visible@m" href="<?php echo e(route('totem.task.create'), false); ?>">New Task</a>
        </span>

        <span>
            <import-button url="<?php echo e(route('totem.tasks.import'), false); ?>"></import-button>
            <a class="uk-icon-button uk-button-primary uk-hidden@m" uk-icon="icon: cloud-download"  href="<?php echo e(route('totem.tasks.export'), false); ?>"></a>
            <a class="uk-button uk-button-primary uk-button-small uk-visible@m" href="<?php echo e(route('totem.tasks.export'), false); ?>">Export</a>
        </span>
    </div>
    <?php echo e($tasks->links('totem::partials.pagination', ['params' => '&' . http_build_query(array_filter(request()->except('page')))]), false); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("totem::layout", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/www.3cc0.com/vendor/studio/laravel-totem/src/Providers/../../resources/views/tasks/index.blade.php ENDPATH**/ ?>