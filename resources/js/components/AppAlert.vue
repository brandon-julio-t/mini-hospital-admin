<template>
    <span class="invalid-feedback" role="alert">
        <strong>{{ this.message }}</strong>
    </span>
</template>

<script>
    export default {
        name: "AppAlert",
        props: {
            message: String
        }
    }
</script>

<style scoped>

</style>
