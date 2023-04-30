<script setup>
import Layout from '@/Layouts/Layout.vue';

let testImg = 'https://sun1-14.userapi.com/impg/L16pctUv_LjgDquGYmrtnIsLOOeePXmizcwUKw/Ms4qi0pf9Bk.jpg?size=1620x2160&quality=95&sign=31e693c2d9c4f43335c97945ffbe8e66&type=album'
</script>

<template>
    <Layout>
        <div class="chat">
            <div class="chat-title">
                <a :href="'/user/' + checkLogin(dialogData.user_one_login, dialogData.user_two_login)">{{
                        checkName(dialogData.user_one, dialogData.user_two)
                    }}</a>
            </div>

            <div class="chat-content" ref="container">
                <div class="messages-item" v-for="item in messagesData">
                    <a :href="'/user/' + item.login" class="messages-item__img">
                        <img :src="'../storage/images/' + item.img_id"
                             alt="">
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
                <input type="text" class="input input-mes" placeholder="Введите сообщение" v-model="body">
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
            messagesData: this.messages,
            dialogData: this.dialog[0]
        }
    },

    props: ['messages', 'dialog'],

    methods: {
        logoutFun() {
            axios.post('/logout');
        },

        storeMessage() {
            axios.post(`/messages/${this.dialogData.id}`, {
                body: this.body
            }).then(() => {
                this.body = '';
                const container = this.$refs.container;
                container.scrollTop = container.scrollHeight;
            })
        },

        checkName(name1, name2) {
            if (name1 === this.$page.props.auth.user.name + ' ' + this.$page.props.auth.user.surname) {
                return name2
            } else {
                return name1
            }
        },

        checkLogin(name1, name2) {
            if (name1 === this.$page.props.auth.user.login) {
                return name2
            } else {
                return name1
            }
        },

        checkImage(name1, name2) {
            if (name1 === this.$page.props.auth.user.img_id) {
                return name2
            } else {
                return name1
            }
        }
    },

    mounted() {
        const container = this.$refs.container;
        container.scrollTop = container.scrollHeight;

        window.Echo.channel('store_message_' + this.dialogData.id)
            .listen('.store_message', response => {
                this.messagesData.push(response.message)
            })
    }
}
</script>


<style lang="sass" scoped>
@media (max-width: 768px)
    .input-mes
        font-size: 10rem

.messages-item
    background: white !important
</style>
