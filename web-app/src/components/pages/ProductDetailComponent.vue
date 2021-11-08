<template>
  <div>
    <div class="row justify-content-center">
      <div class="col-md-6 mb-4 mb-md-0 text-center">
        <img src="../../assets/product1.jpg" class="img-fluid">
      </div>
      <div class="col-md-6 col-lg-4 pt-md-5">
        <div class="mb-5">
          <h2>Product No1</h2>
          <p>Minimum bid $10</p>
        </div>

        <div class="mb-5">
          <h6>Details</h6>
          <div class="small">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit.
              Tristique nunc convallis in blandit porttitor vitae ridiculus
              pellentesque feugiat. Neque suspendisse adipiscing non in
              dapibus mauris mi dignissim aliquam. Vulputate diam nisi,
              laoreet tellus semper mauris, nibh.
            </p>

            Enim feugiat accumsan adipiscing ultrices id viverra
            volutpat. Odio magna volutpat turpis felis. Interdum metus
            ultricies diam egestas volutpat turpis id odio. Suspendisse
            donec adipiscing sed semper risus nibh ultrices mollis.
            Malesuada nec vel risus porttitor proin. Nibh vulputate
            congue convallis scelerisque diam quis quis interdum.
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-6">
            <p class="mb-1">Last Bid Made</p>
            <h4>$15</h4>
          </div>
          <div class="col-6">
            <p class="mb-1">Available Until</p>
            <h4>
              <span>2</span>:<span>30</span>:<span>15</span>
            </h4>
          </div>
        </div>

        <button
            v-on:click="showBidModal"
            class="default-btn btn-block mb-4">Place a bid</button>

        <div class="custom-control custom-checkbox">
          <input type="checkbox"
                 class="custom-control-input"
                 id="autobid">
          <label class="custom-control-label"
                 for="autobid"><span>Activate the <router-link to="/settings">auto-biding</router-link></span></label>
        </div>

      </div>
    </div>

    <modal title="Place a bid"
           size="sm"
           ref="bid_modal"
           oktext="Place Bid">
      <form ref="form">
        <div class="form-group">
          <label>Bid Amount ($)</label>
          <input type="number"
                 class="form-control"
                 placeholder="min $75">
        </div>
      </form>
    </modal>

  </div>
</template>

<script>
export default {
  name: "ProductDetailComponent",
  methods: {
    showBidModal: function() {
      this.$refs['bid_modal'].show();
    }
  }
}
</script>

<style scoped>

</style>