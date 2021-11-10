<template>
  <div>
    <div class="row justify-content-center">
      <div class="col-md-6 mb-4 mb-md-0 text-center">
        <Skeleton v-if="show_skeleton" height="80vh"></Skeleton>
        <img v-else
             :src="product.image"
             class="img-fluid">
      </div>
      <div class="col-md-6 col-lg-4 pt-md-5">
        <div class="mb-5">
          <h2>
            <Skeleton>{{ product.name }}</Skeleton>
          </h2>
          <p>
            <Skeleton v-if="show_skeleton" width="50%"></Skeleton>
            <span v-else>Minimum bid ${{ product.min_bid }}</span>
          </p>
        </div>

        <div class="mb-5">
          <template v-if="show_skeleton">
            <Skeleton width="25%"/>
            <Skeleton height="200px"/>
          </template>
          <template v-else>
            <h6>Details</h6>
            <div class="small" v-html="product.description"></div>
          </template>
        </div>

        <template v-if="show_skeleton">
          <div class="row">
            <div class="col-6">
              <Skeleton height="50px"/>
            </div>
            <div class="col-6">
              <Skeleton height="50px"/>
            </div>
          </div>
        </template>
        <template v-else>
          <div class="row mb-3">
            <div class="col-6">
              <p class="mb-1">Last Bid Made</p>
              <h4>${{ product.highest_bid }}</h4>
            </div>
            <div class="col-6">
              <p class="mb-1">Available Until</p>
              <h4>
                <CountdownTimer
                    :date="product.close_date.date"></CountdownTimer>
              </h4>
            </div>
          </div>
          <button
              v-on:click="showBidModal"
              class="default-btn btn-block mb-4">Place a bid
          </button>
          <div class="custom-control custom-checkbox">
            <input type="checkbox"
                   class="custom-control-input"
                   id="autobid">
            <label class="custom-control-label"
                   for="autobid"><span>Activate the <router-link to="/settings">auto-biding</router-link></span></label>
          </div>
        </template>
      </div>
    </div>

    <template v-if="product">
      <ProductBid
          ref="pdt_bid"
          :product="product"
          @bidplaced="handleBidCreation"></ProductBid>
    </template>

  </div>
</template>

<script>
import {api} from "../../plugins/api";
import {Skeleton} from 'vue-loading-skeleton';
import CountdownTimer from "../CountdownTimer";
import ProductBid from "../ProductBid";

export default {
  name: "ProductDetailComponent",
  components: {
    Skeleton,
    CountdownTimer,
    ProductBid
  },
  data: function () {
    return {
      product: {},
      show_skeleton: true,
    }
  },
  mounted: function () {
    this.fetchProduct(this.$route.params.slug);
  },
  methods: {
    fetchProduct: function (slug) {
      this.show_skeleton = true;
      api
          .get(`/products/${slug}`)
          .then(response => {
            this.product = response.data.data;
          })
          .catch(() => {
            // todo: alert error occurred
          })
          .then(() => {
            this.show_skeleton = false;
          });
    },
    showBidModal: function () {
      this.$refs['pdt_bid'].showModal();
    },
    handleBidCreation: function ($product) {
      this.product = $product
    }
  }
}
</script>

<style scoped>

</style>