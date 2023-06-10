<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password"/>

        <div class="mini_cont">
            <form @submit.prevent="submit">
                <div class="mb4">
                    <div class="fs1">Email</div>
                    <input
                        type="email"
                        class="input"
                        id="email"
                        v-model="form.email"
                        autofocus
                        :disabled="form.processing"
                    />
                    <div class="fs3">{{ form.errors.email }}</div>
                </div>

                <div class="mb4">
                    <div class="fs1">Password</div>
                    <input
                        type="password"
                        class="input"
                        id="password"
                        v-model="form.password"
                        autofocus
                        :disabled="form.processing"
                    />
                    <div class="fs3">{{ form.errors.password }}</div>
                </div>

                <div class="mb4">
                    <div class="fs1">Confirm Password</div>
                    <input
                        type="password"
                        class="input"
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        autofocus
                        :disabled="form.processing"
                    />
                    <div class="fs3">{{ form.errors.password_confirmation }}</div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button class="btn btn-primary" :disabled="form.processing">Сбросить пароль</button>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>

<style lang="sass" scoped>
.fs3
    font-size: 20rem

    @media (max-width: 768px)
        font-size: 14rem

.fs1
    font-size: 14rem
    margin-bottom: 3rem

.mb4
    margin-bottom: 13rem

.mb2
    margin-bottom: 7rem

.mini_cont
    width: min(400rem, 100%)
    margin: auto

.input
    width: calc(100% - 15rem)
</style>
