<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {useForm} from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    processing: true,
    remember: true,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <form class="form" @submit.prevent="submit">
            <div class="form-title">Войти</div>

            <div class="form-input">
                <label for="email" class="form-input__item">
                    Email
                    <input type="email" id="email" class="input" placeholder="Введите email" v-model="form.email">
                    <div class="error">{{ form.errors.email }}</div>
                </label>

                <label for="name" class="form-input__item">
                    Пароль
                    <input type="password" id="name" class="input" placeholder="Введите пароль" v-model="form.password">
                    <div class="error">{{ form.errors.password }}</div>
                </label>

                <button type="submit" class="btn btn-primary" :disabled="form.processing">Войти</button>
                <div class="flex-login">
                    <a href="/register" class="link link-3">Еще нет аккаунта?</a>
                    <a href="/forgot-password" class="link link-3">Забыли пароль?</a>
                </div>

            </div>
        </form>
    </GuestLayout>
</template>

<style lang="sass" scoped>
.flex-login
    display: flex
    justify-content: space-between

    @media (max-width: 768px)
        flex-direction: column
        gap: 5rem

        .link-3
            font-size: 13rem
</style>

