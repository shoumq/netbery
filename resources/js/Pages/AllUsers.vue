<script setup>
import Layout from '@/Layouts/Layout.vue';

let testImg = 'https://sun1-14.userapi.com/impg/L16pctUv_LjgDquGYmrtnIsLOOeePXmizcwUKw/Ms4qi0pf9Bk.jpg?size=1620x2160&quality=95&sign=31e693c2d9c4f43335c97945ffbe8e66&type=album'
</script>

<template>
    <Layout>
        <div class="friends">
            <div class="friends-title__flex">
<!--                <a href="#" class="friends-title friends-title__active">Друзья</a>-->
                <a href="#" class="friends-title">Все люди</a>
            </div>

            <div class="search">
                <input type="text" placeholder="Найти собеседника.." class="input friends-input" v-model="searchInput">
                <button type="submit" class="btn btn-primary" @click="searchUsers">Найти</button>
            </div>

            <div class="friends-flex">
                <div class="profile friends-flex__item" v-for="item in usersData">
                    <div class="profile-top-j">
                        <a :href="'/user/' + item.login" class="profile-top">
                            <img class="profile-img" :src="testImg" alt="">
                            <div class="flex-info">
                                <div class="profile-name">{{ item.name }} {{ item.surname }}</div>
                                <div class="profile-desc">{{ item.status }}</div>
                                <a class="profile-info">Email: {{ item.email }}</a>
                            </div>
                        </a>

                        <button @click="createDialog" class="btn btn-primary" v-if="item.id !== $page.props.auth.user.id">Написаить сообщение</button>
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
