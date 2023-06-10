<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password"/>

        <div class="mini_cont">
            <div class="fs3 mb4">
                Забыли пароль? Без проблем. Просто сообщите нам свой адрес электронной почты, и мы отправим вам ссылку
                для
                сброса пароля, которая позволит вам выбрать новый.
            </div>

            <div v-if="status" class="fs3 green mb4">
                {{ status }}
            </div>
            <div class="fs3 mb4">{{ form.errors.email }}</div>

            <form @submit.prevent="submit">
                <div>
                    <div class="fs1">Email</div>
                    <input
                        type="email"
                        class="input mb4"
                        id="email"
                        v-model="form.email"
                        autofocus
                        placeholder="Ваш email"
                        :disabled="form.processing"
                    />
                </div>

                <div>
                    <button class="btn btn-primary" :disabled="form.processing">Сбросить пароль</button>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>


<style lang="sass" scoped>
.fs3
    font-size: 16rem

    @media (max-width: 768px)
        font-size: 14rem

.fs1
    font-size: 14rem
    margin-bottom: 3rem

.mb4
    margin-bottom: 18rem

.mb2
    margin-bottom: 7rem

.mini_cont
    width: min(500rem, 100%)
    margin: auto

.input
    width: calc(100% - 15rem)
</style>
