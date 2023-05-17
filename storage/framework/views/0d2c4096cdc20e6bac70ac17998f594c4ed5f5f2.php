<?php $__env->startSection('page-title'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('page-title'); ?>
    - <?php echo e($task->exists ? 'Update' : 'Create', false); ?> Task
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-panel-before'); ?>
    <form method="POST">
        <?php echo e(csrf_field(), false); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="uk-flex uk-flex-between uk-flex-middle">
        <h5 class="uk-card-title uk-margin-remove"><?php echo e($task->exists ? 'Update' : 'Create', false); ?> Task</h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-panel-content'); ?>
    <div class="uk-grid">
        <div class="uk-width-1-1@s uk-width-1-3@m">
            <label class="uk-form-label">Description</label>
            <div class="uk-text-meta">Provide a descriptive name for your task</div>
        </div>
        <div class="uk-width-1-1@s uk-width-2-3@m">
            <input class="uk-input" placeholder="e.g. Daily Backups" name="description" id="description" value="<?php echo e(old('description', $task->description), false); ?>" type="text">
            <?php if($errors->has('description')): ?>
                <p class="uk-text-danger"><?php echo e($errors->first('description'), false); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-1-1@s uk-width-1-3@m">
            <label class="uk-form-label">Command</label>
            <div class="uk-text-meta">Select an artisan command to schedule</div>
        </div>
        <div class="uk-width-1-1@s uk-width-2-3@m">
            <command-list command="<?php echo e($task->command, false); ?>" :commands="<?php echo e(json_encode($commands), false); ?>"></command-list>
            <?php if($errors->has('command')): ?>
                <p class="uk-text-danger"><?php echo e($errors->first('command'), false); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-1-1@s uk-width-1-3@m">
            <label class="uk-form-label">Parameters (Optional)</label>
            <div class="uk-text-meta">Command parameters required to run the selected command</div>
        </div>
        <div class="uk-width-1-1@s uk-width-2-3@m">
            <input class="uk-input" placeholder="e.g. --type=all for options or name=John for arguments" name="parameters" id="parameters" value="<?php echo e(old('parameters', $task->parameters), false); ?>" type="text">
        </div>
    </div>
    <hr class="uk-divider-icon">
    <div class="uk-grid">
        <div class="uk-width-1-1@s uk-width-1-3@m">
            <label class="uk-form-label">Timezone</label>
            <div class="uk-text-meta">Select a timezone for your task. App timezone is selected by default</div>
        </div>
        <div class="uk-width-1-1@s uk-width-2-3@m">
            <select id="timezone" name="timezone" class="uk-select" placeholder="Select a timezone">
                <?php $__currentLoopData = $timezones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $timezone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($timezone, false); ?>" <?php echo e(old('timezone', $task->exists ? $task->timezone :  config('app.timezone')) == $timezone ? 'selected' : '', false); ?>><?php echo e($timezone, false); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
    <task-type inline-template current="<?php echo e(old('type', $task->expression ? 'expression' : 'frequency'), false); ?>" :existing="<?php echo e(old('frequencies') ? json_encode(old('frequencies')) : $task->frequencies, false); ?>" >
        <div class="uk-margin">
            <div class="uk-grid">
                <div class="uk-width-1-1@s uk-width-1-3@m">
                    <div class="uk-form-label">Type</div>
                    <div class="uk-text-meta">Choose whether to define a cron expression or to add frequencies</div>
                </div>
                <div class="uk-width-1-1@s uk-width-2-3@m uk-form-controls-text">
                    <label>
                        <input type="radio" name="type" v-model="type" value="expression"> Expression
                    </label><br>
                    <label>
                        <input type="radio" name="type" v-model="type" value="frequency"> Frequencies
                    </label>
                </div>
            </div>
            <div class="uk-grid" v-if="isCron">
                <div class="uk-width-1-1@s uk-width-1-3@m">
                    <label class="uk-form-label">Cron Expression</label>
                    <div class="uk-text-meta">Add a cron expression for your task</div>
                </div>
                <div class="uk-width-1-1@s uk-width-2-3@m">
                    <input class="uk-input" placeholder="e.g * * * * * to run this task all the time" name="expression" id="expression" value="<?php echo e(old('expression', $task->expression), false); ?>" type="text">
                    <?php if($errors->has('expression')): ?>
                        <p class="uk-text-danger"><?php echo e($errors->first('expression'), false); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="uk-grid" v-if="managesFrequencies">
                <div class="uk-width-1-1@s uk-width-1-3@m">
                    <label class="uk-form-label">Frequencies</label>
                    <div class="uk-text-meta">Add frequencies to your task. These frequencies will be converted into a cron expression while scheduling the task</div>
                </div>
                <div class="uk-width-1-1@s uk-width-2-3@m">
                    <a class="uk-button uk-button-small uk-button-link" @click.self.prevent="showModal = true">Add Frequency</a>
                    <?php echo $__env->make('totem::dialogs.frequencies.add', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <table class="uk-table uk-table-divider uk-margin-remove">
                        <thead>
                            <tr>
                                <th class="uk-padding-remove-left">
                                    Frequency
                                </th>
                                <th class="uk-padding-remove-left">
                                    Parameters
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(frequency, index) in frequencies">
                                <td class="uk-padding-remove-left">
                                    {{ frequency.label }}
                                    <input type="hidden" :name="'frequencies[' + index + '][interval]'" v-model="frequency.interval">
                                    <input type="hidden" :name="'frequencies[' + index + '][label]'" v-model="frequency.label">
                                </td>
                                <td class="uk-padding-remove-left">
                                    <span v-if="frequency.parameters && frequency.parameters.length > 0">
                                        <span v-for="(parameter, key) in frequency.parameters">
                                            {{ parameter.value }}
                                            <span v-if="frequency.parameters.length > 1 && key < frequency.parameters.length - 1">,</span>
                                            <input type="hidden" :name="'frequencies[' + index + '][parameters][' + key +'][name]'" v-model="parameter.name">
                                            <input type="hidden" :name="'frequencies[' + index + '][parameters][' + key +'][value]'" v-model="parameter.value">
                                        </span>
                                    </span>
                                    <span v-else>
                                        No Parameters
                                    </span>
                                </td>
                                <td>
                                    <a class="uk-button uk-button-link" @click="remove(index)">
                                        <span uk-icon="icon: close"></span>
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="frequencies.length == 0">
                                <td colspan="3" class="uk-padding-remove-left">No Frequencies Found</td>
                            </tr>
                        </tbody>
                    </table>
                    <?php if($errors->has('frequencies')): ?>
                        <p class="uk-text-danger"><?php echo e($errors->first('frequencies'), false); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </task-type>
    <hr class="uk-divider-icon">
    <div class="uk-grid">
        <div class="uk-width-1-1@s uk-width-1-3@m">
            <label class="uk-form-label">Email Notification (optional)</label>
            <div class="uk-text-meta">Add an email address to receive notifications when this task gets executed. Leave empty if you do not wish to receive email notifications</div>
        </div>
        <div class="uk-width-1-1@s uk-width-2-3@m">
            <input type="text" id="email" name="notification_email_address" value="<?php echo e(old('notification_email_address', $task->notification_email_address), false); ?>" class="uk-input" placeholder="e.g. john.doe@name.tld">
            <?php if($errors->has('notification_email_address')): ?>
                <p class="uk-text-danger"><?php echo e($errors->first('notification_email_address'), false); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-1-1@s uk-width-1-3@m">
            <label class="uk-form-label">SMS Notification (optional)</label>
            <div class="uk-text-meta">Add a phone number to receive SMS notifications. Leave empty if you do not wish to receive sms notifications</div>
        </div>
        <div class="uk-width-1-1@s uk-width-2-3@m">
            <input type="text" id="phone" name="notification_phone_number" value="<?php echo e(old('notification_phone_number', $task->notification_phone_number), false); ?>" class="uk-input" placeholder="e.g. 18701234567">
            <?php if($errors->has('notification_phone_number')): ?>
                <p class="uk-text-danger"><?php echo e($errors->first('notification_phone_number'), false); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-width-1-1@s uk-width-1-3@m">
            <label class="uk-form-label">Slack Notification (optional)</label>
            <div class="uk-text-meta">Add a slack web hook url to recieve slack notifications. Leave empty if you do not wish to receive slack notifications</div>
        </div>
        <div class="uk-width-1-1@s uk-width-2-3@m">
            <input type="text" id="slack" name="notification_slack_webhook" value="<?php echo e(old('notification_slack_webhook', $task->notification_slack_webhook), false); ?>" class="uk-input" placeholder="e.g. https://hooks.slack.com/TXXXXX/BXXXXX/XXXXXXXXXX">
            <?php if($errors->has('notification_slack_webhook')): ?>
                <p class="uk-text-danger"><?php echo e($errors->first('notification_slack_webhook'), false); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <hr class="uk-divider-icon">
    <div class="uk-grid">
        <div class="uk-width-1-1@s uk-width-1-3@m">
            <div class="uk-form-label">Miscellaneous Options</div>
            <ul class="uk-list uk-padding-remove">
                <li class="uk-text-meta">Decide whether multiple instances of same task should overlap each other or not.</li>
                <li class="uk-text-meta">Decide whether the task should be executed while the app is in maintenance mode.</li>
                <li class="uk-text-meta">Decide whether the task should be executed on a single server.</li>
            </ul>
        </div>
        <div class="uk-width-1-1@s uk-width-2-3@m uk-form-controls-text">
            <label class="uk-margin">
                <input type="hidden" name="dont_overlap" id="dont_overlap" value="0" <?php echo e(old('dont_overlap', $task->dont_overlap) ? '' : 'checked', false); ?>>
                <input type="checkbox" name="dont_overlap" id="dont_overlap" value="1" <?php echo e(old('dont_overlap', $task->dont_overlap) ? 'checked' : '', false); ?>>
                Don't Overlap
            </label>

            <div class="uk-margin">
                <label class="uk-margin">
                    <input type="hidden" name="run_in_maintenance" id="run_in_maintenance" value="0" <?php echo e(old('run_in_maintenance', $task->run_in_maintenance) ? '' : 'checked', false); ?>>
                    <input type="checkbox" name="run_in_maintenance" id="run_in_maintenance" value="1" <?php echo e(old('run_in_maintenance', $task->run_in_maintenance) ? 'checked' : '', false); ?>>
                    Run in maintenance mode
                </label>
            </div>
            <div class="uk-margin">
                <label class="uk-margin">
                    <input type="hidden" name="run_on_one_server" id="run_on_one_server" value="0" <?php echo e(old('run_on_one_server', $task->run_on_one_server) ? '' : 'checked', false); ?>>
                    <input type="checkbox" name="run_on_one_server" id="run_on_one_server" value="1" <?php echo e(old('run_on_one_server', $task->run_on_one_server) ? 'checked' : '', false); ?>>
                    Run on a single server
                </label>
            </div>
        </div>
    </div>
    <hr class="uk-divider-icon">
    <div class="uk-grid">
        <div class="uk-width-1-1@s uk-width-1-3@m">
            <div class="uk-form-label">Cleanup Options</div>
            <ul class="uk-list uk-padding-remove">
                <li class="uk-text-meta">Determine if an over-abundance of results will be removed after a set limit or age. Set non-zero value to enable.</li>
            </ul>
        </div>
        <div class="uk-width-1-1@s uk-width-2-3@m uk-form-controls-text">
            <label class="uk-margin">
                Auto Cleanup results after
                <br>
                <input class="uk-input" type="number" name="auto_cleanup_num" id="auto_cleanup_num" value="<?php echo e(old('auto_cleanup_num', $task->auto_cleanup_num) ?? 0, false); ?>" />
                <br>
                <label>
                    <input type="radio" name="auto_cleanup_type" value="days" <?php echo e(old('auto_cleanup_type', $task->auto_cleanup_type) !== 'results' ? '' : 'checked', false); ?>> Days
                </label><br>
                <label>
                    <input type="radio" name="auto_cleanup_type" value="results" <?php echo e(old('auto_cleanup_type', $task->auto_cleanup_type) === 'results' ? '' : 'checked', false); ?>> Results
                </label>
            </label>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-panel-footer'); ?>
    <button class="uk-button uk-button-primary uk-button-small" type="submit">Save</button>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('main-panel-after'); ?>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('totem::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/www.3cc0.com/vendor/studio/laravel-totem/src/Providers/../../resources/views/tasks/form.blade.php ENDPATH**/ ?>