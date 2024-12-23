<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Link, Head} from "@inertiajs/vue3";
</script>

<template>
    <Head>
        <title>Сообщества</title>
    </Head>
    <Layout>
        <div class="friends">
            <div class="friends-title__flex">
                <Link href="/communities" class="friends-title">Все сообщества</Link>
                <Link href="" class="friends-title friends-title__active">Мои сообщества</Link>
                <Link :href="route('create_community')" class="friends-title">Создать сообщество</Link>
            </div>

            <div class="search">
                <input type="text" placeholder="Найти сообщество.." class="input friends-input">
                <button type="submit" class="btn btn-primary">Найти</button>
            </div>

            <div class="friends-flex">
                <Link :href="'/community/' + item.community[0].id" class="profile friends-flex__item" v-for="item in communitiesData">
                    <div class="profile-top-j">
                        <div class="profile-top">
                            <img class="profile-img" :src="'../storage/images/' + item.community[0].img_id" alt="">
                            <div class="flex-info">
                                <div class="flex">
                                    <div class="profile-name">{{ item.community[0].title }}</div>
                                    <div v-if="item.community[0].isVerified === '1'">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="#0d6efd" class="bi bi-patch-check" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                            <path d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911l-1.318.016z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="profile-desc">{{ item.community[0].status }}</div>
                            </div>
                        </div>

<!--                        <button class="btn btn-primary">Отписаться</button>-->
                    </div>
                </Link>
            </div>
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
