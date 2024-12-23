<template>
    <button class="btn btn-primary"
            :type="type"
            :disabled="disabled">
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: "ButtonPrimary",
    props: {
        type: String,
        disabled: Boolean
    }
}
</script>

<style lang="sass" scoped>
.btn-primary
    color: white
    box-shadow: 0 0 2rem rgba(0, 0, 0, 0.1), 0 2rem 14rem rgba(0, 0, 0, 0.1)
    background: linear-gradient(#3b84ee, #1c67d5)
    transition: background 0.3s ease-out
    background-size: 1rem 200rem

    &:hover
        background-color: #1c67d5
        background-position: 100rem

    &:disabled
        background: linear-gradient(#93baf3, #6c9de1)
        cursor: default
</style>
