<script setup>
import Layout from '@/Layouts/Layout.vue';

let testImg = 'https://sun1-14.userapi.com/impg/L16pctUv_LjgDquGYmrtnIsLOOeePXmizcwUKw/Ms4qi0pf9Bk.jpg?size=1620x2160&quality=95&sign=31e693c2d9c4f43335c97945ffbe8e66&type=album'
</script>

<template>
    <Layout>
        <div class="content-flex">
            <div class="content-main">
                <div class="posts">
                    <input type="file" ref="image" id="image" accept="image/*" @change="storeImage">
                    <button type="submit" class="btn btn-primary" name="image">Отправить</button>
                </div>
            </div>
        </div>
    </Layout>
</template>


<script>
export default {
    data() {
        return {
            filename: '',
            file: '',
        }
    },

    methods: {
        storeImage(event) {
            this.filename = event.target.files[0].name;
            this.file = event.target.files[0];

            let formData = new FormData();
            formData.append('file', this.file);

            axios.post(`/user/update_image/`, formData)
                .then((response) => {
                    console.log(response.data)
                })
        },
    },
}
</script>
