<script setup>
import Layout from '@/Layouts/Layout.vue';

let testImg = 'https://sun1-14.userapi.com/impg/L16pctUv_LjgDquGYmrtnIsLOOeePXmizcwUKw/Ms4qi0pf9Bk.jpg?size=1620x2160&quality=95&sign=31e693c2d9c4f43335c97945ffbe8e66&type=album'
</script>

<template>
    <Layout>
        <div class="friends">
            <div class="friends-title__flex">
                <a href="#" class="friends-title friends-title__active">Друзья</a>
                <a href="#" class="friends-title">Найти друзей</a>
            </div>

            <div class="search">
                <input type="text" placeholder="Найти друга.." class="input friends-input">
                <button type="submit" class="btn btn-primary">Найти</button>
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

                        <button class="btn btn-primary" v-if="item.id !== $page.props.auth.user.id">Написаить сообщение</button>
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
            usersData: this.users
        }
    }
}
</script>
