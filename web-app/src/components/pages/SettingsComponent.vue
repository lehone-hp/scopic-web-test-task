<template>
  <div>
    <div class="mb-5">
      <small class="text-uppercase text-secondary">Settings</small>
      <h2>Configure the Auto-bidding</h2>
    </div>

    <div class="row">
      <div class="col-md-8 col-lg-6 col-xl-4">

        <form @submit.prevent="updateSettings">
          <div class="mb-5">
            <p class="mb-1 font-weight-bolder">Maximum bid amount</p>
            <small><i>
              This maximum amount will be split between all items where we have activated auto-bidding
              Get the notification about your reserved bids</i></small>
            <div class="input-group my-3 w-50">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">$</span>
              </div>
              <input type="number" class="form-control"
                     :class="{ 'is-invalid': $v.form.max_auto_bid.$error }"
                     v-model="$v.form.max_auto_bid.$model"
                     placeholder="100">

              <span class="invalid-feedback" v-if="!$v.form.max_auto_bid.required">This field is required</span>
              <span class="invalid-feedback" v-if="!$v.form.max_auto_bid.minValue">Amount can not be less than 0</span>
            </div>
          </div>

          <div class="mb-4">
            <p class="mb-1 font-weight-bolder">Bid Alert notification</p>
            <small><i>Get the notification about your reserved bids</i></small>
            <div class="input-group mt-3 w-50">
              <input type="number" class="form-control"
                     :class="{ 'is-invalid': $v.form.auto_bid_reserve.$error }"
                     v-model="$v.form.auto_bid_reserve.$model"
                     placeholder="90">

              <div class="input-group-append">
                <span class="input-group-text" id="basic-addon2">%</span>
              </div>

              <small class="invalid-feedback" v-if="!$v.form.auto_bid_reserve.required">This field is required</small>
              <small class="invalid-feedback" v-if="!$v.form.auto_bid_reserve.between">Value must be between 0 and
                100%</small>
            </div>
          </div>

          <div class="py-5">
            <button-spinner
                class="btn-block"
                @click="updateSettings"
                :spinner="show_spinner">Save</button-spinner>
          </div>
        </form>
      </div>
    </div>

  </div>
</template>

<script>
import {mapGetters} from "vuex";
import {required, minValue, between} from "vuelidate/lib/validators";
import {api} from "../../plugins/api";

export default {
  name: "SettingsComponent",
  data: function () {
    return {
      show_spinner: false,
      error_msg: '',
      form: {
        max_auto_bid: null,
        auto_bid_reserve: null
      }
    }
  },
  computed: {
    ...mapGetters(['authUser']),
  },
  validations: function () {
    return {
      form: {
        max_auto_bid: {
          required,
          minValue: minValue(0)
        },
        auto_bid_reserve: {
          required,
          between: between(0, 100)
        },
      }
    }
  },
  mounted: function () {
    this.fetchSettings();
  },
  methods: {
    updateSettings: function () {
      this.error_msg = '';

      this.$v.$touch()
      if (!this.$v.$invalid) {
        this.show_spinner = true;
        api
            .post(`/user/settings`, {
              ...this.form,
              user_id: this.authUser.id
            })
            .then(response => {
              const status = response.data.status;
              if (status === 'error') {
                this.error_msg = response.data.message
              } else if (status === 'success') {
                this.$toast.success(response.data.message);
                this.$v.$reset();
              }
            })
            .catch(() => {})
            .then(() => {
              this.show_spinner = false;
            });
      }
    },
    fetchSettings: function () {
      api
          .get(`/user/settings/${this.authUser.id}`)
          .then(response => {
            if (response.data.data) {
              this.form = response.data.data;
            }
          });
    },
  }
}
</script>

<style scoped>

</style>