<script setup>
defineProps({
    form: { type: Object, required: true },
    submitLabel: { type: String, default: 'Save' },
    passwordRequired: { type: Boolean, default: false },
})

defineEmits(['submit'])
</script>

<template>
    <form class="form" @submit.prevent="$emit('submit')">
        <div class="form-group">
            <label for="name">Name</label>
            <input id="name" v-model="form.name" type="text" class="input" :class="{ 'has-error': form.errors.name }" />
            <div v-if="form.errors.name" class="error-text">{{ form.errors.name }}</div>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" v-model="form.email" type="email" class="input" :class="{ 'has-error': form.errors.email }" />
            <div v-if="form.errors.email" class="error-text">{{ form.errors.email }}</div>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" v-model="form.status" class="select">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            <div v-if="form.errors.status" class="error-text">{{ form.errors.status }}</div>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" v-model="form.password" type="password" class="input" :class="{ 'has-error': form.errors.password }" />
            <div v-if="!passwordRequired" class="hint">Leave blank to keep the current password.</div>
            <div v-if="form.errors.password" class="error-text">{{ form.errors.password }}</div>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" v-model="form.password_confirmation" type="password" class="input" />
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary" :disabled="form.processing">
                {{ form.processing ? 'Saving...' : submitLabel }}
            </button>
            <slot name="cancel" />
        </div>
    </form>
</template>