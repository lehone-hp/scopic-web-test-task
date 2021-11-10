<template>
    <div class="text-center">
        <img src="../../assets/empty_box.png" class="img-fluid icon"/>
        <div class="text"
           v-if="caption"
           v-html="caption"></div>
    </div>
</template>

<script>
    export default {
        props: ['caption']
    }
</script>

<style scoped>

</style>