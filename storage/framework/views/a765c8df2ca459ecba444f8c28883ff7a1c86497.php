<?php if($paginator->hasPages()): ?>
        
        <?php if(PaginateRoute::hasPreviousPage()): ?>
            <li><a href="<?php echo e(PaginateRoute::previousPageUrl(), false); ?>" class="layui-laypage-prev">上一页</a></li>
        <?php else: ?>
            <li><a class="layui-laypage-prev layui-disabled">首页</a></li>
        <?php endif; ?>

        
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <?php if(is_string($element)): ?>
                <li>
                    <?php echo e($element, false); ?>

                </li>
            <?php endif; ?>

            
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <li class="thisclass">
                            <?php echo e($page, false); ?>

                        </li>
                    <?php else: ?>
                        <li><a href="<?php echo e(PaginateRoute::pageUrl($page), false); ?>"><?php echo e($page, false); ?></a></li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if(PaginateRoute::hasNextPage($data)): ?>
            <li><a href="<?php echo e(PaginateRoute::nextPageUrl($data), false); ?>" class="layui-laypage-next">下一页</a></li>
        <?php else: ?>
            <li><a class="layui-laypage-next layui-disabled">末页</a></li>
        <?php endif; ?>
<?php endif; ?>
<?php /**PATH /www/wwwroot/www.3cc0.com/resources/views/vendor/pagination/default.blade.php ENDPATH**/ ?>