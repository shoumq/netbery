export default {
    data() {
        return {
            body: '',
            postsData: this.posts,
            status_success: false,
            isSubData: this.isSub,
            status: this.community.status,
            filenameData: this.community.img_id
        }
    },

    props: ['community', 'posts', 'communities_sub', 'isSub', 'admin'],

    methods: {
        storePost() {
            axios.post(`/create_community_post/${this.community.id}`, {
                body: this.body
            }).then((response) => {
                this.body = ''
                this.postsData.unshift(response.data)
            })
        },

        storeLike(post_id) {
            axios.get('/community/post_like/' + post_id)
                .then((response) => {
                    this.postsData.find(x => x.id === parseInt(post_id)).likes = response.data.likes
                    this.postsData.find(x => x.id === parseInt(post_id)).your_like = response.data.my_like
                })
                .catch(err => {
                    console.log(err);
                })
        },

        deletePost(post_id) {
            axios.get(`/delete_community_post/${post_id}`)
                .then(() => {
                    this.postsData.splice(this.postsData.findIndex(x => x.id === post_id), 1)
                })
        },

        subscribeCommunity() {
            axios.post('/subscribe_community/' + this.community.id)
                .then(() => {
                    this.isSubData = 1
                })
        },

        unsubscribeCommunity() {
            axios.post('/unsubscribe_community/' + this.community.id)
                .then(() => {
                    this.isSubData = 0
                })
        },

        getTime(time) {
            return time.split(':')[0] + ':' + time.split(':')[1]
        },

        updateStatus() {
            axios.post('/community/update_status/' + this.community.id, {
                status: this.status
            })
        },

        storeImage(event) {
            this.filename = event.target.files[0].name;
            this.file = event.target.files[0];

            let formData = new FormData();
            formData.append('file', this.file);
            formData.append('community_id', this.community.id);

            axios.post(`/community/update_image`, formData)
                .then(() => {
                    this.filenameData = this.filename;
                })
        },
    },
}
