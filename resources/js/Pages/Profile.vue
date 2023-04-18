<script setup>
import Layout from '@/Layouts/Layout.vue';

let testImg = 'https://sun1-14.userapi.com/impg/L16pctUv_LjgDquGYmrtnIsLOOeePXmizcwUKw/Ms4qi0pf9Bk.jpg?size=1620x2160&quality=95&sign=31e693c2d9c4f43335c97945ffbe8e66&type=album'
</script>

<template>
    <Layout>
        <div class="profile">
            <div class="profile-top-j">
                <div class="profile-top">
                    <img class="profile-img" :src="testImg" alt="">
                    <div class="flex-info">
                        <div class="profile-name">{{user.name}} {{user.surname}}</div>
                        <div class="profile-desc">{{user.status}}</div>
<!--                        <a href="#" class="profile-info">-->
<!--                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"-->
<!--                                 class="bi bi-info-circle" viewBox="0 0 16 16">-->
<!--                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>-->
<!--                                <path-->
<!--                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>-->
<!--                            </svg>-->
<!--                            Подробнее</a>-->

                        <a class="profile-info">Email: {{user.email}}</a>
                    </div>
                </div>

                <div class="profile-top__b">
                    <button class="btn btn-primary">Редактировать</button>
                    <button class="btn btn-primary" type="submit" @click="logoutFun">Выйти</button>
                </div>
            </div>
        </div>


        <div class="content-flex">
            <div class="content-main">
                <form class="input-news">
                    <input type="text" class="input" placeholder="Что у вас нового?">
                    <button type="submit" class="btn btn-primary">Опубликовать</button>
                </form>

                <div class="posts">
                    <div class="posts-item">
                        <div class="posts-item__flex">
                            <div>
                                <img class="posts-item__img" :src="testImg" alt="">
                            </div>
                            <div>
                                <div class="posts-item__title">{{user.name}}
                                </div>
                                <div class="posts-item__time">6 сен 2022</div>
                            </div>
                        </div>

                        <div class="posts-item__content">Работаем!</div>

                        <div class="like-flex">
                            <div class="like">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray"
                                     class="bi bi-heart-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                          d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                </svg>
                            </div>
                            <div class="like-count">10</div>
                        </div>
                    </div>


                    <div class="posts-item">
                        <div class="posts-item__flex">
                            <div>
                                <img class="posts-item__img" :src="testImg" alt="">
                            </div>
                            <div>
                                <div class="posts-item__title">{{user.name}}
                                </div>
                                <div class="posts-item__time">6 сен 2022</div>
                            </div>
                        </div>

                        <div class="posts-item__content">Работаем!</div>

                        <div class="like-flex">
                            <div class="like">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray"
                                     class="bi bi-heart-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                          d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                </svg>
                            </div>
                            <div class="like-count">10</div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="content-info">
                <a href="#" class="content-info__title">Друзья {{users}}</a>

                <div class="content-info__flex">
                    <a href="#" class="content-info__item">
                        <img class="content-info__item-img" :src="testImg" alt="">
                        <div class="content-info__item-title">Андрей</div>
                    </a>

                    <a href="#" class="content-info__item">
                        <img class="content-info__item-img" :src="testImg" alt="">
                        <div class="content-info__item-title">Андрей</div>
                    </a>

                    <a href="#" class="content-info__item">
                        <img class="content-info__item-img" :src="testImg" alt="">
                        <div class="content-info__item-title">Андрей</div>
                    </a>
                </div>
            </div>
        </div>
    </Layout>
</template>


<script>
export default {
    props: ['user'],

    methods: {
        logoutFun() {
            axios.post('/logout')
                .then(() => {
                    window.location.href = '/login'
                })
        }
    }
}
</script>
