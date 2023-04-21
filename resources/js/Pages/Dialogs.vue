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
                <a class="messages-item" v-for="item in dialogsData" :href="'/chat/' + item.id" >
                    <a :href="'/user/' + item.login" class="messages-item__img">
                        <img :src="testImg" alt="">
                    </a>
                    <div>
                        <a class="messages-item__name">{{ checkName(item.user_one, item.user_two) }}</a>
                    </div>
                </a>
            </div>
        </div>
    </Layout>
</template>


<script>
export default {
    data() {
        return {
            body: '',
            dialogsData: this.dialogs
        }
    },

    props: ['dialogs'],

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
        }
    },

    // mounted() {
    //     const container = this.$refs.container;
    //     container.scrollTop = container.scrollHeight;
    //
    //     window.Echo.channel('store_message')
    //         .listen('.store_message', response => {
    //             this.dialogsData.push(response.message)
    //         })
    // }
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

.messages-item:last-child {
    border-bottom: none;
}
</style>
