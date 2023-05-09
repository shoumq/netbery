<template>
    <div @click="uved2">
        <header>
            <div class="container">
                <div class="header">
                    <a href="/" class="header-title">НЕТБЕРИ</a>
                    <a class="header-title" v-if="this.isMobile()" @click="isDrop = !isDrop">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                             class="bi bi-list" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                  d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                    </a>
                    <a :href="'/user/' + $page.props.auth.user.login" class="header-title"
                       v-else>{{ $page.props.auth.user.name }}</a>
                </div>
            </div>
        </header>

        <div class="dropmenu container" v-if="isDrop">
            <div class="nav container">
                <a :href="'/user/' + $page.props.auth.user.login" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#0078b5"
                         class="bi bi-person"
                         viewBox="0 0 16 16">
                        <path
                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                    </svg>
                    <div class="text">Главная</div>
                </a>
                <a href="/news" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#0078b5" class="bi bi-newspaper"
                         viewBox="0 0 16 16">
                        <path
                            d="M0 2.5A1.5 1.5 0 0 1 1.5 1h11A1.5 1.5 0 0 1 14 2.5v10.528c0 .3-.05.654-.238.972h.738a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 1 1 0v9a1.5 1.5 0 0 1-1.5 1.5H1.497A1.497 1.497 0 0 1 0 13.5v-11zM12 14c.37 0 .654-.211.853-.441.092-.106.147-.279.147-.531V2.5a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0-.5.5v11c0 .278.223.5.497.5H12z"/>
                        <path
                            d="M2 3h10v2H2V3zm0 3h4v3H2V6zm0 4h4v1H2v-1zm0 2h4v1H2v-1zm5-6h2v1H7V6zm3 0h2v1h-2V6zM7 8h2v1H7V8zm3 0h2v1h-2V8zm-3 2h2v1H7v-1zm3 0h2v1h-2v-1zm-3 2h2v1H7v-1zm3 0h2v1h-2v-1z"/>
                    </svg>
                    <div class="text">Новости</div>
                </a>
                <a :href="route('allUsers')" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#0078b5" class="bi bi-emoji-smile"
                         viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path
                            d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                    </svg>
                    <div class="text">Знакомые</div>
                </a>
                <a href="/messages" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#0078b5" class="bi bi-chat"
                         viewBox="0 0 16 16">
                        <path
                            d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                    </svg>
                    <div class="text">Сообщения</div>
                </a>
                <a :href="route('community')" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#0078b5"
                         class="bi bi-people"
                         viewBox="0 0 16 16">
                        <path
                            d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                    </svg>
                    <div class="text">Сообщества</div>
                </a>
            </div>
        </div>

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
                    <a href="/news" class="nav-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#0078b5" class="bi bi-newspaper"
                             viewBox="0 0 16 16">
                            <path
                                d="M0 2.5A1.5 1.5 0 0 1 1.5 1h11A1.5 1.5 0 0 1 14 2.5v10.528c0 .3-.05.654-.238.972h.738a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 1 1 0v9a1.5 1.5 0 0 1-1.5 1.5H1.497A1.497 1.497 0 0 1 0 13.5v-11zM12 14c.37 0 .654-.211.853-.441.092-.106.147-.279.147-.531V2.5a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0-.5.5v11c0 .278.223.5.497.5H12z"/>
                            <path
                                d="M2 3h10v2H2V3zm0 3h4v3H2V6zm0 4h4v1H2v-1zm0 2h4v1H2v-1zm5-6h2v1H7V6zm3 0h2v1h-2V6zM7 8h2v1H7V8zm3 0h2v1h-2V8zm-3 2h2v1H7v-1zm3 0h2v1h-2v-1zm-3 2h2v1H7v-1zm3 0h2v1h-2v-1z"/>
                        </svg>
                        <div>Новости</div>
                    </a>
                    <a :href="route('allUsers')" class="nav-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#0078b5" class="bi bi-emoji-smile"
                             viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path
                                d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                        </svg>
                        <div>Знакомые</div>
                    </a>
                    <a href="/messages" class="nav-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#0078b5" class="bi bi-chat"
                             viewBox="0 0 16 16">
                            <path
                                d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                        </svg>
                        <div>Сообщения</div>
                    </a>
                    <a :href="route('community')" class="nav-item">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#0078b5"
                             class="bi bi-people"
                             viewBox="0 0 16 16">
                            <path
                                d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                        </svg>
                        <div class="text">Сообщества</div>
                    </a>
                </div>

                <div class="content">
                    <slot></slot>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isDrop: false
        }
    },

    methods: {
        isMobile() {
            return screen.width <= 760;
        },

        uved2() {
            let audio = new Audio('../storage/uved.mp3');
            audio.volume = 0
            audio.play();
        },
    },

    created() {
        this.isMobile();
    },
}
</script>

<style>
.nav-item svg {
    width: 16rem;
    height: 16rem;
}

.dialog1 {
    position: relative;
    bottom: 30rem;
    left: 30rem;
    background: white;
    border: 1rem solid #dce1e6;
    min-width: 230rem;
}

.dialog {
    background: white;
    padding: 15rem;
    display: flex;
    gap: 13rem;
    align-items: flex-start;
    justify-content: space-between;
}

.main_dialog {
    position: absolute;
    bottom: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    gap: 10rem;
}

@media (max-width: 768px) {
    .main_dialog {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
    }

    .dialog {
        position: fixed;
        bottom: 15rem;
        left: 15rem;
        right: 15rem;
        border: 1rem solid #dce1e6;
        box-shadow: 0 0 4rem #e1e1e1;
    }
}

.dialog .btn {
    padding: 3rem 7rem;
}

.dialog svg {
    width: 12rem;
    height: 12rem;
}

.dialog .form {
    display: flex;
    flex-direction: column;
    gap: 5rem;
}

.dialog-title {
    font-size: 14rem;
}

.dialog-message {
    font-size: 14rem;
    color: #494949;
}
</style>
