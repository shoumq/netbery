export default {
    data() {
        return {
            body: '',
            dialogsData: this.dialogs,
            isOnline: false,
            lastOnline: []
        }
    },

    props: ['dialogs', 'dialogs_id', 'multi_chats', 'col', 'col2'],

    methods: {
        logoutFun() {
            axios.post('/logout');
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

        checkImage(name1, name2) {
            if (name1 === this.$page.props.auth.user.img_id) {
                return name2
            } else {
                return name1
            }
        },
    },
}
