export default {
    props: ['dialog_id', 'messages', 'users', 'users_count'],

    data() {
        return {
            body: '',
            sendButton: false,
            dialog_name: this.dialog_id.dialog_title,
            disChange: false,
            dropdownBool: false,
            searchText: '',

            searchUserArray: []
        }
    },

    methods: {
        storeMessage() {
            this.sendButton = true
            axios.post(`/store_mess_multi_chat`, {
                body: this.body,
                multi_chat_id: this.dialog_id.id
            })
                .then(() => {
                    this.sendButton = false
                    this.body = ''
                    const container = this.$refs.container;
                    container.scrollTop = container.scrollHeight;
                })
                .catch(() => {
                    this.sendButton = false
                })
        },

        showDialog() {
            this.$refs.imgDialogRef.show()
            document.querySelector('body').style.overflowY = 'hidden';
            this.$refs.dialog_wrapper.style.opacity = '1'
            this.$refs.dialog_wrapper.style.zIndex = '9999998'
        },

        closeModal() {
            this.$refs.imgDialogRef.close()
            document.querySelector('body').style.overflowY = 'auto'
            this.$refs.dialog_wrapper.style.opacity = '0'
            this.$refs.dialog_wrapper.style.zIndex = '0'
        },

        changeDialogTitle() {
            this.disChange = true
            axios.post('/mchat_change_title', {
                chat_id: this.dialog_id.id,
                chat_title: this.dialog_name
            })
                .then(() => {
                    this.disChange = false
                })
        },

        kickMe() {
            axios.post(`/multi_dialog_kick/${this.dialog_id.id}`, {
                user_id: this.$page.props.auth.user.id
            })
                .then(() => {
                    this.$inertia.visit(route('messages'), {method: 'get'});
                })
        },

        kickUser(user_id) {
            axios.post(`/multi_dialog_kick/${this.dialog_id.id}`, {user_id})
                .then(() => {
                    if (parseInt(this.$page.props.auth.user.id) === parseInt(user_id)) {
                        this.$inertia.visit(route('messages'), {method: 'get'});
                    } else {
                        this.users.splice(this.users.findIndex(x => x.user_id === parseInt(user_id)), 1)
                    }
                })
        },

        dropdownBoolFun() {
            if (this.searchText) {
                this.dropdownBool = true

                axios.post('/search_user', {
                    name: this.searchText
                })
                    .then((response) => {
                        this.searchUserArray.length = 0
                        this.searchUserArray.push(response.data)
                    })
                    .catch(() => {
                        console.log('err')
                    })

            } else {
                this.dropdownBool = false
            }
            if (this.searchUserArray[0].length === 0) {
                this.dropdownBool = false
            }
        },

        addUser(user_id) {
            axios.post(`/multi_dialog_add/${this.dialog_id.id}`, {user_id})
                .then((response) => {
                    if (response.data !== "already_exits") {
                        this.users.push(response.data)
                        this.dropdownBool = false
                    } else {
                        this.dropdownBool = false
                    }
                })
        }
    },

    mounted() {
        this.$refs.imgDialogRef.close();

        window.Echo.channel('store_multi_message_' + this.dialog_id.id)
            .listen('.store_multi_message', response => {
                this.messages.push(response.message)

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
