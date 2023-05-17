<?php $__env->startSection('title', $column->title.'-'.getSys('webname')); ?>
<?php $__env->startSection('keywords', $column->keywords ); ?>
<?php $__env->startSection('description', $column->description ); ?>

<?php $__env->startSection('content'); ?>
<div class="blank"></div>

<div class="inner container">
    <main class="main">
        <div class="content">
            <div class="breadcrumb"> <span> 当前位置：<a href="<?php echo e(url('/'), false); ?>">首页</a> &gt; <a href="<?php echo e(url($column->name), false); ?>"><?php echo e($column->title, false); ?></a> &gt; </span> </div>
            <?php if(isset($articles)): ?>
                <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <section class="section wow fadeIn">
                        <div class="thumbnail">
                            <a href="<?php echo e(url('/show/'.$v->id.'.html'), false); ?>" title="<?php echo e($v->title, false); ?>" target="_blank">
                                <img  class="load" src="https://img.622n.com/files/loading.gif" lay-src="<?php echo e($v->image, false); ?>" alt="<?php echo e($v->title, false); ?>"/>
                            </a>
                        </div>
                        <h2>
                            <a href="<?php echo e(url('/show/'.$v->id.'.html'), false); ?>" title="<?php echo e($v->title, false); ?>" target="_blank"><?php echo e($v->title, false); ?></a>
                        </h2>
                        <div class="postmeta">
                            <span>
                                <i class="icon-calendar"></i>
                                <time> <?php echo e($v->updated_at, false); ?> </time>
                            </span>
                            <span>
                                <i class="icon-eye"></i> <?php echo e($v->views, false); ?>

                            </span>
                        </div>
                        <div class="excerpt">
                            <p>  <?php echo e(str_limit($v->description, 200), false); ?> </p>
                        </div>
                    </section>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <div class="pagess">
                <ul>
                    <?php echo e($articles->links('vendor.pagination.default', ['data' => $articles]), false); ?>

                </ul>
            </div>
        </div>
    </main>
    <?php echo $__env->make(include_name('layouts.right'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>

<div class="fixed-widget">
    <ul>
        <li><i class="icon-up-open"></i></li>
    </ul>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>prettyPrint();</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(include_name('layouts.app'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/www.3cc0.com/resources/views/web3/article/list.blade.php ENDPATH**/ ?>