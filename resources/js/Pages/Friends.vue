<script setup>
import Layout from '@/Layouts/Layout.vue';

let testImg = 'https://sun1-14.userapi.com/impg/L16pctUv_LjgDquGYmrtnIsLOOeePXmizcwUKw/Ms4qi0pf9Bk.jpg?size=1620x2160&quality=95&sign=31e693c2d9c4f43335c97945ffbe8e66&type=album'
</script>

<template>
    <Layout>
        <div class="friends">
            <div class="friends-title__flex">
                <a href="#" class="friends-title friends-title__active">Друзья</a>
                <a href="#" class="friends-title">Найти друзей</a>
            </div>

            <div class="search">
                <input type="text" placeholder="Найти друга.." class="input friends-input">
                <button type="submit" class="btn btn-primary">Найти</button>
            </div>

            <div class="friends-flex">
                <div class="profile friends-flex__item">
                    <div class="profile-top-j">
                        <div class="profile-top">
                            <img class="profile-img" :src="testImg" alt="">
                            <div class="flex-info">
                                <div class="profile-name">Андрей Лясковский</div>
                                <div class="profile-desc">Я это сделал</div>
                                <a href="#" class="profile-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor"
                                         class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path
                                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path
                                            d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                    Подробнее</a>
                            </div>
                        </div>

                        <button class="btn btn-primary">Написаить сообщение</button>
                    </div>
                </div>


                <div class="profile friends-flex__item">
                    <div class="profile-top-j">
                        <div class="profile-top">
                            <img class="profile-img" :src="testImg" alt="">
                            <div class="flex-info">
                                <div class="profile-name">Андрей Лясковский</div>
                                <div class="profile-desc">Я это сделал</div>
                                <a href="#" class="profile-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor"
                                         class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path
                                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path
                                            d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                    Подробнее</a>
                            </div>
                        </div>

                        <button class="btn btn-primary">Написаить сообщение</button>
                    </div>
                </div>

                <div class="profile friends-flex__item">
                    <div class="profile-top-j">
                        <div class="profile-top">
                            <img class="profile-img" :src="testImg" alt="">
                            <div class="flex-info">
                                <div class="profile-name">Андрей Лясковский</div>
                                <div class="profile-desc">Я это сделал</div>
                                <a href="#" class="profile-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor"
                                         class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path
                                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path
                                            d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                    Подробнее</a>
                            </div>
                        </div>

                        <button class="btn btn-primary">Написаить сообщение</button>
                    </div>
                </div>

                <div class="profile friends-flex__item">
                    <div class="profile-top-j">
                        <div class="profile-top">
                            <img class="profile-img" :src="testImg" alt="">
                            <div class="flex-info">
                                <div class="profile-name">Андрей Лясковский</div>
                                <div class="profile-desc">Я это сделал</div>
                                <a href="#" class="profile-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                         fill="currentColor"
                                         class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path
                                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path
                                            d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                    Подробнее</a>
                            </div>
                        </div>

                        <button class="btn btn-primary">Написаить сообщение</button>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
