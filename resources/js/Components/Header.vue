<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const profileMenuOpen = ref(false);

function toggleProfileMenu() {
    profileMenuOpen.value = !profileMenuOpen.value;
}
</script>

<template>
    <header class="app-topbar">
        <div class="topbar-leading">
            <div class="topbar-breadcrumb">
                <span>Workspace</span>
                <svg viewBox="0 0 16 16" aria-hidden="true">
                    <path d="m6 3 5 5-5 5" />
                </svg>
                <slot name="header">
                    <span class="topbar-current-page">Overview</span>
                </slot>
            </div>
        </div>

        <div class="topbar-profile">
            <button type="button" class="topbar-profile-trigger" aria-label="Toggle account menu"
                aria-controls="profile-menu" :aria-expanded="profileMenuOpen" @click="toggleProfileMenu">
                <span class="topbar-avatar">
                    {{ $page.props.auth.user.name?.charAt(0).toUpperCase() }}
                </span>

                <span class="topbar-profile-copy">
                    <strong>{{ $page.props.auth.user.name }}</strong>
                </span>

                <svg class="profile-chevron" :class="{ 'is-open': profileMenuOpen }" viewBox="0 0 20 20"
                    aria-hidden="true">
                    <path d="m5 7.5 5 5 5-5" />
                </svg>
            </button>

            <div v-show="profileMenuOpen" id="profile-menu" class="profile-menu" role="group"
                aria-label="Account options">
                <div class="profile-menu-identity">
                    <span class="topbar-avatar">
                        {{ $page.props.auth.user.name?.charAt(0).toUpperCase() }}
                    </span>

                    <span class="profile-menu-copy">
                        <strong>{{ $page.props.auth.user.name }}</strong>
                        <span>{{ $page.props.auth.user.email }}</span>
                    </span>
                </div>

                <div class="profile-menu-divider"></div>

                <Link :href="route('profile.edit')" class="profile-menu-item">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="8" r="3.5" />
                        <path d="M5 20a7 7 0 0 1 14 0" />
                    </svg>
                    <span>Profile settings</span>
                </Link>

                <Link :href="route('logout')" method="post" as="button" class="profile-menu-item profile-menu-logout">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M10 17l5-5-5-5M15 12H3" />
                        <path d="M12 3h5a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5" />
                    </svg>
                    <span>Log out</span>
                </Link>
            </div>
        </div>
    </header>
</template>
