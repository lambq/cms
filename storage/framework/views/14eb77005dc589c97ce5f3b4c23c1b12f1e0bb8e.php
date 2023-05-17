<style>
    .login-box {
        margin-top: -10rem;
        padding: 5px;
    }
    .login-card-body {
        padding: 1.5rem 1.8rem 1.6rem;
    }
    .card, .card-body {
        border-radius: .25rem
    }
    .login-btn {
        padding-left: 2rem!important;;
        padding-right: 1.5rem!important;
    }
    .content {
        overflow-x: hidden;
    }
    .form-group .control-label {
        text-align: left;
    }
</style>

<div class="login-page bg-40">
    <div class="login-box">
        <div class="login-logo mb-2">
            <?php echo e(config('admin.name'), false); ?>

        </div>
        <div class="card">
            <div class="card-body login-card-body shadow-100">
                <p class="login-box-msg mt-1 mb-1"><?php echo e(__('admin.welcome_back'), false); ?></p>

                <form id="login-form" method="POST" action="<?php echo e(admin_url('auth/login'), false); ?>">

                    <input type="hidden" name="_token" value="<?php echo e(csrf_token(), false); ?>"/>

                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                        <input
                                type="text"
                                class="form-control <?php echo e($errors->has('username') ? 'is-invalid' : '', false); ?>"
                                name="username"
                                placeholder="<?php echo e(trans('admin.username'), false); ?>"
                                value="<?php echo e(old('username'), false); ?>"
                                required
                                autofocus
                        >

                        <div class="form-control-position">
                            <i class="feather icon-user"></i>
                        </div>

                        <label for="email"><?php echo e(trans('admin.username'), false); ?></label>

                        <div class="help-block with-errors"></div>
                        <?php if($errors->has('username')): ?>
                            <span class="invalid-feedback text-danger" role="alert">
                                            <?php $__currentLoopData = $errors->get('username'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="control-label" for="inputError"><i class="feather icon-x-circle"></i> <?php echo e($message, false); ?></span><br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </span>
                        <?php endif; ?>
                    </fieldset>

                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                        <input
                                minlength="5"
                                maxlength="20"
                                id="password"
                                type="password"
                                class="form-control <?php echo e($errors->has('password') ? 'is-invalid' : '', false); ?>"
                                name="password"
                                placeholder="<?php echo e(trans('admin.password'), false); ?>"
                                required
                                autocomplete="current-password"
                        >

                        <div class="form-control-position">
                            <i class="feather icon-lock"></i>
                        </div>
                        <label for="password"><?php echo e(trans('admin.password'), false); ?></label>

                        <div class="help-block with-errors"></div>
                        <?php if($errors->has('password')): ?>
                            <span class="invalid-feedback text-danger" role="alert">
                                            <?php $__currentLoopData = $errors->get('password'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="control-label" for="inputError"><i class="feather icon-x-circle"></i> <?php echo e($message, false); ?></span><br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </span>
                        <?php endif; ?>

                    </fieldset>
                    <div class="form-group d-flex justify-content-between align-items-center">
                        <div class="text-left">
                            <?php if(config('admin.auth.remember')): ?>
                            <fieldset class="checkbox">
                                <div class="vs-checkbox-con vs-checkbox-primary">
                                    <input id="remember" name="remember"  value="1" type="checkbox" <?php echo e(old('remember') ? 'checked' : '', false); ?>>
                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                          <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                    <span> <?php echo e(trans('admin.remember_me'), false); ?></span>
                                </div>
                            </fieldset>
                            <?php endif; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-right login-btn">

                        <?php echo e(__('admin.login'), false); ?>

                        &nbsp;
                        <i class="feather icon-arrow-right"></i>
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
Dcat.ready(function () {
    // ajax表单提交
    $('#login-form').form({
        validate: true,
    });
});
</script>
<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/pages/login.blade.php ENDPATH**/ ?>