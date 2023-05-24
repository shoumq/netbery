<script setup>
import Layout from '@/Layouts/Layout.vue';

let testImg = 'https://sun1-14.userapi.com/impg/L16pctUv_LjgDquGYmrtnIsLOOeePXmizcwUKw/Ms4qi0pf9Bk.jpg?size=1620x2160&quality=95&sign=31e693c2d9c4f43335c97945ffbe8e66&type=album'
</script>

<template>
    <Layout>
        <div class="content-flex">
            <div class="content-main">
                <div contentEditable="true" class="test">Type here. You can insert images too
                    <img src="http://t2.gstatic.com/images?q=tbn:ANd9GcQCze-mfukcuvzKk7Ilj2zQ0CS6PbOkq7ZhRInnNd1Yz3TQzU4e&t=1" />
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

<style scoped lang="sass">
.test
    font-size: 20rem
    border: 1px solid #ccc
    outline: none
</style>
