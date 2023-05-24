<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Head} from "@inertiajs/vue3";
</script>

<template>
    <Head>
        <title>Фотографии</title>
    </Head>
    <div class="dialog_wrapper" ref="dialog_wrapper"></div>
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
                                <div class="dialog_time">{{ currentTime }}</div>

                                <button class="del btn btn-danger" @click="deleteImage" v-if="isCurrentUser">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" class="bi bi-trash3 svg"
                                         viewBox="0 0 16 16">
                                        <path
                                            d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                    </svg>
                                </button>
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
                <img @click="showDialog(item.name, item.time, item.id)" class="img-pages"
                     :src="'../storage/images/' + item.name" alt=""
                     v-for="item in resultData"
                     style="box-shadow: 0 0 2rem rgba(0, 0, 0, 0.08),0 2rem 14rem rgba(0, 0, 0, 0.08)">
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
            currentTime: '',
            currentId: '',
            filename: '',
            file: '',
            filenameData: ''
        }
    },

    methods: {
        sortArr() {
            for (let i = 0; i < this.imagesData.length; i++) {
                if (this.imagesData[i].name.split('.').at(-1) === 'jpg' || this.imagesData[i].name.split('.').at(-1) === 'jpeg' || this.imagesData[i].name.split('.').at(-1) === 'png') {
                    this.resultData.push(this.imagesData[i])
                }
            }
        },

        showDialog(name_img, time_img, id_img) {
            this.$refs.imgDialogRef.show()
            this.currentImage = name_img
            this.currentTime = time_img.split(':')[0].split('T')[0]
            this.currentId = id_img

            document.querySelector('body').style.overflowY = 'hidden';
            this.$refs.dialog_wrapper.style.opacity = '1'
            this.$refs.dialog_wrapper.style.zIndex = '9999998'
        },

        closeModal() {
            document.querySelector('body').style.overflowY = 'auto'
            this.$refs.dialog_wrapper.style.opacity = '0'
            this.$refs.dialog_wrapper.style.zIndex = '0'
        },

        storeImage(event) {
            this.filename = event.target.files[0].name;
            this.file = event.target.files[0];

            let formData = new FormData();
            formData.append('file', this.file);

            axios.post(`/add_images/`, formData)
                .then((response) => {
                    this.filenameData = response.data.filename;
                    console.log(response.data)
                    this.resultData.unshift(response.data)
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
