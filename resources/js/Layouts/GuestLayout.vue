<script setup>
import {ref} from 'vue';
import {Link} from '@inertiajs/vue3'
</script>

<template>
    <div>
        <header>
            <div class="container">
                <div class="header">
                    <Link :href="route('friends')" class="header-title">ЛЕБЕДЬ</Link>
                    <Link href="/login" class="header-title">Войти</Link>
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
