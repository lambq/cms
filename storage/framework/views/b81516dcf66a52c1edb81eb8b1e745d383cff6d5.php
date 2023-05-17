<?php $__env->startSection('title', $title.getSys('webname')); ?>
<?php $__env->startSection('keywords', $keywords.getSys('keywords') ); ?>
<?php $__env->startSection('description', $description.getSys('description') ); ?>

<?php $__env->startSection('content'); ?>
    <div class="blank"></div>
    <div class="inner container">
        <main class="main">
            <div class="content">
                <div class="breadcrumb">
                    <span> 当前位置：<a href="<?php echo e(url('/'), false); ?>">首页</a> &gt; <a href="<?php echo e(url($column->name), false); ?>"><?php echo e($column->title, false); ?></a> <em class="st">&gt;</em> 正文 </span>
                </div>
                <article class="post">
                    <h1 class="post-title">
                        <?php echo e($title, false); ?>

                    </h1>
                    <div class="postmeta">
                        <span>
                            <i class="icon-calendar"></i>
                            <time><?php echo e($article->updated_at, false); ?></time>
                        </span>
                        <span>
                            <i class="icon-eye"></i>
                            <?php echo e($article->views, false); ?>

                        </span>
                    </div>

                    <div class="entry">
                        <?php if($extend): ?>
                            <?php $__currentLoopData = $extend; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($v['type'] == 'p'): ?>
                                    <p><?php echo e($v['content'], false); ?></p>
                                <?php endif; ?>
                                
                                <?php if($v['type'] == 'img'): ?>
                                    <img src="https://img.622n.com/files/loading.gif" lay-src="<?php echo e($v['content'], false); ?>" class="load" style="display: inline;">
                                <?php endif; ?>
                                
                                <?php if($v['type'] == 'title'): ?>
                                    <h3><?php echo e($v['content'], false); ?></h3>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="tags">
                        <i class="icon-tags"></i>
                        <?php $__currentLoopData = explode(',',$keywords); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(url('search'), false); ?>/<?php echo e($v, false); ?>" title="<?php echo e($v, false); ?>" target="_blank"><?php echo e($v, false); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="postnavi">
                        <div class="prev">
                            <?php if($prev): ?>
                                上一篇：
                                <a href="<?php echo e(url('/show/'.$prev->id.'.html'), false); ?>" class="prev-next-a" title="<?php echo e($prev->title, false); ?>">
                                    <?php echo e(str_limit($prev->title,15), false); ?>

                                </a>
                            <?php else: ?>
                                上一篇：
                                没有更多文章了……
                            <?php endif; ?>
                        </div>
                        <div class="next">
                            <?php if($next): ?>
                                下一篇：
                                <a href="<?php echo e(url('/show/'.$next->id.'.html'), false); ?>" class="prev-next-a" title="<?php echo e($next->title, false); ?>">
                                    <?php echo e(str_limit($next->title,15), false); ?>

                                </a>
                            <?php else: ?>
                                下一篇：
                                没有更多文章了……
                            <?php endif; ?>
                        </div>
                    </div>
                    <section class="related-post">
                        <h3><i class="icon-list-alt"></i> 您可能还会对下面的文章感兴趣：</h3>
                        <ul>
                        </ul>
                    </section>
                    <section class="related-pic">
                        <h3><i class="icon-file-image"></i> 相关文章</h3>
                        <ul>
                            <?php $__currentLoopData = article_views($column->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <div class="thumbnail">
                                        <a href="<?php echo e(url('/show/'.$v->id.'.html'), false); ?>" title="<?php echo e($v->title, false); ?>" target="_blank">
                                            <img class="load" src="https://img.622n.com/files/loading.gif" lay-src="<?php echo e($v->image, false); ?>"/>
                                        </a>
                                    </div>
                                    <p><a href="<?php echo e(url('/show/'.$v->id.'.html'), false); ?>" title="<?php echo e($v->title, false); ?>" target="_blank"><?php echo e($v->title, false); ?></a></p>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </section>


                </article>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make(include_name('layouts.app'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/www.3cc0.com/resources/views/web3/article/show1.blade.php ENDPATH**/ ?>