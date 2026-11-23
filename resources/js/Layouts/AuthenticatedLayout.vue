<script setup>
import Header from '@/Components/Header.vue';
import LeftMenu from '@/Components/LeftMenu.vue';
import Footer from '@/Components/Footer.vue';

</script>

<template>
    <div class="app-shell">
        <LeftMenu />

        <div class="app-main">
            <Header />

            <main class="app-content">
                <slot />
            </main>

          <Footer/>
        </div>
    </div>
</template>
