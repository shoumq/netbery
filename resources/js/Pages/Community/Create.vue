<script setup>
import Layout from '@/Layouts/Layout.vue';
</script>

<template>
    <Layout>
        <form class="form" @submit.prevent="submit">
            <div class="form-title">Создать сообщество</div>

            <div class="form-input">
                <label for="name" class="form-input__item">
                    Название
                    <input type="text" id="name" class="input" placeholder="Введите название" v-model="title">
                </label>

                <label for="surname" class="form-input__item">
                    Описание
                    <input type="text" id="surname" class="input" placeholder="Введите описание" v-model="status">
                </label>

                <button type="submit" class="btn btn-primary">Создать</button>

            </div>
        </form>
    </Layout>
</template>

<script>
export default {
    data() {
        return {
            title: '',
            status: ''
        }
    },

    methods: {
        submit() {
            axios.post('/create_community', {
                title: this.title,
                status: this.status
            }).then(response => {
                window.location.href = '/community/' + response.data.id
            }).catch(e => {
                console.log(e)
            })
        }
    }
}
</script>
