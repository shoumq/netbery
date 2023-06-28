<template>
    <button class="btn btn-danger"
            :type="type"
            :disabled="disabled">
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: "ButtonDanger",
    props: {
        type: String,
        disabled: Boolean
    }
}
</script>

<style lang="sass" scoped>
.btn-danger
    background-color: #fd6363
    color: white

    &:hover
        background-color: #ff4f4f
</style>
