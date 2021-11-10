<template>
  <div>
    <modal title="Place a bid"
           size="sm"
           ref="bid_modal"
           oktext="Place Bid"
           :hidefooter="true">

      <small class="d-block text-danger text-center">{{ error_msg }}</small>

      <form ref="form" @submit.prevent="placeBid">
        <div class="form-group">
          <label>Bid Amount ($)</label>
          <input type="number"
                 class="form-control"
                 :class="{ 'is-invalid': $v.form.amount.$error }"
                 v-model="$v.form.amount.$model"
                 :placeholder="'min bid $'+min_allowed_bid">
          <span class="invalid-feedback" v-if="!$v.form.amount.required">This field is required</span>
          <span class="invalid-feedback" v-if="!$v.form.amount.numeric">Please provide a numeric value</span>
          <span class="invalid-feedback"
                v-if="!$v.form.amount.minValue">The minimum allowed bid is ${{ min_allowed_bid }}</span>
        </div>

        <div class="text-right pt-4">
          <button-spinner
              @click="placeBid"
              :spinner="show_spinner">Place Bid
          </button-spinner>
        </div>
      </form>
    </modal>
  </div>
</template>

<script>
import {required, numeric, minValue} from 'vuelidate/lib/validators'
import {api} from "../plugins/api";
import {mapGetters} from "vuex";

export default {
  name: "ProductBid",
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
      form: {
        amount: null
      }
    }
  },
  validations: function () {
    return {
      form: {
        amount: {
          required,
          numeric,
          minValue: minValue(this.min_allowed_bid)
        }
      }
    }
  },
  computed: {
    ...mapGetters(['authUser']),
    min_allowed_bid: function () {
      return this.product.highest_bid > this.product.min_bid ? this.product.highest_bid + 1 : this.product.min_bid;
    }
  },
  methods: {
    placeBid: function () {
      this.error_msg = '';

      this.$v.$touch()
      if (!this.$v.$invalid) {
        this.show_spinner = true;
        api
            .post(`/products/bid/create`, {
              ...this.form,
              user_id: this.authUser.id,
              product_id: this.product.id
            })
            .then(response => {
              const status = response.data.status;
              if (status === 'error') {
                this.error_msg = response.data.message
              } else if (status === 'success') {

                this.$toast.success(response.data.message);

                this.hideModal();
                this.$emit('bidplaced', response.data.product);

                // reset form
                this.form = {amount: null};
                this.$v.$reset();
              }
            })
            .catch(() => {

            })
            .then(() => {
              this.show_spinner = false;
            });
      }
    },
    showModal: function () {
      this.$refs['bid_modal'].show();
    },
    hideModal: function () {
      this.$refs['bid_modal'].hide();
    }
  }
}
</script>

<style scoped>

</style>