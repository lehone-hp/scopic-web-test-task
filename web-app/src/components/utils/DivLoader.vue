<template>
    <div class="div-loader">
        <div class="icon-wrapper loader" :class="{show: showLoader}">
            <svg class="husl-spinner" width="45px" height="45px"
                 viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                <circle class="path" fill="none"
                        stroke-width="4" stroke-linecap="round"
                        cx="33" cy="33" r="30"></circle>
            </svg>
        </div>

        <slot>
            <div class="icon-wrapper">
                <svg class="husl-spinner" width="45px" height="45px"
                     viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                    <circle class="path" fill="none"
                            stroke-width="4" stroke-linecap="round"
                            cx="33" cy="33" r="30"></circle>
                </svg>
            </div>
        </slot>
    </div>
</template>

<script>
    export default {
        name: "DivLoader",
        props: ['show_loader'],
        computed: {
            showLoader: function() {
                return this.show_loader;
            }
        }
    }
</script>

<style scoped>
    .div-loader {
        position: relative;
    }

    .icon-wrapper {
        min-height: 10rem;
        text-align: center;
        padding-top: 2rem;
    }

    .icon-wrapper.loader {
        min-height: 10rem;
        text-align: center;
        padding-top: 2rem;
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        background: #ffffff57;
        backdrop-filter: blur(2px);
        z-index: 10000;
        display: none;
    }

    .icon-wrapper.loader.show {
        display: block;
    }


</style>