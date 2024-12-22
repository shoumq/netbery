export default class ChatDto {
    constructor(message) {
        this.message = message
    }

    toRequest() {
        const formatted = {
            message: this.message
        }

        if (formatted.message === '') {
            delete formatted.message
        }

        return formatted.message
    }
}
