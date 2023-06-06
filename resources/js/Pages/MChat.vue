<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Link, Head} from "@inertiajs/vue3";
</script>

<template>
    <Head>
        <title>Сообщения</title>
    </Head>
    <Layout>
        <div class="chat">
            <div class="chat-title">
                <Link>{{ dialog_id.dialog_title }}</Link>
                <Link>{{ dialog_id.dialog_title }}</Link>
            </div>

            <div class="chat-content" ref="container">
                <div class="messages-item" v-for="item in messages">
                    <Link :href="'/user/' + item.login" class="messages-item__img">
                        <img :src="'../storage/images/' + item.user_image"
                             alt="">
                    </Link>
                    <div>
                        <div>
                            <Link :href="'/user/' + item.user_image" class="messages-item__name">{{ item.user_name }}
                                {{ item.surname }}
                            </Link>
                            <a :href="'/user/' + item.login" class="messages-item__time">{{ item.time }}</a>
                        </div>
                        <div class="messages-item__body">{{ item.body }}</div>
                    </div>
                </div>
            </div>

            <form class="messages-input" @submit.prevent="storeMessage">
                <input type="text" class="input input-mes" placeholder="Введите сообщение" v-model="body" autofocus :disabled="sendButton">
                <button class="btn btn-primary" type="submit" :disabled="sendButton">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-send svg"
                         viewBox="0 0 16 16">
                        <path
                            d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                    </svg>
                </button>
            </form>
        </div>
    </Layout>
</template>


<script>
export default {
    props: ['dialog_id', 'messages'],

    data() {
        return {
            body: '',
            sendButton: false
        }
    },

    methods: {
        storeMessage() {
            this.sendButton = true
            axios.post(`/store_mess_multi_chat`, {
                body: this.body,
                multi_chat_id: this.dialog_id.id
            })
                .then((response) => {
                    this.body = ''
                    this.sendButton = false
                })
        }
    },

    mounted() {
        window.Echo.channel('store_multi_message_' + this.dialog_id.id)
            .listen('.store_multi_message', response => {
                console.log(response)
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

input
    border-radius: 100rem !important

.chat-title
    display: flex
    justify-content: space-between
    flex-direction: row
</style>
