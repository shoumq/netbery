export default {
    data() {
        return {
            body: '',
            messagesData: this.messages,
            dialogData: this.dialog[0],
            isOnline: false,
            lastOnline: [],
            sendButton: false
        }
    },

    props: ['messages', 'dialog'],

    methods: {
        logoutFun() {
            axios.post('/logout');
        },

        storeMessage() {
            this.sendButton = true
            axios.post(`/messages/${this.dialogData.id}`, {
                body: this.body
            })
                .then(() => {
                    this.sendButton = false
                    this.body = '';
                    const container = this.$refs.container;
                    container.scrollTop = container.scrollHeight;
                })
                .catch(() => {
                    this.sendButton = false
                })
        },

        checkName(name1, name2) {
            if (name1 === this.$page.props.auth.user.name + ' ' + this.$page.props.auth.user.surname) {
                return name2
            } else {
                return name1
            }
        },

        checkId(name1, name2) {
            if (name1 === this.$page.props.auth.user.id) {
                return name2
            } else {
                return name1
            }
        },

        checkLogin(name1, name2) {
            if (name1 === this.$page.props.auth.user.login) {
                return name2
            } else {
                return name1
            }
        },

        checkImage(name1, name2) {
            if (name1 === this.$page.props.auth.user.img_id) {
                return name2
            } else {
                return name1
            }
        },

        getUserTime() {
            axios.get('/get_online/' + this.checkId(this.dialogData.user_one_id, this.dialogData.user_two_id))
                .then((response) => {
                    this.isOnline = parseInt(response.data.result.split(':')[0]) === 0 && parseInt(response.data.result.split(':')[1]) === 0 && parseInt(response.data.result.split(':')[2]) < 15;
                    if (this.isOnline === false) {
                        this.lastOnline = response.data.time
                    } else {
                        this.lastOnline = ''
                    }

                    this.onlineTime = {
                        "seconds": parseInt(response.data.result.split(':')[2]),
                        "user_id": this.$page.props.auth.user.id
                    }
                })
        },
    },

    setup() {
        this.getUserTime();
    },

    mounted() {
        this.getUserTime();
        setInterval(this.getUserTime, 5000)

        const container = this.$refs.container;
        container.scrollTop = container.scrollHeight;

        window.Echo.channel('store_message_' + this.dialogData.id)
            .listen('.store_message', response => {
                this.messagesData.push(response.message)

                // const container = this.$refs.container;
                try {
                    this.$refs.container.scrollTop = this.$refs.container.scrollHeight;
                } catch (e) {
                    console.log(e)
                    window.location.reload()
                }
            })
    }
}
