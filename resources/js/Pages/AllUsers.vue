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
<!--                <a href="#" class="friends-title friends-title__active">Друзья</a>-->
                <Link href="#" class="friends-title">Все люди</Link>
            </div>

            <div class="search">
                <input type="text" placeholder="Найти собеседника.." class="input friends-input" v-model="searchInput">
                <button type="submit" class="btn btn-primary" @click="searchUsers">Найти</button>
            </div>

            <div class="friends-flex">
                <div class="profile friends-flex__item" v-for="item in usersData">
                    <div class="profile-top-j">
                        <Link :href="'/user/' + item.login" class="profile-top">
                            <img class="profile-img" :src="'../storage/images/' + item.img_id" alt="">
                            <div class="flex-info">
                                <div class="profile-name">{{ item.name }} {{ item.surname }}</div>
                                <div class="profile-desc">{{ item.status }}</div>
                                <Link class="profile-info">Email: {{ item.email }}</Link>
                            </div>
                        </Link>

<!--                        <button @click="createDialog" class="btn btn-primary" v-if="item.id !== $page.props.auth.user.id">Написаить сообщение</button>-->
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>


<script>
export default {
    props: ['users'],

    data() {
        return {
            searchInput: '',
            usersData: this.users
        }
    },

    methods: {
        createDialog() {
            axios.post('/create_dialog/', {
                id: this.user.id
            }).then(response => {
                window.location.href = `/chat/${response.data}`
            })
        },

        searchUsers() {
            axios.post('/search_friends/', {
                searchInput: this.searchInput
            }).then(response => {
                console.log(response)
            })
        }
    }
}
</script>
