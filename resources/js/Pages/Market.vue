<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Link, Head} from "@inertiajs/vue3";
</script>

<template>
    <Head>
        <title>Магазин</title>
    </Head>
    <Layout>
        <div class="profile" v-if="myIcons.length !== 0">
            <div class="title">Мои значки</div>

            <div class="profile_flex">
                <div class="profile_flex-item" v-for="item in myIcons" @click="chooseIcon(item.icon_id)">
                    <div class="profile_flex-item_sh">
                        <img :src="'/storage/user_icons/' + item.icon_id + '.svg'" alt="" class="svg_m">
                    </div>

                    <div class="profile_flex-item_price" v-if="item.icon_id === adminIcon">Выбранно
                    </div>
                    <div class="profile_flex-item_price profile_flex-item_price--active" v-else>Выбрать</div>
                </div>
            </div>
        </div>


        <div class="profile">
            <div class="title">Значки</div>

            <div class="profile_flex">
                <div class="profile_flex-item" v-for="item in allIcons" @click="addIcon(item.icon_id)">
                    <div class="profile_flex-item_sh">
                        <img :src="'/storage/user_icons/' + item.icon_id + '.svg'" alt="" class="svg_m">
                    </div>

                    <div class="profile_flex-item_price">{{ item.price }}.00 ₽</div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
export default {
    props: ['allIcons', 'myIcons'],

    data() {
        return {
            adminIcon: this.$page.props.auth.user.admin
        }
    },

    methods: {
        chooseIcon(icon_id) {
            axios.post('/choose_icon/', {
                iconId: icon_id
            })
                .then(() => {
                    this.adminIcon = icon_id
                })
        },

        addIcon(icon_id) {
            axios.post('/add_icon/', {
                iconId: icon_id
            })
                .then((response) => {
                    if (response.data !== 'err') {
                        this.myIcons.push(response.data)
                    }
                })
        }
    }
}
</script>

<style scoped lang="sass">
.title
    font-size: 15rem
    margin-bottom: 15rem

    @media (max-width: 768px)
        font-size: 11rem

.profile_flex
    display: flex
    gap: 20rem
    flex-wrap: wrap

    &-item
        padding: 10rem 16rem
        box-shadow: 0 0 2rem rgba(0, 0, 0, 0.08), 0 2rem 14rem rgba(0, 0, 0, 0.08)
        border-radius: 5rem
        cursor: pointer
        transition: .2s
        user-select: none

        @media (max-width: 768px)
            padding: 5rem 14rem

        &:hover
            box-shadow: 0 0 2rem rgba(0, 0, 0, 0.12), 0 2rem 14rem rgba(0, 0, 0, 0.12)

        &_price
            margin-top: 10rem
            font-size: 14rem
            text-align: center

            @media (max-width: 768px)
                font-size: 10rem

        &_sh
            text-align: center

.svg_m
    width: 60rem
    height: 60rem
    object-fit: cover

    @media (max-width: 768px)
        width: 45rem
        height: 45rem

.profile
    padding: 15rem 15rem
    width: calc(100% - 30rem)
</style>
