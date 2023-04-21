<script setup>
import Layout from '@/Layouts/Layout.vue';

let testImg = 'https://sun1-14.userapi.com/impg/L16pctUv_LjgDquGYmrtnIsLOOeePXmizcwUKw/Ms4qi0pf9Bk.jpg?size=1620x2160&quality=95&sign=31e693c2d9c4f43335c97945ffbe8e66&type=album'
</script>

<template>
    <Layout>
        <div class="friends">
            <div class="friends-title__flex">
                <a href="#" class="friends-title friends-title__active">Все сообщества</a>
                <a href="#" class="friends-title">Мои сообщества</a>
                <a :href="route('create_community')" class="friends-title">Создать сообщество</a>
            </div>

            <div class="search">
                <input type="text" placeholder="Найти друга.." class="input friends-input">
                <button type="submit" class="btn btn-primary">Найти</button>
            </div>

            <div class="friends-flex">
                <a :href="'/community/' + item.id" class="profile friends-flex__item" v-for="item in communities">
                    <div class="profile-top-j">
                        <div class="profile-top">
                            <img class="profile-img" :src="testImg" alt="">
                            <div class="flex-info">
                                <div class="profile-name">{{ item.title }}</div>
                                <div class="profile-desc">{{ item.status }}</div>
                            </div>
                        </div>

                        <button class="btn btn-primary">Подписаться</button>
                    </div>
                </a>
            </div>
        </div>
    </Layout>
</template>


<script>
export default {
    props: ['communities'],

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
