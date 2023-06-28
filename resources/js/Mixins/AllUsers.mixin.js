export default {
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
            }).then(response => {
                console.log(response)
            })
        }
    }
}
