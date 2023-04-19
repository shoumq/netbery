<script setup>
import {ref} from 'vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <header>
            <div class="container">
                <div class="header">
                    <a :href="route('friends')" class="header-title">НЕТБЕРИ</a>
                    <a :href="route('friends')" class="header-title">{{ $page.props.auth.user.name }}</a>
                </div>
            </div>
        </header>

        <div class="container">
            <main>
                <div class="nav">
                    <a :href="'/user/' + $page.props.auth.user.login" class="nav-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#0078b5"
                             class="bi bi-person"
                             viewBox="0 0 16 16">
                            <path
                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                        </svg>
                        <div>Главная</div>
                    </a>
                    <a :href="route('friends')" class="nav-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#0078b5"
                             class="bi bi-people"
                             viewBox="0 0 16 16">
                            <path
                                d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                        </svg>
                        <div>Друзья</div>
                    </a>
                    <a href="/messages" class="nav-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#0078b5" class="bi bi-chat"
                             viewBox="0 0 16 16">
                            <path
                                d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                        </svg>
                        <div>Сообщения</div>
                    </a>
                </div>

                <div class="content">
                    <slot></slot>
                </div>
            </main>
        </div>
    </div>
</template>

<style>
.nav-item svg {
    width: 16rem;
    height: 16rem;
}
</style>
