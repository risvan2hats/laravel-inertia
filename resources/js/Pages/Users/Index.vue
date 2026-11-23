
<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    users: { type: Object, required: true },
    filters: { type: Object, default: () => ({}) },
});

const page = usePage();

const search = ref(props.filters.search ?? '');
const status = ref(props.filters.status ?? '');

// Apply filters with debounce.
watch([search, status], ([search, status], _, onCleanup) => {
    const timer = setTimeout(() => {
        router.get(
            route('users.index'),
            {
                search: search || undefined,
                status: status || undefined,
            },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            }
        );
    }, 300);

    onCleanup(() => clearTimeout(timer));
});

// Reset filters.
function resetFilters() {
    search.value = '';
    status.value = '';
}

// Delete user.
function destroyUser(user) {
    if (confirm(`Delete ${user.name}? This cannot be undone.`)) {
        router.delete(route('users.destroy', user.id), {
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Users</h2>
        </template>

        <div class="users-page">
            <div class="users-page-header">
                <div class="users-page-heading">
                    <span class="users-eyebrow">Directory</span>
                    <h1>Users</h1>
                    <p>Manage the people and access in your workspace.</p>
                </div>
                <Link :href="route('users.create')" class="btn btn-primary">
                    <svg class="users-add-icon" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M10 4v12M4 10h12" />
                    </svg>
                    Add user
                </Link>
            </div>

            <div v-if="page.props.flash?.success" class="alert" role="status">
                {{ page.props.flash.success }}
            </div>

            <section class="card users-card" aria-label="User directory">
                <div class="users-toolbar">
                    <div class="users-filters">
                        <label class="users-search">
                            <span class="sr-only">Search users by name or email</span>
                            <svg viewBox="0 0 20 20" aria-hidden="true">
                                <circle cx="8.7" cy="8.7" r="5.7" />
                                <path d="m13 13 4 4" />
                            </svg>
                            <input
                                v-model="search"
                                type="search"
                                class="input"
                                placeholder="Search users..."
                            />
                        </label>
                        <label class="sr-only" for="user-status-filter">Filter by status</label>
                        <select id="user-status-filter" v-model="status" class="select">
                            <option value="">All statuses</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <button
                            v-if="search || status"
                            type="button"
                            class="btn btn-secondary btn-sm"
                            @click="resetFilters"
                        >
                            Clear filters
                        </button>
                    </div>
                    <span class="users-total">
                        {{ users.total }} {{ users.total === 1 ? 'user' : 'users' }} total
                    </span>
                </div>

                <div class="users-table-wrap">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th scope="col">User</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="actions-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users.data" :key="user.id">
                                <td>
                                    <div class="user-identity">
                                        <span class="user-row-avatar" aria-hidden="true">
                                            {{ user.name?.charAt(0).toUpperCase() }}
                                        </span>
                                        <span class="user-identity-copy">
                                            <strong>{{ user.name }}</strong>
                                            <span>{{ user.email }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="user-status"
                                        :class="{ 'is-active': user.status === 'active' }"
                                    >
                                        {{ user.status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="user-actions">
                                        <Link
                                            :href="route('users.edit', user.id)"
                                            class="btn btn-secondary btn-sm"
                                        >
                                            Edit
                                        </Link>
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm"
                                            @click="destroyUser(user)"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="!users.data.length">
                                <td colspan="3" class="users-empty">
                                    <strong>No users found</strong>
                                    <span>
                                        {{
                                            search || status
                                                ? 'Try adjusting your search or filters.'
                                                : 'Add a user to get your workspace started.'
                                        }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="users.last_page > 1" class="users-pagination">
                    <span>Showing {{ users.from }}–{{ users.to }} of {{ users.total }} users</span>
                    <nav class="pagination" aria-label="Pagination">
                        <template v-for="(link, index) in users.links" :key="index">
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                class="page-link"
                                :class="{ active: link.active }"
                                :aria-current="link.active ? 'page' : undefined"
                                preserve-scroll
                            >
                                <span v-html="link.label" />
                            </Link>
                            <span
                                v-else
                                class="page-link disabled"
                                v-html="link.label"
                            />
                        </template>
                    </nav>
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
