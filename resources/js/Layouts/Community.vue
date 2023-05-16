<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Link} from '@inertiajs/vue3'
</script>

<template>
    <Layout>
        <div class="friends">
            <div class="friends-title__flex">
                <Link href="/communities" class="friends-title friends-title__active">Все сообщества</Link>
                <Link href="/my_communities" class="friends-title">Мои сообщества</Link>
                <Link :href="route('create_community')" class="friends-title">Создать сообщество</Link>
            </div>

            <div class="search">
                <input type="text" placeholder="Найти друга.." class="input friends-input">
                <button type="submit" class="btn btn-primary">Найти</button>
            </div>

            <slot></slot>
        </div>
    </Layout>
</template>


<script>
export default {
    props: ['communities', 'user'],

    data() {
        return {
            communitiesData: this.communities
        }
    }
}
</script>


<style scoped>
.flex-info {
    gap: 15rem !important;
}
</style>
