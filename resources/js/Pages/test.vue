<script setup>
import Layout from '@/Layouts/Layout.vue';

let testImg = 'https://sun1-14.userapi.com/impg/L16pctUv_LjgDquGYmrtnIsLOOeePXmizcwUKw/Ms4qi0pf9Bk.jpg?size=1620x2160&quality=95&sign=31e693c2d9c4f43335c97945ffbe8e66&type=album'
</script>

<template>
    <Layout>
        <div class="chat">
            <div class="chat-title">
                <a href="/">Мессенджер</a>
            </div>

            <div class="chat-content" ref="container">
                <div class="messages-item" v-for="item in messagesData">
                    <a :href="'/user/' + item.login" class="messages-item__img">
                        <img :src="testImg" alt="">
                    </a>
                    <div>
                        <div>
                            <a :href="'/user/' + item.login" class="messages-item__name">{{ item.name }}
                                {{ item.surname }}</a>
                            <a :href="'/user/' + item.login" class="messages-item__time">{{ item.time }}</a>
                        </div>
                        <div class="messages-item__body">{{ item.body }}</div>
                    </div>
                </div>
            </div>

            <form class="messages-input" @submit.prevent="storeMessage">
                <input type="text" class="input" placeholder="Введите сообщение" v-model="body">
                <button class="btn btn-primary" type="submit">Отправить</button>
            </form>
        </div>
    </Layout>
</template>


<script>
export default {
    data() {
        return {
            body: '',
            messagesData: this.messages
        }
    },

    props: ['messages'],

    methods: {
        logoutFun() {
            axios.post('/logout');
        },

        storeMessage() {
            axios.post(`/messages`, {
                body: this.body
            }).then(() => {
                this.body = '';
                const container = this.$refs.container;
                container.scrollTop = container.scrollHeight;
            })
        }
    },

    mounted() {
        const container = this.$refs.container;
        container.scrollTop = container.scrollHeight;

        window.Echo.channel('store_message')
            .listen('.store_message', response => {
                this.messagesData.push(response.message)
            })
    }
}
</script>
