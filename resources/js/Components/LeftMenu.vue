<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const page = usePage();
</script>

<template>
    <aside class="app-sidebar" aria-label="Workspace sidebar">
        <Link :href="route('dashboard')" class="app-brand">
            <span class="app-brand-mark">
                <ApplicationLogo />
            </span>
            <span class="app-brand-copy">
                <strong>Workspace</strong>
                <span>Management console</span>
            </span>
        </Link>

        <div class="sidebar-section-label">Workspace</div>
        <nav class="sidebar-nav" aria-label="Workspace">
            <Link
                :href="route('dashboard')"
                class="sidebar-link"
                :class="{ 'is-active': page.url === '/dashboard' }"
                :aria-current="page.url === '/dashboard' ? 'page' : undefined"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <rect x="3.5" y="3.5" width="7" height="7" rx="1.5" />
                    <rect x="13.5" y="3.5" width="7" height="7" rx="1.5" />
                    <rect x="3.5" y="13.5" width="7" height="7" rx="1.5" />
                    <rect x="13.5" y="13.5" width="7" height="7" rx="1.5" />
                </svg>
                <span>Overview</span>
            </Link>
            <Link
                :href="route('users.index')"
                class="sidebar-link"
                :class="{ 'is-active': page.url.startsWith('/users') }"
                :aria-current="page.url.startsWith('/users') ? 'page' : undefined"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M16 20v-1.5a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4V20" />
                    <circle cx="9.5" cy="7" r="4" />
                    <path d="M20 20v-1.5a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                <span>Users</span>
            </Link>
        </nav>
    </aside>
</template>