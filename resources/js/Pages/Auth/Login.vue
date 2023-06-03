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
                <a href="/register" class="link link-3">Еще нет аккаунта? </a>

            </div>
        </form>
    </GuestLayout>
</template>

