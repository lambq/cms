<style>
    .webuploader-pick {
        background-color: <?php echo admin_color()->primary(); ?>;
    }

    .web-uploader .placeholder .flashTip a {
        color: <?php echo admin_color()->primary(-10); ?>;
    }

    .web-uploader .statusBar .upload-progress span.percentage,
    .web-uploader .filelist li p.upload-progress span {
        background: <?php echo admin_color()->primary(-8); ?>;
    }

    .web-uploader .dnd-area.webuploader-dnd-over {
        border: 3px dashed #999 !important;
    }
    .web-uploader .dnd-area.webuploader-dnd-over .placeholder {
        border: none;
    }

</style>

<div class="<?php echo e($viewClass['form-group'], false); ?> <?php echo e($class, false); ?>">

    <label for="<?php echo e($column, false); ?>" class="<?php echo e($viewClass['label'], false); ?> control-label"><?php echo $label; ?></label>

    <div class="<?php echo e($viewClass['field'], false); ?>">

        <?php echo $__env->make('admin::form.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <input name="<?php echo e($name, false); ?>" class="file-input" type="hidden" <?php echo $attributes; ?>/>

        <div class="web-uploader <?php echo e($fileType, false); ?>">
            <div class="queueList dnd-area">
                <div class="placeholder">
                    <div class="file-picker"></div>
                    <p><?php echo e(trans('admin.uploader.drag_file'), false); ?></p>
                </div>
            </div>
            <div class="statusBar" style="display:none;">
                <div class="upload-progress progress progress-bar-primary pull-left">
                    <div class="progress-bar progress-bar-striped active" style="line-height:18px">0%</div>
                </div>
                <div class="info"></div>
                <div class="btns">
                    <div class="add-file-button"></div>
                    <?php if($showUploadBtn): ?>
                    &nbsp;
                    <div class="upload-btn btn btn-primary"><i class="feather icon-upload"></i> &nbsp;<?php echo e(trans('admin.upload'), false); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php echo $__env->make('admin::form.help-block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>

<script require="@webuploader" init="<?php echo $selector; ?>">
    var uploader,
        newPage,
        options = <?php echo $options; ?>,
        events = options.events;

    init();

    function init() {
        var opts = $.extend({
            selector: $this,
            addFileButton: $this.find('.add-file-button'),
            inputSelector: $this.find('.file-input'),
        }, options);

        opts.upload = $.extend({
            pick: {
                id: $this.find('.file-picker'),
                name: '_file_',
                label: '<i class="feather icon-folder"><\/i>&nbsp; <?php echo trans('admin.uploader.add_new_media'); ?>'
            },
            dnd: $this.find('.dnd-area'),
            paste: $this.find('.web-uploader')
        }, opts);

        uploader = Dcat.Uploader(opts);
        uploader.build();
        uploader.preview();

        for (var i = 0; i < events.length; i++) {
            var evt = events[i];
            if (evt.event && evt.script) {
                if (evt.once) {
                    uploader.uploader.once(evt.event, evt.script.bind(uploader))
                } else {
                    uploader.uploader.on(evt.event, evt.script.bind(uploader))
                }
            }
        }

        function resize() {
            setTimeout(function () {
                if (! uploader) return;

                uploader.refreshButton();
                resize();

                if (! newPage) {
                    newPage = 1;
                    $(document).one('pjax:complete', function () {
                        uploader = null;
                    });
                }
            }, 250);
        }
        resize();
    }
</script>
<?php /**PATH /www/wwwroot/www.3cc0.com/vendor/dcat/laravel-admin/src/../resources/views/form/file.blade.php ENDPATH**/ ?>