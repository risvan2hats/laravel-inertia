<script setup>
import { useForm, Link, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UserForm from './Form.vue';

const form = useForm({
    name: '',
    email: '',
    status: 'active',
    password: '',
    password_confirmation: '',
});

const submit = () => form.post(route('users.store'));
</script>

<template>
    <Head title="Add user" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Users</h2>
        </template>

        <div class="page">
            <div class="page-header">
                <div>
                    <h1>Add user</h1>
                    <p class="page-description">Create an account for someone on your team.</p>
                </div>
            </div>
            <div class="card users-form-card">
                <UserForm
                    :form="form"
                    submit-label="Create user"
                    password-required
                    @submit="submit"
                >
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