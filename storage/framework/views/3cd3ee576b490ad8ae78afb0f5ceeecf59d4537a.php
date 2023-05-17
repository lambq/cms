<header class="header">
    <div class="inner">
        <div class="logo animated fadeInLeft"> <a href="<?php echo e(url('/'), false); ?>" title="<?php echo e(getSys('webname'), false); ?>"><img src="<?php echo e(asset('logo.png'), false); ?>" alt="<?php echo e(getSys('webname'), false); ?>"/></a> </div>
        <div class="top-other">
            <ul>
                <li><i class="icon-menu"></i></li>
                <li><i class="icon-search"></i></li>
                <div class="clear"></div>
            </ul>
        </div>
        <nav class="nav">
            <div class="menu">
                <ul>
                    <li <?php if(route_class() == 'root'): ?> class="current" <?php endif; ?>><a href="/" >首页</a> </li>
                    <li <?php if(route_class() == 'top'): ?> class="current" <?php endif; ?>><a href="<?php echo e(url('top'), false); ?>" >热门资讯</a> </li>
                    <?php $__currentLoopData = getMenu(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <li class="common <?php if(route_class() == $v->name): ?> current <?php endif; ?>">
                            <a href="<?php echo e(url($v->name), false); ?>"><?php echo e($v->title, false); ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li <?php if(route_class() == 'update'): ?> class="current" <?php endif; ?>><a href="<?php echo e(url('update'), false); ?>" >动态资讯</a> </li>
                </ul>
            </div>
        </nav>
        <div class="clear"></div>
    </div>
</header>
<div class="search-bg" >
    <div class="inner">
        <div class="search-form">
            <input type="text" class="s" name="q" id="q" value="" placeholder="输入关键词搜索..."/>
        </div>
        
    </div>
</div>
<?php /**PATH /www/wwwroot/www.3cc0.com/resources/views/web3/layouts/header.blade.php ENDPATH**/ ?>