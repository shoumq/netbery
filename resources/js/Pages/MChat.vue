<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Link, Head} from "@inertiajs/vue3";
</script>

<template>
    <Head>
        <title>Сообщения</title>
    </Head>
    <div class="dialog_wrapper" ref="dialog_wrapper" @click="closeModal"></div>
    <Layout>
        <div class="dialog_img">
            <dialog open class="dialog2" ref="imgDialogRef" role="dialog" aria-modal="true">
                <div class="dialog dialog-block">
                    <div>
                        <div class="img-info">
                            <div class="dialog_flex">
                                <form class="flex-d-input" @submit.prevent="changeDialogTitle"
                                      v-if="parseInt(dialog_id.admin_id) === parseInt($page.props.auth.user.id)">
                                    <input type="text" class="input input-modal"
                                           v-model="dialog_name">
                                    <button class="btn btn-primary" style="padding: 5rem 8rem" :disabled="disChange">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                             class="bi bi-check-lg" viewBox="0 0 16 16">
                                            <path
                                                d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                        </svg>
                                    </button>
                                </form>

                                <div class="name"
                                     v-if="parseInt(dialog_id.admin_id) !== parseInt($page.props.auth.user.id)">
                                    {{ dialog_id.dialog_title }}
                                </div>

                                <form method="dialog">
                                    <button class="btn" @click="closeModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                             class="bi bi-x-lg" viewBox="0 0 16 16">
                                            <path
                                                d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <div class="dialog_flex2">
                                <div>
                                    <div class="dialog_time">Все участники</div>

                                    <div class="all_users">

                                        <div class="dialog_user--add"
                                             v-if="parseInt(dialog_id.admin_id) === parseInt($page.props.auth.user.id)">
                                            <input type="text" class="input input-add"
                                                   placeholder="Добавить участника..."
                                                   @input="dropdownBoolFun"
                                                   v-model="searchText">

                                            <div class="dialog_user--abs" v-if="dropdownBool">
                                                <div class="dialog_user--drop">

                                                    <div v-for="(item, index) in searchUserArray[0]" :key="index"
                                                         class="dialog_user--flex" style="cursor: pointer"
                                                         @click="addUser(item.id)">
                                                        <img class="dialog_user--img"
                                                             :src="'../storage/images/' + item.img_id"
                                                             alt="">
                                                        <div class="dialog_user--title">{{ item.name }}
                                                            {{ item.surname }}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div v-for="(item, index) in users" :key="index"
                                             class="dialog_user--flex">
                                            <img class="dialog_user--img" :src="'../storage/images/' + item.user_img"
                                                 alt="">
                                            <div class="dialog_user--title">{{ item.user_name }} {{
                                                    item.user_surname
                                                }}
                                            </div>
                                            <div class="delUser" @click="kickUser(item.user_id)"
                                                 v-if="parseInt(dialog_id.admin_id) === parseInt($page.props.auth.user.id)">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="red" class="bi bi-x"
                                                     viewBox="0 0 16 16">
                                                    <path
                                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="del btn btn-danger" @click="kickMe">Выйти</button>
                            </div>
                        </div>
                    </div>
                </div>
            </dialog>
        </div>

        <div class="chat">
            <div class="chat-title">
                <div class="flex--title" @click="showDialog">
                    <img :src="'../storage/images/' + dialog_id.img_name" alt="">
                    <div>
                        <div class="dialog_title">{{ dialog_id.dialog_title }}</div>
                        <div class="user_count">{{ users_count }} участника(ов)</div>
                    </div>
                </div>
                <button class="btn btn-primary" @click="showDialog"
                        v-if="parseInt(dialog_id.admin_id) === parseInt($page.props.auth.user.id)">
                    Редактировать
                </button>

                <button class="btn btn-primary" @click="showDialog" v-else>Подробнее</button>
            </div>

            <div class="chat-content" ref="container">
                <div class="messages-item" v-for="item in messages">
                    <Link :href="'/user/' + item.login" class="messages-item__img">
                        <img :src="'../storage/images/' + item.user_image"
                             alt="">
                    </Link>
                    <div>
                        <div>
                            <Link :href="'/user/' + item.login" class="messages-item__name">{{ item.user_name }}
                                {{ item.surname }}
                            </Link>
                            <a :href="'/user/' + item.login" class="messages-item__time">{{ item.time }}</a>
                        </div>
                        <div class="messages-item__body">{{ item.body }}</div>
                    </div>
                </div>
            </div>

            <form class="messages-input" @submit.prevent="storeMessage">
                <input type="text" class="input input-mes" placeholder="Введите сообщение" v-model="body" autofocus
                       :disabled="sendButton">
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
    props: ['dialog_id', 'messages', 'users', 'users_count'],

    data() {
        return {
            body: '',
            sendButton: false,
            dialog_name: this.dialog_id.dialog_title,
            disChange: false,
            dropdownBool: false,
            searchText: '',

            searchUserArray: []
        }
    },

    methods: {
        storeMessage() {
            this.sendButton = true
            axios.post(`/store_mess_multi_chat`, {
                body: this.body,
                multi_chat_id: this.dialog_id.id
            })
                .then(() => {
                    this.sendButton = false
                    this.body = ''
                    const container = this.$refs.container;
                    container.scrollTop = container.scrollHeight;
                })
                .catch(() => {
                    this.sendButton = false
                })
        },

        showDialog() {
            this.$refs.imgDialogRef.show()
            document.querySelector('body').style.overflowY = 'hidden';
            this.$refs.dialog_wrapper.style.opacity = '1'
            this.$refs.dialog_wrapper.style.zIndex = '9999998'
        },

        closeModal() {
            this.$refs.imgDialogRef.close()
            document.querySelector('body').style.overflowY = 'auto'
            this.$refs.dialog_wrapper.style.opacity = '0'
            this.$refs.dialog_wrapper.style.zIndex = '0'
        },

        changeDialogTitle() {
            this.disChange = true
            axios.post('/mchat_change_title', {
                chat_id: this.dialog_id.id,
                chat_title: this.dialog_name
            })
                .then(() => {
                    this.disChange = false
                })
        },

        kickMe() {
            axios.post(`/multi_dialog_kick/${this.dialog_id.id}`, {
                user_id: this.$page.props.auth.user.id
            })
                .then(() => {
                    this.$inertia.visit(route('messages'), {method: 'get'});
                })
        },

        kickUser(user_id) {
            axios.post(`/multi_dialog_kick/${this.dialog_id.id}`, {user_id})
                .then(() => {
                    if (parseInt(this.$page.props.auth.user.id) === parseInt(user_id)) {
                        this.$inertia.visit(route('messages'), {method: 'get'});
                    } else {
                        this.users.splice(this.users.findIndex(x => x.user_id === parseInt(user_id)), 1)
                    }
                })
        },

        dropdownBoolFun() {
            if (this.searchText) {
                this.dropdownBool = true

                axios.post('/search_user', {
                    name: this.searchText
                })
                    .then((response) => {
                        this.searchUserArray.length = 0
                        this.searchUserArray.push(response.data)
                    })
                    .catch(() => {
                        console.log('err')
                    })

            } else {
                this.dropdownBool = false
            }
            if (this.searchUserArray[0].length === 0) {
                this.dropdownBool = false
            }
        },

        addUser(user_id) {
            axios.post(`/multi_dialog_add/${this.dialog_id.id}`, {user_id})
                .then((response) => {
                    if (response.data !== "already_exits") {
                        this.users.push(response.data)
                        this.dropdownBool = false
                    } else {
                        this.dropdownBool = false
                    }
                })
        }
    },

    mounted() {
        this.$refs.imgDialogRef.close();

        window.Echo.channel('store_multi_message_' + this.dialog_id.id)
            .listen('.store_multi_message', response => {
                this.messages.push(response.message)

                const container = this.$refs.container;
                container.scrollTop = container.scrollHeight;
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
    padding-bottom: 10rem

.chat
    padding: 10rem

.btn
    font-size: 13rem
    padding: 7rem 14rem

.input-modal
    font-size: 13rem
    padding: 6rem 7rem

.flex-d-input
    display: flex
    align-items: center
    gap: 10rem

.dialog_img
    width: 500rem
    margin: auto

    @media (max-width: 768px)
        width: 100%

.dialog_user
    &--title
        font-size: 12rem

    &--img
        width: 30rem
        height: 30rem
        object-fit: cover
        border-radius: 100rem

    &--flex
        display: flex
        gap: 5rem
        align-items: center

    &--abs
        position: absolute
        top: 30rem

    &--add
        display: flex
        flex-direction: column
        margin-bottom: 10rem
        position: relative
        text-align: start

    &--drop
        position: relative
        height: 100%
        width: 100%
        background: white
        border-radius: 10rem
        border: 1rem solid #dce1e6
        padding: 3rem
        display: flex
        flex-direction: column
        gap: 7rem
        z-index: 9999999999

.dialog_flex2
    align-items: flex-start

.all_users
    margin-top: 15rem
    display: flex
    flex-direction: column
    gap: 7rem

.delUser
    cursor: pointer

.input-add
    padding: 4rem 7rem

.dialog2
    overflow: visible
    border-radius: 10rem

.dialog
    border-radius: 10rem

.flex--title
    display: flex
    align-items: center
    gap: 10rem
    cursor: pointer

    img
        width: 30rem
        height: 30rem
        object-fit: cover
        border-radius: 100rem

.user_count
    font-size: 12rem
    color: gray

    @media (max-width: 768px)
        font-size: 10rem

.dialog_title
    font-size: 14rem
    @media (max-width: 768px)
        font-size: 11rem
</style>
