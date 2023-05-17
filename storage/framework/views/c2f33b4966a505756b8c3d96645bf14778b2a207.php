<div <?php echo $attributes; ?>>
    <ul class="nav nav-tabs <?php echo e($tabStyle, false); ?>" role="tablist">
        <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($tab['type'] == \Dcat\Admin\Widgets\Tab::TYPE_CONTENT): ?>
                <li class="nav-item" >
                    <a href="#tab_<?php echo e($tab['id'], false); ?>" class=" nav-link  <?php echo e($id == $active ? 'active' : '', false); ?>" data-toggle="tab"><?php echo $tab['title']; ?></a>
                </li>
            <?php elseif($tab['type'] == \Dcat\Admin\Widgets\Tab::TYPE_LINK): ?>
                <li class="nav-item" >
                    <a href="<?php echo e($tab['href'], false); ?>" class=" nav-link  <?php echo e($id == $active ? 'active' : '', false); ?>"><?php echo $tab['title']; ?></a>
                </li>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if(!empty($dropDown)): ?>
        <li class="dropdown nav-item">
            <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#">
                Dropdown <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <?php $__currentLoopData = $dropDown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo e($link['href'], false); ?>"><?php echo $link['name']; ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </li>
        <?php endif; ?>
        <li class="nav-item pull-right header"><?php echo $title; ?></li>
    </ul>

    <div class="tab-content" style="<?php echo $padding; ?>">
        <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="tab-pane <?php echo e($id == $active ? 'active' : '', false); ?>" id="tab_<?php echo e($tab['id'], false); ?>">
            <?php echo $tab['content'] ?? ''; ?>

        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
</div><?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/widgets/tab.blade.php ENDPATH**/ ?>