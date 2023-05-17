<?php if(! empty($button['text']) || $click): ?>
    <span class="drop<?php echo e($direction, false); ?>" style="display:inline-block">
        <a id="<?php echo e($buttonId, false); ?>" class="dropdown-toggle <?php echo e($button['class'], false); ?>" data-toggle="dropdown" href="javascript:void(0)">
            <stub><?php echo $button['text']; ?></stub>
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu"><?php echo $options; ?></ul>
    </span>
<?php else: ?>
    <ul class="dropdown-menu"><?php echo $options; ?></ul>
<?php endif; ?>

<?php if($click): ?>
    <script>
        var $btn = $('#<?php echo e($buttonId, false); ?>'),
            $a = $btn.parent().find('ul li a'),
            text = String($btn.text());

        $a.on('click', function () {
            $btn.find('stub').html($(this).html() + ' &nbsp;');
        });

        if (text.replace(/(^\s*)|(\s*$)/g,"")) {
            $btn.find('stub').html(text + ' &nbsp;');
        } else {
            (!$a.length) || $btn.find('stub').html($($a[0]).html() + ' &nbsp;');
        }
    </script>
<?php endif; ?><?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/widgets/dropdown.blade.php ENDPATH**/ ?>