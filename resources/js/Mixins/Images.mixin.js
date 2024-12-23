import ButtonPrimary from "@/Components/ButtonPrimary.vue";
import ButtonDanger from "@/Components/ButtonDanger.vue";

export default {
    components: {
        ButtonPrimary,
        ButtonDanger
    },

    props: ['images', 'user'],

    data() {
        return {
            imagesData: this.images.slice().reverse(),
            resultData: [],
            currentImage: 'i.png',
            currentTime: '',
            currentId: '',
            filename: '',
            file: '',
            filenameData: ''
        }
    },

    methods: {
        sortArr() {
            for (let i = 0; i < this.imagesData.length; i++) {
                if (this.imagesData[i].name.split('.').at(-1) === 'jpg' || this.imagesData[i].name.split('.').at(-1) === 'jpeg' || this.imagesData[i].name.split('.').at(-1) === 'png') {
                    this.resultData.push(this.imagesData[i])
                }
            }
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
            document.querySelector('body').style.overflowY = 'auto'
            this.$refs.dialog_wrapper.style.opacity = '0'
            this.$refs.dialog_wrapper.style.zIndex = '0'
        },

        storeImage(event) {
            this.filename = event.target.files[0].name;
            this.file = event.target.files[0];

            let formData = new FormData();
            formData.append('file', this.file);

            axios.post(`/add_images`, formData)
                .then((response) => {
                    this.filenameData = response.data.filename;
                    console.log(response.data)
                    this.resultData.unshift(response.data)
                })
        },
    },

    mounted() {
        this.sortArr();
        this.$refs.imgDialogRef.close();
    }
}
