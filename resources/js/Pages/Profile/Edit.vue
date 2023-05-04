<script setup>
import Layout from '@/Layouts/Layout.vue';
</script>

<template>
    <Layout>
        <div class="main">
            <div class="dir">
                <input type="text" placeholder="Введите имя" class="input input-status" v-model="name">
                <button class="btn btn-primary" @click="setName">Подтвердить имя</button>
            </div>

            <div class="dir">
                <input type="text" placeholder="Введите фамилию" class="input input-status" v-model="surname">
                <button class="btn btn-primary" @click="setSurname">Подтвердить фамилию</button>
            </div>

            <div class="dir">
                <input type="text" placeholder="Введите почту" class="input input-status" v-model="email">
                <button class="btn btn-primary" @click="setEmail">Подтвердить почту</button>
            </div>

            <div class="dir">
                <input type="text" placeholder="Введите пароль" class="input input-status" v-model="pass1">
                <input type="text" placeholder="Повторите пароль" class="input input-status" v-model="pass2">
                <button class="btn btn-primary" @click="setPassword">Подтвердить пароль</button>
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
        setName() {
            axios.post('/user/set_name/', {
                name: this.name
            })
        },

        setSurname() {
            axios.post('/user/set_surname/', {
                surname: this.surname
            })
        },

        setEmail() {
            axios.post('/user/set_email/', {
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
    }
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

.dir
    display: block
    background: white
    padding: 12rem
    border-radius: 10rem
    border: 1rem solid #dce1e6

    input
        display: block
        margin-bottom: 15rem
        width: 500rem
        background: #f4f5f6
</style>
