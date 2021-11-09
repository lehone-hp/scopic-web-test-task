<template>
  <div>
    {{ display_time }}
  </div>
</template>

<script>
import moment from "moment";

export default {
  name: "CountdownTimer",
  props: {
    date: {
      required: true,
    }
  },
  data: function () {
    return {
      duration: 0,
    }
  },
  watch: {
    duration: function () {
      setTimeout(() => {
        this.computeDuration()
      }, 1000);
    }
  },
  computed: {
    display_time: function () {
      return this.duration ?
          this.duration.days() + ":" + this.duration.hours() + ":" + this.duration.minutes() + ":" + this.duration.seconds() : '';
    }
  },
  mounted: function () {
    this.computeDuration();
  },
  methods: {
    computeDuration: function () {
      this.duration = moment.duration(moment(this.date).diff(moment()));
    }
  }
}
</script>

<style scoped>

</style>