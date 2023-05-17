<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale(), false); ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <meta http-equiv="Cache-Control" content="no-transform"/>
    <meta name="keywords" content="<?php echo $__env->yieldContent('keywords'); ?>" />
    <meta name="description" content="<?php echo $__env->yieldContent('description'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="applicable-device" content="pc,mobile"/>

    <link rel="shortcut icon" href="<?php echo e(asset('logo.ico'), false); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('skin/css/main.css'), false); ?>" media="screen"/>
    <link rel="stylesheet" href="<?php echo e(asset('skin/css/fontello.css'), false); ?>"/>
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo e(asset('skin/css/fontello-ie7.css'), false); ?>">
    <![endif]-->
    <link rel="stylesheet" href="<?php echo e(asset('skin/css/animate.css'), false); ?>"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="<?php echo e(asset('skin/js/html5-css3.js'), false); ?>"></script>
    <![endif]-->
    <script type="text/javascript" src="<?php echo e(asset('skin/js/jquery-1.11.0.min.js'), false); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/jquery.lazyload.js'), false); ?>"></script>
    <link href="<?php echo e(asset('skin/css/prettify.css'), false); ?>" rel="stylesheet" type="text/css" />
    <script src="<?php echo e(asset('skin/js/prettify.js'), false); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('skin/js/common_tpl.js'), false); ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo e(asset('skin/js/jquery.flexslider-min.js'), false); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('skin/js/wow.js'), false); ?>"></script>
    <script>new WOW().init();</script>
    <script type="text/javascript" src="<?php echo e(asset('skin/js/leonhere.js'), false); ?>"></script>
</head>
<body>

<!--  header  -->
<?php echo $__env->make(include_name('layouts.header'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('content'); ?>
<!--  footer  -->
<?php echo $__env->make(include_name('layouts.footer'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('script'); ?>
<script>
    $(document).ready(function(){
        //头部——搜索框
        $(".search-form").children("input").on('keydown', function(e){
            if(e.keyCode === 13){
                e.preventDefault();
                window.location.href = "https://www.3cc0.com/search/"+ $(".search-form").children("input").val();
            };
        });
        $("img.load").lazyload({effect: "fadeIn"});
    });
</script>
</body>
</html>
<?php /**PATH /www/wwwroot/www.3cc0.com/resources/views/web3/layouts/app.blade.php ENDPATH**/ ?>