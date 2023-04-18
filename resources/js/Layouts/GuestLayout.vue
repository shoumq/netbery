<script setup>
import {ref} from 'vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <header>
            <div class="container">
                <div class="header">
                    <a :href="route('friends')" class="header-title">НЕТБЕРИ</a>
                    <a href="/login" class="header-title">Войти</a>
                </div>
            </div>
        </header>

        <div class="container">
            <main>
                <div class="content">
                    <slot></slot>
                </div>
            </main>
        </div>
    </div>
</template>
