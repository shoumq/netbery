export default {
    props: ['allIcons', 'myIcons'],

    data() {
        return {
            adminIcon: this.$page.props.auth.user.admin
        }
    },

    methods: {
        chooseIcon(icon_id) {
            axios.post('/choose_icon/', {
                iconId: icon_id
            })
                .then(() => {
                    this.adminIcon = icon_id
                })
        },

        addIcon(icon_id) {
            axios.post('/add_icon/', {
                iconId: icon_id
            })
                .then((response) => {
                    if (response.data !== 'err') {
                        this.myIcons.push(response.data)
                    }
                })
        }
    }
}
