<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    surname: '',
    email: '',
    login: '',
    password: '',
    password_confirmation: '',
    terms: true,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <form class="form" @submit.prevent="submit">
            <div class="form-title">Войти</div>

            <div class="form-input">
                <label for="name" class="form-input__item">
                    Имя
                    <input type="text" id="name" class="input" placeholder="Введите имя" v-model="form.name">
                    <div class="error">{{ form.errors.name }}</div>
                </label>

                <label for="surname" class="form-input__item">
                    Фамилия
                    <input type="text" id="surname" class="input" placeholder="Введите фамилию" v-model="form.surname">
                    <div class="error">{{ form.errors.surname }}</div>
                </label>

                <label for="login" class="form-input__item">
                    Логин
                    <input type="text" id="login" class="input" placeholder="Введите логин" v-model="form.login">
                    <div class="error">{{ form.errors.login }}</div>
                </label>

                <label for="name" class="form-input__item">
                    Email
                    <input type="email" id="email" class="input" placeholder="Введите email" v-model="form.email">
                    <div class="error">{{ form.errors.email }}</div>
                </label>

                <label for="password" class="form-input__item">
                    Пароль
                    <input type="password" id="password" class="input" placeholder="Введите пароль" v-model="form.password">
                    <div class="error">{{ form.errors.password }}</div>
                </label>

                <label for="password_confirmation" class="form-input__item">
                    Повторите пароль
                    <input type="password" id="password_confirmation" class="input" placeholder="Введите пароль" v-model="form.password_confirmation">
                    <div class="error">{{ form.errors.password_confirmation }}</div>
                </label>

                <button type="submit" class="btn btn-primary" :disabled="form.processing">Зарегистрироваться</button>
                <a href="/login" class="link">Уже есть аккаунт? </a>

            </div>
        </form>
    </GuestLayout>
</template>
