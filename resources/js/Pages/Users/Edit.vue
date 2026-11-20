<script setup>
import { useForm, Link, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UserForm from './Form.vue';

const props = defineProps({
    user: { type: Object, required: true },
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    status: props.user.status,
    password: '',
    password_confirmation: '',
});

const submit = () => form.put(route('users.update', props.user.id));
</script>

<template>
    <Head title="Edit user" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Users</h2>
        </template>

        <div class="page">
            <div class="page-header">
                <div>
                    <h1>Edit user</h1>
                    <p class="page-description">Update account details and access status.</p>
                </div>
            </div>
            <div class="card users-form-card">
                <UserForm :form="form" submit-label="Save changes" @submit="submit">
                    <template #cancel>
                        <Link :href="route('users.index')" class="btn btn-secondary">
                            Cancel
                        </Link>
                    </template>
                </UserForm>
            </div>
        </div>
    </AuthenticatedLayout>
</template>