<style>::-ms-clear,::-ms-reveal{display: none;}</style>

<form pjax-container action="<?php echo $action; ?>" class="input-no-border quick-search-form d-md-inline-block" style="display:none;margin-right: 16px">
    <div class="table-filter">
        <label style="width: <?php echo e($width, false); ?>rem">
            <input
                    type="search"
                    class="form-control form-control-sm quick-search-input"
                    placeholder="<?php echo e($placeholder, false); ?>"
                    name="<?php echo e($key, false); ?>"
                    value="<?php echo e($value, false); ?>"
                    auto="<?php echo e($auto ? '1' : '0', false); ?>"
            >
        </label>
    </div>
</form>
<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/grid/quick-search.blade.php ENDPATH**/ ?>