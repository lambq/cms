<?php if($paginator->hasPages()): ?>
    <ul class="uk-pagination">
        
        <?php if($paginator->onFirstPage()): ?>
            <li class="uk-disabled"><span>&laquo;</span></li>
        <?php else: ?>
            <li><a href="<?php echo e($paginator->previousPageUrl(), false); ?>" rel="prev">&laquo;</a></li>
        <?php endif; ?>

        
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <?php if(is_string($element)): ?>
                <li class="uk-disabled"><span><?php echo e($element, false); ?></span></li>
            <?php endif; ?>

            
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <li class="uk-active"><span><?php echo e($page, false); ?></span></li>
                    <?php else: ?>
                        <li><a href="<?php echo e($url . ($params ?? ''), false); ?>"><?php echo e($page, false); ?></a></li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
            <li><a href="<?php echo e($paginator->nextPageUrl() . ($params ?? ''), false); ?>" rel="next">&raquo;</a></li>
        <?php else: ?>
            <li class="uk-disabled"><span>&raquo;</span></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/studio/laravel-totem/src/Providers/../../resources/views/partials/pagination.blade.php ENDPATH**/ ?>