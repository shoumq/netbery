import ButtonPrimary from "@/Components/ButtonPrimary.vue";

export default {
    components: {
        ButtonPrimary
    },

    props: ['users'],

    data() {
        return {
            searchInput: '',
            usersData: this.users
        }
    },

    methods: {
        createDialog() {
            axios.post('/create_dialog', {
                id: this.user.id
            }).then(response => {
                window.location.href = `/chat/${response.data}`
            })
        },

        searchUsers() {
            axios.post('/search_friends', {
                searchInput: this.searchInput
            }).then((response) => {
                this.usersData.length = 0

                for (let i = 0; i < response.data.length; i++) {
                    this.usersData.push(response.data[i])
                }
            })
        }
    }
}
