<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Link, Head} from "@inertiajs/vue3";
</script>

<template>
    <Head>
        <title>Люди</title>
    </Head>
    <Layout>
        <div class="friends">
            <div class="friends-title__flex">
                <Link href="#" class="friends-title">Все люди</Link>
            </div>

            <form class="search" @submit.prevent="searchUsers">
                <input type="text" placeholder="Найти собеседника.." class="input friends-input" v-model="searchInput">
                <ButtonPrimary type="submit">Найти</ButtonPrimary>
            </form>

            <div class="friends-flex">
                <div class="profile friends-flex__item" v-for="item in usersData">
                    <div class="profile-top-j">
                        <Link :href="'/user/' + item.login" class="profile-top">
                            <img class="profile-img" :src="'../storage/images/' + item.img_id" alt="">
                            <div class="flex-info">
                                <div class="profile-name">{{ item.name }} {{ item.surname }}</div>
                                <div class="profile-desc">{{ item.status }}</div>
                                <Link class="profile-info" v-if="item.show_email">Email: {{ item.email }}</Link>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>


<script>
import AllUsersMixin from "@/Mixins/AllUsers.mixin";

export default {
    mixins: [AllUsersMixin]
}
</script>
