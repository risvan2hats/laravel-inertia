<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const page = usePage();
const mobileMenuOpen = ref(false);
const profileMenuOpen = ref(false);
const profileMenu = ref(null);
const currentYear = new Date().getFullYear();

function closeMobileMenu() {
    mobileMenuOpen.value = false;
}

function closeProfileMenu() {
    profileMenuOpen.value = false;
}

function handleOutsideClick(event) {
    if (profileMenu.value && !profileMenu.value.contains(event.target)) {
        closeProfileMenu();
    }
}

function handleKeydown(event) {
    if (event.key === 'Escape') {
        closeProfileMenu();
    }
}

function getInitials(name) {
    return name
        .split(/\s+/)
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part[0])
        .join('')
        .toUpperCase();
}

onMounted(() => {
    document.addEventListener('click', handleOutsideClick);
    document.addEventListener('keydown', handleKeydown);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleOutsideClick);
    document.removeEventListener('keydown', handleKeydown);
});
</script>

<template>
    <div class="app-shell">
        <aside
            id="app-sidebar"
            class="app-sidebar"
            :class="{ 'is-open': mobileMenuOpen }"
            aria-label="Workspace sidebar"
        >
            <Link :href="route('dashboard')" class="app-brand" @click="closeMobileMenu">
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
                    @click="closeMobileMenu"
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
                    @click="closeMobileMenu"
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

        <button
            v-if="mobileMenuOpen"
            class="sidebar-overlay"
            type="button"
            aria-label="Close navigation menu"
            @click="closeMobileMenu"
        />

        <div class="app-main">
            <header class="app-topbar">
                <div class="topbar-leading">
                    <button
                        class="mobile-menu-toggle"
                        type="button"
                        aria-label="Open navigation menu"
                        aria-controls="app-sidebar"
                        :aria-expanded="mobileMenuOpen"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                    >
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
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

                <div ref="profileMenu" class="topbar-profile">
                    <button
                        type="button"
                        class="topbar-profile-trigger"
                        aria-label="Open account menu"
                        aria-controls="profile-menu"
                        :aria-expanded="profileMenuOpen"
                        @click.stop="profileMenuOpen = !profileMenuOpen"
                        @keydown.esc.stop="closeProfileMenu"
                    >
                        <span class="topbar-avatar">{{ getInitials($page.props.auth.user.name) }}</span>
                        <span class="topbar-profile-copy">
                            <strong>{{ $page.props.auth.user.name }}</strong>
                            <span>Account</span>
                        </span>
                        <svg
                            class="profile-chevron"
                            :class="{ 'is-open': profileMenuOpen }"
                            viewBox="0 0 20 20"
                            aria-hidden="true"
                        >
                            <path d="m5 7.5 5 5 5-5" />
                        </svg>
                    </button>

                    <div
                        v-show="profileMenuOpen"
                        id="profile-menu"
                        class="profile-menu"
                        role="group"
                        aria-label="Account options"
                    >
                        <div class="profile-menu-identity">
                            <span class="topbar-avatar">
                                {{ getInitials($page.props.auth.user.name) }}
                            </span>
                            <span class="profile-menu-copy">
                                <strong>{{ $page.props.auth.user.name }}</strong>
                                <span>{{ $page.props.auth.user.email }}</span>
                            </span>
                        </div>
                        <div class="profile-menu-divider" />
                        <Link
                            :href="route('profile.edit')"
                            class="profile-menu-item"
                            @click="closeProfileMenu"
                        >
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="8" r="3.5" />
                                <path d="M5 20a7 7 0 0 1 14 0" />
                            </svg>
                            <span>Profile settings</span>
                        </Link>
                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="profile-menu-item profile-menu-logout"
                            @click="closeProfileMenu"
                        >
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M10 17l5-5-5-5M15 12H3" />
                                <path d="M12 3h5a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5" />
                            </svg>
                            <span>Log out</span>
                        </Link>
                    </div>
                </div>
            </header>

            <main class="app-content">
                <slot />
            </main>

            <footer class="app-footer">
                <span>© {{ currentYear }} Workspace</span>
                <span>Simple tools for a well-run team.</span>
            </footer>
        </div>
    </div>
</template>
