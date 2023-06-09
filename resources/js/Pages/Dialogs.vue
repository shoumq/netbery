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
            <div class="chat-title chat-title__dialog">
                <Link href="/">Мессенджер</Link>
                <Link href="/create_multi_dialog/" class="btn btn-primary" style="color: white">Создать беседу</Link>
            </div>

            <div class="chat-content" ref="container">
                <div v-for="item in col">
                    <div v-if="item.type === 'private'">
                        <Link class="messages-item" :href="'/chat/' + item.id"
                              v-if="item.last_message_body.length !== 0">
                            <Link :href="'/user/' + checkName(item.user_one_login, item.user_two_login)"
                                  class="messages-item__img">
                                <img :src="'../storage/images/' + checkImage(item.user_one_img, item.user_two_img)"
                                     alt="">
                            </Link>
                            <div class="flex-c">
                                <a class="messages-item__name">{{ checkName(item.user_one, item.user_two) }}</a>
                                <a class="messages-item__mess"
                                   v-if="parseInt(item.last_message_body[0].from_id) === parseInt($page.props.auth.user.id)">Вы:
                                    {{ item.last_message_body[0].body }}</a>
                                <a class="messages-item__mess" v-else>{{ item.last_message_body[0].body }}</a>
                            </div>
                        </Link>
                    </div>

                    <div v-if="item.type === 'public'">
                        <Link :href="'/mchat/' + item.multi_chat_id" class="messages-item">
                            <Link :href="'/mchat/' + item.multi_chat_id" class="messages-item__img">
                                <img :src="'../storage/images/' + item.multi_chat_img"
                                     alt="">
                            </Link>
                            <div class="flex-c">
                                <a class="messages-item__name">{{ item.multi_chat_title }}</a>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>


<script>
export default {
    data() {
        return {
            body: '',
            dialogsData: this.dialogs,
            isOnline: false,
            lastOnline: []
        }
    },

    props: ['dialogs', 'dialogs_id', 'multi_chats', 'col', 'col2'],

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

        checkImage(name1, name2) {
            if (name1 === this.$page.props.auth.user.img_id) {
                return name2
            } else {
                return name1
            }
        },
    },
}
</script>

<style scoped>
.chat-content {
    gap: 0 !important;
}

.messages-item {
    display: flex;
    align-items: center !important;
    border-bottom: 1px solid #dce1e6;
    padding: 10rem 0;
}

.flex-c {
    display: flex;
    flex-direction: column;
}

.chat-title__dialog {
    display: flex;
    justify-content: space-between;
    flex-direction: row;
    padding-bottom: 10rem;
}

.chat {
    padding: 10rem
}

.btn {
    font-size: 13rem;
    padding: 7rem 14rem;
}
</style>
