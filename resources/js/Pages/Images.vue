<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Head} from "@inertiajs/vue3";
</script>

<template>
    <Head>
        <title>Фотографии</title>
    </Head>
    <Layout>
        <div class="dialog_img">
            <dialog open class="dialog2" ref="imgDialogRef" role="dialog" aria-modal="true">
                <div class="dialog dialog-block">
                    <div class="img">
                        <img :src="'../storage/images/' + currentImage" alt="">

                        <div class="img-info">
                            <div class="dialog_flex">
                                <div class="name">{{ user.name }} {{ user.surname }}</div>

                                <form method="dialog">
                                    <button class="btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                             class="bi bi-x-lg" viewBox="0 0 16 16">
                                            <path
                                                d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </dialog>
        </div>


        <div class="friends">
            <div class="friends-flex__2">
                <div class="pages-flex__name">{{ user.name }} {{ user.surname }}</div>

                <label class="input-file" style="cursor:pointer;" v-if="user.id === $page.props.auth.user.id">
                    <input type="file" name="file" class="file-input" @change="storeImage">
                    <div class="btn btn-primary">Загрузить фото</div>
                </label>
            </div>

            <div class="pages-flex">
                <img @click="showDialog(item)" class="img-pages" :src="'../storage/images/' + item" alt=""
                     v-for="item in resultData" style="box-shadow: 0 0 2rem rgba(0, 0, 0, 0.08),0 2rem 14rem rgba(0, 0, 0, 0.08)">
            </div>
        </div>
    </Layout>
</template>


<script>
export default {
    props: ['images', 'user'],

    data() {
        return {
            imagesData: this.images.slice().reverse(),
            resultData: [],
            currentImage: 'i.png',
            filename: '',
            file: '',
            filenameData: ''
        }
    },

    methods: {
        sortArr() {
            for (let i = 0; i < this.imagesData.length; i++) {
                if (this.imagesData[i].name.split('.').at(-1) === 'jpg' || this.imagesData[i].name.split('.').at(-1) === 'jpeg' || this.imagesData[i].name.split('.').at(-1) === 'png') {
                    this.resultData.push(this.imagesData[i].name)
                }
            }
        },

        showDialog(name_img) {
            this.$refs.imgDialogRef.show()
            this.currentImage = name_img
        },

        storeImage(event) {
            this.filename = event.target.files[0].name;
            this.file = event.target.files[0];

            let formData = new FormData();
            formData.append('file', this.file);

            axios.post(`/add_images/`, formData)
                .then((response) => {
                    this.filenameData = response.data.filename;
                    this.resultData.unshift(this.filenameData)
                })
        },
    },

    mounted() {
        this.sortArr();
        this.$refs.imgDialogRef.close();
    }
}
</script>


<style scoped lang="sass">
.pages-flex
    display: flex
    //flex-direction: row
    flex-wrap: wrap
    width: 100%
    gap: 7rem
    margin-top: 20rem

    img
        cursor: pointer

    &__name
        font-size: 15rem
        margin-bottom: 10rem


.img-pages
    flex: 0 0 32.5%
    width: 120rem
    height: 350rem
    object-fit: cover
    border: 1px solid #dce1e6
    border-radius: 5rem

    @media (max-width: 768px)
        flex: 0 0 48%
        height: 130rem

.file-input
    display: none

.input-file
    margin-bottom: 10rem
</style>
