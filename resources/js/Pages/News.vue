<script setup>
import Layout from '@/Layouts/Layout.vue';

let testImg = 'https://sun1-14.userapi.com/impg/L16pctUv_LjgDquGYmrtnIsLOOeePXmizcwUKw/Ms4qi0pf9Bk.jpg?size=1620x2160&quality=95&sign=31e693c2d9c4f43335c97945ffbe8e66&type=album'
</script>

<template>
    <Layout>
        <div class="content-flex">
            <div class="content-main">
                <!--                <form class="input-news" @submit.prevent="storePost">-->
                <!--                    <input type="text" class="input" placeholder="Что у вас нового?" v-model="body" name="body">-->
                <!--                    <button type="submit" class="btn btn-primary">Опубликовать</button>-->
                <!--                </form>-->

                <div class="title">Новости</div>

                <div class="posts">
                    <div v-for="(item, index) in postsData" :key="index" class="posts">
                        <div v-for="i in item.posts">
                            <div class="posts-item">
                                <div class="posts-item__flex">
                                    <a :href="'/community/' + item.community[0].id">
                                        <img class="posts-item__img"
                                             :src="'../storage/images/' + item.community[0].img_id"
                                             alt="">
                                    </a>
                                    <div>
                                        <a :href="'/community/' + item.community[0].id" class="flex">
                                            <div class="posts-item__title">{{ item.community[0].title }}</div>
                                            <div v-if="item.community[0].isVerified === '1'">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="#0d6efd"
                                                     class="bi bi-patch-check"
                                                     viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                          d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                    <path
                                                        d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911l-1.318.016z"/>
                                                </svg>
                                            </div>
                                        </a>
                                        <div class="posts-item__time">{{ getTime(i.created_at) }}</div>
                                    </div>
                                </div>
                                <div class="posts-item__content">{{ i.body }}</div>
                            </div>
                        </div>
                    </div>

                    <!--                    <div style="font-size: 20rem;">{{item}}</div>-->
                </div>
            </div>
        </div>
    </Layout>
</template>


<script>
export default {
    data() {
        return {
            body: '',
            postsData: this.result
        }
    },

    methods: {
        storePost() {
            axios.post(`/post/${this.$page.props.auth.user.id}`, {
                body: this.body
            }).then((response) => {
                this.body = ''
                postsData.unshift(response.data)
            })
        },

        getTime(time) {
            return time.split(':')[0] + ':' + time.split(':')[1]
        }
    },

    props: ['posts', 'result'],
}
</script>

<style scoped>
.posts {
    margin-top: 0 !important;
}

.title {
    font-size: 20rem;
    margin-bottom: 15rem;
}

.flex {
    display: flex;
    align-items: center;
    gap: 7rem;
}

.flex svg {
    width: 14rem;
    height: 14rem;
}

a {
    color: #333333;
}
</style>
