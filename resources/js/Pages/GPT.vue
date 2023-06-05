<script setup>
import Layout from '@/Layouts/Layout.vue';
import {Link, Head} from "@inertiajs/vue3";
</script>

<template>
    <Head>
        <title>Сообщения</title>
    </Head>
    <Layout>
        <div class="chat">
            <form class="messages-input gpt-input" @submit.prevent="sendGPT">
                <input type="text" class="input" placeholder="Введите запрос" v-model="question" :disabled="btnDisabled">
                <button type="submit" class="btn btn-primary" :disabled="btnDisabled">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-send svg"
                         viewBox="0 0 16 16">
                        <path
                            d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                    </svg>
                </button>
            </form>
            <div class="fs3">{{ resultData }}</div>
        </div>
    </Layout>
</template>


<script>
export default {
    props: ['result'],

    data() {
        return {
            resultData: this.result,
            question: '',
            btnDisabled: false
        }
    },

    methods: {
        sendGPT() {
            this.btnDisabled = true
            axios.post('/get_gpt_answer', {
                question: this.question
            })
                .then((response) => {
                    this.resultData = response.data
                    this.btnDisabled = false
                })
                .catch(() => {
                    this.resultData = 'Попробуйте еще раз :('
                    this.btnDisabled = false
                })
        }
    }
}
</script>


<style lang="sass" scoped>
.fs3
    font-size: 20rem

@media (max-width: 768px)
    .input-mes
        font-size: 10rem

.messages-item
    background: white !important

input
    border-radius: 100rem !important

.gpt-input
    border-top: none !important
    padding-top: 0 !important
    border-bottom: 1rem solid #dce1e6
    margin-bottom: 15rem
    padding-bottom: 15rem

</style>
