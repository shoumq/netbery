import ButtonPrimary from "@/Components/ButtonPrimary.vue";

export default {
    components: {
        ButtonPrimary
    },

    data() {
        return {
            body: '',
            postsData: this.posts,
            status: this.user.status,
            status_success: false,
            friendsData: this.friends,
            checkHome: this.$page.props.auth.user.name === this.user.name,
            filename: '',
            file: '',
            filenameData: this.user.img_id,
            alerts: [],
            uvedVar: false,
            dialogsId: [],
            dialogsName: [],
            onlineTime: '',
            isOnline: false,
            lastOnline: '',
            userImages: [],
            imgDialog: this.$refs.imgDialogRef,
            isLoading: false,
            compl: document.readyState === 'complete',

            //  Dialog
            currentImage: 'i.png',
            currentTime: '2',
            currentId: '',
        }
    },

    props: ['user', 'posts', 'friends', 'communities', 'dialogs', 'images', 'user_id'],

    methods: {
        logoutFun() {
            axios.post('/logout');
            window.location.href = '/login/'
        },

        showDialog(name_img, time_img, id_img) {
            this.$refs.imgDialogRef.show()
            this.currentImage = name_img
            this.currentTime = time_img.split(':')[0].split('T')[0]
            this.currentId = id_img

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

        updateUserTime() {
            axios.get('/update_online/')
        },

        getUserTime() {
            axios.get('/get_online/' + this.user.id)
                .then((response) => {
                    this.isOnline = parseInt(response.data.result.split(':')[0]) === 0 && parseInt(response.data.result.split(':')[1]) === 0 && parseInt(response.data.result.split(':')[2]) < 20;
                    if (this.isOnline === false) {
                        this.lastOnline = response.data.time
                    } else {
                        this.lastOnline = ''
                    }
                })
        },

        getUserImages() {
            for (let i = 0; i < this.images.length; i++) {
                if (this.images[i].name.split('.').at(-1) === 'jpg' || this.images[i].name.split('.').at(-1) === 'jpeg' || this.images[i].name.split('.').at(-1) === 'png') {
                    this.userImages.push(this.images[i])
                }
            }
        },

        storePost() {
            axios.post(`/post/${this.$page.props.auth.user.id}`, {
                body: this.body
            }).then(() => {
                this.body = ''
            })
        },

        deletePost(post_id) {
            axios.get('/delete_post/' + post_id)
                .then(() => {
                    this.postsData.splice(this.postsData.findIndex(x => x.id === post_id), 1)
                })
        },

        storeLike(post_id) {
            axios.get('/post_like/' + post_id)
                .then((response) => {
                    this.postsData.find(x => x.id === parseInt(post_id)).likes = response.data.likes
                    this.postsData.find(x => x.id === parseInt(post_id)).your_like = response.data.my_like
                })
        },

        updateStatus() {
            axios.post('/user/update_status', {
                status: this.status
            })
        },

        getTime(time) {
            return time.split(':')[0] + ':' + time.split(':')[1]
        },

        createDialog() {
            axios.post('/create_dialog', {
                id: this.user.id
            }).then(response => {
                // window.location.href = `/chat/${response.data}`
                this.$inertia.visit(`/chat/${response.data}`, {
                    method: 'get'
                })
            })
        },

        deleteImage() {
            axios.get(`/del_images/${this.currentId}`)
                .then(() => {
                    let del_element = this.userImages.findIndex(x => x.id === this.currentId)
                    this.userImages.splice(del_element, 1)

                    document.querySelector('body').style.overflowY = 'auto'
                    this.$refs.dialog_wrapper.style.opacity = '0'
                    this.$refs.dialog_wrapper.style.zIndex = '0'

                    this.$refs.imgDialogRef.close()
                })
        },

        storeImage(event) {
            this.filename = event.target.files[0].name;
            this.file = event.target.files[0];

            let formData = new FormData();
            formData.append('file', this.file);

            axios.post(`/user/update_image`, formData)
                .then((response) => {
                    this.filenameData = response.data.name;
                    this.userImages.push(response.data)
                })
        },

        checkName(name1, name2, home) {
            if (home === true) {
                if (name1 === this.$page.props.auth.user.name + ' ' + this.$page.props.auth.user.surname) {
                    return name2
                } else {
                    return name1
                }
            } else {
                if (name1 === this.$page.props.auth.user.name + ' ' + this.$page.props.auth.user.surname) {
                    return name1
                } else {
                    return name2
                }
            }

        },

        checkLogin(name1, name2, home) {
            if (home === true) {
                if (name1 === this.$page.props.auth.user.login) {
                    return name2
                } else {
                    return name1
                }
            } else {
                if (name1 === this.$page.props.auth.user.login) {
                    return name1
                } else {
                    return name2
                }
            }
        },

        checkImage(name1, name2, home) {
            if (home === true) {
                if (name1 === this.$page.props.auth.user.img_id) {
                    return name2
                } else {
                    return name1
                }
            } else {
                if (name1 === this.$page.props.auth.user.img_id) {
                    return name1
                } else {
                    return name2
                }
            }
        },
    },

    computed: {
        isCurrentUser() {
            return this.$page.props.auth.user.id === this.user.id;
        }
    },

    mounted() {
        this.$refs.imgDialogRef.close();

        this.getUserTime();
        this.updateUserTime();
        this.getUserImages();
        this.getDialogsId();

        window.Echo.channel('store_post')
            .listen('.store_post', response => {
                this.postsData.unshift(response.post)
            })

        for (let i = 0; i < this.dialogsId.length; i++) {
            window.Echo.channel('store_message_' + this.dialogsId[i].id)
                .listen('.store_message', response => {
                    this.alerts.unshift(response)

                    setTimeout(() => {
                        this.alerts.length = 0;
                    }, 30000)
                })
        }

        setInterval(this.updateUserTime, 10000)
        setInterval(this.getUserTime, 10000)
    }
}
