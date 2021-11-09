<template>
  <button class="default-btn loading"
          :disabled="spinner"
          v-on:click="handleClick">
    <slot></slot>
    <svg class="spinner" v-if="spinner"
         viewBox="0 0 50 50">
      <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
    </svg>
  </button>
</template>

<script>
export default {
  name: "ButtonSpinner",
  props: {
    spinner: {
      Boolean,
      required: false
    }
  },
  methods: {
    handleClick: function () {
      this.$emit('click');
    },
  }
}
</script>

<style scoped>
.spinner {
  animation: rotate 2s linear infinite;
  z-index: 2;
  width: 18px;
  height: 18px;
  margin-left: 10px;
}

.spinner .path {
  stroke: #fff;
  stroke-linecap: round;
  animation: dash 1.5s ease-in-out infinite;
}


@keyframes rotate {
  100% {
    transform: rotate(360deg);
  }
}

@keyframes dash {
  0% {
    stroke-dasharray: 1, 150;
    stroke-dashoffset: 0;
  }
  50% {
    stroke-dasharray: 90, 150;
    stroke-dashoffset: -35;
  }
  100% {
    stroke-dasharray: 90, 150;
    stroke-dashoffset: -124;
  }
}
</style>