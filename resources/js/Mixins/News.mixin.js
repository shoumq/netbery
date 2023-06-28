export default {
    props: ['posts', 'result', 'dialogs'],

    data() {
        return {
            body: '',
            postsData: this.result,
            alerts: [],
            uvedVar: false,
            dialogsId: [],
            dialogsName: [],
        }
    },

    methods: {
        storePost() {
            axios.post(`/post/${this.$page.props.auth.user.id}`, {
                body: this.body
            }).then((response) => {
                this.body = ''
                this.postsData.unshift(response.data)
            })
        },

        getTime(time) {
            return time.split(':')[0] + ':' + time.split(':')[1]
        },

        getDialogsId() {
            for (let i = 0; i < this.dialogs.length; i++) {
                if (this.dialogs[i].user_two !== this.$page.props.auth.user.name + ' ' + this.$page.props.auth.user.surname) {
                    this.dialogsId.push(
                        {
                            'id': this.dialogs[i].id,
                            'user': this.dialogs[i].user_two
                        }
                    );
                } else {
                    this.dialogsId.push(
                        {
                            'id': this.dialogs[i].id,
                            'user': this.dialogs[i].user_one
                        }
                    );
                }
            }
        },
    },

    mounted() {
        this.getDialogsId();

        for (let i = 0; i < this.dialogsId.length; i++) {
            window.Echo.channel('store_message_' + this.dialogsId[i].id)
                .listen('.store_message', response => {
                    this.alerts.unshift(response)

                    setTimeout(() => {
                        this.alerts.length = 0;
                    }, 30000)
                })
        }
    }
}
