<template>
  <div>
    <div class="custom-control custom-checkbox">
      <input type="checkbox"
             :disabled="show_spinner"
             v-on:click.prevent="toggleAutoBid"
             v-model="bid.auto_bid"
             class="custom-control-input"
             id="autobid">

      <label class="custom-control-label"
             for="autobid"><span>Activate the <router-link to="/settings">auto-biding</router-link></span></label>

      <svg v-if="show_spinner"
           class="spinner ml-3"
           viewBox="0 0 50 50">
        <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
      </svg>
    </div>

    <small class="d-block text-danger">{{ error_msg }}</small>

  </div>
</template>

<script>
import {mapGetters} from "vuex";
import {api} from "../plugins/api";

export default {
  name: "ProductAutoBid",
  props: {
    product: {
      required: true,
      type: Object
    }
  },
  data: function () {
    return {
      show_spinner: false,
      error_msg: '',
      bid: {}
    }
  },
  computed: {
    ...mapGetters(['authUser']),
  },
  mounted: function () {
    this.fetchBid();
  },
  methods: {
    toggleAutoBid: function () {

      this.error_msg = '';

      if (!this.show_spinner) {
        this.show_spinner = true;
        api
            .post(`/products/bid/auto-bid`, {
              user_id: this.authUser.id,
              product_id: this.product.id
            })
            .then(response => {
              const status = response.data.status;
              if (status === 'error') {
                // todo: toast error message
                this.error_msg = response.data.message;
              } else if (status === 'success') {
                this.bid = response.data.bid;
              }
            })
            .catch(() => {
              // todo: alert error occurred
            })
            .then(() => {
              this.show_spinner = false;
            });
      }
    },
    fetchBid: function () {
      api
          .get(`/bids`, {
            params: {
              product_id: this.product.id,
              user_id: this.authUser.id
            }
          })
          .then(response => {
            if (response.data.data) {
              this.bid = response.data.data;
            }
          })
          .catch(() => {
            // todo: alert error occurred
          });
    },
  }
}
</script>

<style scoped>

.spinner {
  animation: rotate 2s linear infinite;
  width: 1rem;
  height: 1rem;
}

.spinner .path {
  stroke: #000;
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