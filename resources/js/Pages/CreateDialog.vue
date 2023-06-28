<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Head} from "@inertiajs/vue3";
</script>

<template>
    <Head>
        <title>Создать беседу</title>
    </Head>
    <Layout>
        <form class="form" @submit.prevent="submit">
            <div class="form-title">Создать беседу</div>

            <div class="form-input">

                <label class="input-file" style="cursor:pointer;">
                    <input type="file" name="file" class="file-input" @change="storeImage" :disabled="disButton">
                    <img class="profile-img" :src="filenameData" alt="">
                </label>

                <label for="name" class="form-input__item">
                    Название
                    <input type="text" id="name" class="input" placeholder="Введите название" v-model="title" :disabled="disButton">
                </label>

                <button type="submit" class="btn btn-primary" :disabled="disButton">Создать</button>

            </div>
        </form>
    </Layout>
</template>

<script>
export default {
    data() {
        return {
            title: '',
            status: '',
            filenameData: '../storage/images/i.png',
            formData: {},
            disButton: false
        }
    },

    methods: {
        storeImage(event) {
            this.filename = event.target.files[0].name;
            this.file = event.target.files[0];
            this.filenameData = URL.createObjectURL(this.file);
        },

        submit() {
            this.disButton = true
            this.formData = new FormData();
            this.formData.append('file', this.file);
            this.formData.append('dialog_title', this.title);

            axios.post(`/create_multi_dialog_post`, this.formData)
                .then(() => {
                    this.$inertia.visit(route('messages'), {method: 'get'});
                    this.disButton = false
                })
        }
    }
}
</script>

<style lang="sass" scoped>
.file-input
    display: none

.input-file
    transition: 0.3s
    text-align: center
    margin-top: 20rem

    &:hover
        filter: brightness(60%)
</style>
