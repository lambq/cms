<uikit-modal :show="showModal" @close="closeModal">
    <div class="uk-modal-header">
        <h3>Add Frequency</h3>
    </div>
    <div class="uk-modal-body">
        <fieldset class="uk-fieldset">
            <div class="uk-margin">
                <select id="frequency" class="uk-select" v-model="selected">
                    <option :value="placeholder" disabled>Select a type of frequency</option>
                    <?php $__currentLoopData = collect($frequencies); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $frequency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option :value="<?php echo e(json_encode($frequency), false); ?>"><?php echo e($frequency['label'], false); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div v-if="selected.parameters">
                <div class="uk-margin" v-for="parameter in selected.parameters" >
                    <input type="text" v-model="parameter.value" :name="parameter.name" :placeholder="parameter.label" class="uk-input">
                </div>
            </div>
        </fieldset>
    </div>
    <div class="uk-modal-footer">
        <div class="uk-flex uk-flex-right">
            <button class="uk-button uk-button-small uk-button-primary" @click.self.prevent="addFrequency">Add</button>
        </div>
    </div>
</uikit-modal><?php /**PATH /www/wwwroot/www.3cc0.com/vendor/studio/laravel-totem/src/Providers/../../resources/views/dialogs/frequencies/add.blade.php ENDPATH**/ ?>