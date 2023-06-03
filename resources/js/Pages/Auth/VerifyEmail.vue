<script setup>
import {computed} from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
// import PrimaryButton from '@/Components/PrimaryButton.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

const props = defineProps({
    status: String,
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="Email верификация"/>

        <div class="fs3">
            Спасибо за регистрацию! Прежде чем приступить к работе, не могли бы вы подтвердить свой адрес
            электронной почты, перейдя по ссылке, которую мы только что отправили вам на электронную почту? Если вы не
            получили это электронное письмо, мы с радостью отправим вам другое.
        </div>

        <div class="fs3 mt3" v-if="verificationLinkSent">
            На адрес электронной почты, который вы указали при регистрации, была отправлена новая ссылка для подтверждения.
        </div>

        <form @submit.prevent="submit">
            <div class="mt3 flex-block">
                <button class="btn btn-primary" :disabled="form.processing">
                    Отправить письмо еще раз
                </button>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="btn btn-primary"
                >Выйти
                </Link
                >
            </div>
        </form>
    </GuestLayout>
</template>


<style lang="sass" scoped>
.fs3
    font-size: 20rem

.mt3
    margin-top: 20rem

.flex-block
    display: flex
    flex-direction: row
    gap: 15rem
</style>
