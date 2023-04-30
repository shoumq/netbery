<script setup>
import Layout from '@/Layouts/Layout.vue';

let testImg = 'https://sun1-14.userapi.com/impg/L16pctUv_LjgDquGYmrtnIsLOOeePXmizcwUKw/Ms4qi0pf9Bk.jpg?size=1620x2160&quality=95&sign=31e693c2d9c4f43335c97945ffbe8e66&type=album'
</script>

<template>
    <Layout>
        <div class="friends">
            <div class="friends-title__flex">
                <a href="/communities" class="friends-title friends-title__active">Все сообщества</a>
                <a href="/my_communities" class="friends-title">Мои сообщества</a>
                <a :href="route('create_community')" class="friends-title">Создать сообщество</a>
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
