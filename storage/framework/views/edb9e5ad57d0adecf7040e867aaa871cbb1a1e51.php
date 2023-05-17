<?php $__env->startSection('title', getSys('webname') ); ?>
<?php $__env->startSection('keywords', getSys('keywords') ); ?>
<?php $__env->startSection('description', getSys('description') ); ?>

<?php $__env->startSection('content'); ?>
    <div class="blank"></div>

    <div class="inner container">
        <main class="main">
            <div class="focus wow fadeIn">
                <div class="flexslider">
                    <ul class="slides">
                        <?php $__currentLoopData = $pay; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(url('/show/'.$v->id.'.html'), false); ?>" title="<?php echo e($v->title, false); ?>">
                                    <img src="<?php echo e($v->image, false); ?>" alt="<?php echo e($v->title, false); ?>"/>
                                    <p class="flex-caption"> <?php echo e($v->title, false); ?> </p>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <section class="top wow fadeIn">
                <h3>头条推荐</h3>
                <ul>
                    <?php $__currentLoopData = $top; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <h4><a href="<?php echo e(url('/show/'.$v->id.'.html'), false); ?>" title="<?php echo e($v->title, false); ?>"> <?php echo e($v->title, false); ?> </a></h4>
                            <p><?php echo e(str_limit($v->description, 200), false); ?></p>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </section>
            <div class="clear"></div>
            <div class="mainad wow fadeIn"> </div>
            <div class="content">
                <div class="section-title">
                    <h3>动态资讯</h3>
                </div>
                <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <section class="section wow fadeIn">
                        <div class="thumbnail">
                            <a href="<?php echo e(url('/show/'.$v->id.'.html'), false); ?>" title="<?php echo e($v->title, false); ?>" target="_blank">
                                <img class="load" src="https://img.622n.com/files/loading.gif" lay-src="<?php echo e($v->image, false); ?>" alt="<?php echo e($v->title, false); ?>"/>
                            </a>
                        </div>
                        <h2>
                            <a href="<?php echo e(url('/show/'.$v->id.'.html'), false); ?>" title="<?php echo e($v->title, false); ?>" target="_blank"><?php echo e($v->title, false); ?></a>
                        </h2>
                        <div class="postmeta">
                            <span>
                                <i class="icon-calendar"></i>
                                <time><?php echo e($v->updated_at, false); ?></time>
                            </span>
                            <span><i class="icon-eye"></i> <?php echo e($v->views, false); ?></span>
                        </div>
                        <div class="excerpt">
                            <p> <?php echo e(str_limit($v->description, 200), false); ?> </p>
                        </div>
                    </section>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </main>
        <aside class="sidebar">
            <section class="widget wow fadeInUp">
                <div class="section-title">
                    <h3>热门文章</h3>
                </div>
                <ul>
                    <?php $__currentLoopData = article_limit(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <i class="a<?php echo e($k+1, false); ?>"><?php echo e($k+1, false); ?></i>
                            <a href="<?php echo e(url('/show/'.$v->id.'.html'), false); ?>" title="<?php echo e($v->title, false); ?>" target="_blank"><?php echo e($v->title, false); ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </section>
            <section class="widget wow fadeInUp">
                <div class="section-title">
                    <h3>文章访问</h3>
                </div>
                <ul>
                    <?php $__currentLoopData = $access; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <i class="a<?php echo e($k+1, false); ?>"><?php echo e($k+1, false); ?></i>
                            <a href="<?php echo e(url('/show/'.$v->id.'.html'), false); ?>" title="<?php echo e($v->title, false); ?>" target="_blank"><?php echo e($v->title, false); ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </section>
        </aside>
    </div>

    <div class="inner friendlinks wow fadeIn">
        <div class="section-title"> 友情链接<span>申请要求：同属互联网资讯类网站，并内容充实，无作弊现象。</span> </div>
        <ul>
            <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="<?php echo e($v->url, false); ?>" title="<?php echo e($v->name, false); ?>" target="_blank">
                        <?php echo e($v->name, false); ?>

                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
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

<?php echo $__env->make(include_name('layouts.app'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/www.3cc0.com/resources/views/web3/welcome.blade.php ENDPATH**/ ?>