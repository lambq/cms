<aside class="sidebar bar1">
    <section class="widget theme-widget wow fadeInUp">
        <div class="section-title">
            <h3>热门文章</h3>
        </div>
        <ul>
            <?php $__currentLoopData = article_limit(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <div class="thumbnail">
                        <a href="<?php echo e(url('/show/'.$v->id.'.html'), false); ?>" title="<?php echo e($v->title, false); ?>" target="_blank">
                            <img src="<?php echo e($v->image, false); ?>"/>
                        </a>
                    </div>
                    <p><a href="<?php echo e(url('/show/'.$v->id.'.html'), false); ?>" title="<?php echo e($v->title, false); ?>" target="_blank"> <?php echo e($v->title, false); ?> </a></p>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </section>
</aside><?php /**PATH /www/wwwroot/www.3cc0.com/resources/views/web3/layouts/right1.blade.php ENDPATH**/ ?>