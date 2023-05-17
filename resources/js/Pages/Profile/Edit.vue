<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Head} from "@inertiajs/vue3";
</script>

<template>
    <Head>
        <title>Реадкитровать профиль</title>
    </Head>
    <Layout>
        <div class="main">
            <div class="dir">
                <div class="dir_title">Общее</div>
                <input type="text" placeholder="Введите имя" class="input input-status" v-model="name">
                <input type="text" placeholder="Введите фамилию" class="input input-status" v-model="surname">
                <input type="text" placeholder="Введите почту" class="input input-status" v-model="email">
                <button class="btn btn-primary" @click="updateProfile">Подтвердить</button>
            </div>

            <div class="dir">
                <div class="dir_title">Пароль</div>
                <input type="text" placeholder="Введите пароль" class="input input-status" v-model="pass1">
                <input type="text" placeholder="Повторите пароль" class="input input-status" v-model="pass2">
                <button class="btn btn-primary" @click="setPassword">Подтвердить</button>
            </div>
        </div>
    </Layout>
</template>

<script>
export default {
    data() {
        return {
            name: this.user.name,
            surname: this.user.surname,
            email: this.user.email,
            pass1: '',
            pass2: ''
        }
    },

    props: ['user'],

    methods: {
        updateProfile() {
            axios.post('/update_profile/', {
                name: this.name,
                surname: this.surname,
                email: this.email
            })
        },

        setPassword() {
            if (this.pass1 === this.pass2) {
                axios.post('/user/set_password/', {
                    password: this.pass1
                })
                    .then((response) => {
                        console.log(response)
                    })
            }
        }
    },
}
</script>

<style lang="sass" scoped>
.main
    display: flex
    flex-direction: column
    gap: 25rem

.btn
    border-radius: 10rem
    font-size: 13rem

    @media (max-width: 768px)
        font-size: 12rem

.dir
    display: block
    background: white
    padding: 12rem
    border-radius: 10rem
    border: 1rem solid #dce1e6

    &_title
        font-size: 15rem
        margin-bottom: 14rem
        font-weight: 500
        color: #484848

    input
        display: block
        margin-bottom: 15rem
        width: 500rem
        background: #f4f5f6

        @media (max-width: 768px)
            width: calc(100% - 20rem)
</style>
