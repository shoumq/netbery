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
                <Link :href="'/user/' + checkLogin(dialogData.user_one_login, dialogData.user_two_login)">{{
                        checkName(dialogData.user_one, dialogData.user_two)
                    }}
                    <div :class="{'round': true, 'round-green': isOnline}"></div>
                </Link>
                <div class="chat-title__time" v-if="!isOnline">В сети: {{ lastOnline }}</div>
            </div>

            <div class="chat-content" ref="container">
                <div class="messages-item" v-for="item in messagesData">
                    <Link :href="'/user/' + item.login" class="messages-item__img">
                        <img :src="'../storage/images/' + item.img_id"
                             alt="">
                    </Link>
                    <div>
                        <div>
                            <Link :href="'/user/' + item.login" class="messages-item__name">{{ item.name }}
                                {{ item.surname }}
                            </Link>
                            <a :href="'/user/' + item.login" class="messages-item__time">{{ item.time }}</a>
                        </div>
                        <div class="messages-item__body">{{ item.body }}</div>
                    </div>
                </div>
            </div>

            <form class="messages-input" @submit.prevent="storeMessage">
                <input type="text" class="input input-mes" placeholder="Введите сообщение" v-model="body" autofocus>
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
    data() {
        return {
            body: '',
            messagesData: this.messages,
            dialogData: this.dialog[0],
            isOnline: false,
            lastOnline: [],
            sendButton: false
        }
    },

    props: ['messages', 'dialog'],

    methods: {
        logoutFun() {
            axios.post('/logout');
        },

        storeMessage() {
            this.sendButton = true
            axios.post(`/messages/${this.dialogData.id}`, {
                body: this.body
            })
                .then(() => {
                    this.sendButton = false
                    this.body = '';
                    const container = this.$refs.container;
                    container.scrollTop = container.scrollHeight;
                })
                .catch(() => {
                    this.sendButton = false
                })
        },

        checkName(name1, name2) {
            if (name1 === this.$page.props.auth.user.name + ' ' + this.$page.props.auth.user.surname) {
                return name2
            } else {
                return name1
            }
        },

        checkId(name1, name2) {
            if (name1 === this.$page.props.auth.user.id) {
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
        },

        getUserTime() {
            axios.get('/get_online/' + this.checkId(this.dialogData.user_one_id, this.dialogData.user_two_id))
                .then((response) => {
                    this.isOnline = parseInt(response.data.result.split(':')[0]) === 0 && parseInt(response.data.result.split(':')[1]) === 0 && parseInt(response.data.result.split(':')[2]) < 15;
                    if (this.isOnline === false) {
                        this.lastOnline = response.data.time
                    } else {
                        this.lastOnline = ''
                    }

                    this.onlineTime = {
                        "seconds": parseInt(response.data.result.split(':')[2]),
                        "user_id": this.$page.props.auth.user.id
                    }
                })
        },
    },

    setup() {
        this.getUserTime();
    },

    mounted() {
        this.getUserTime();
        setInterval(this.getUserTime, 5000)

        const container = this.$refs.container;
        container.scrollTop = container.scrollHeight;

        window.Echo.channel('store_message_' + this.dialogData.id)
            .listen('.store_message', response => {
                this.messagesData.push(response.message)

                // const container = this.$refs.container;
                try {
                    this.$refs.container.scrollTop = this.$refs.container.scrollHeight;
                } catch (e) {
                    console.log(e)
                    window.location.reload()
                }
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
</style>
