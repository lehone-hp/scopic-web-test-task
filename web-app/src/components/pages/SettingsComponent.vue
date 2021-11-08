<template>
  <div>
    <div class="mb-5">
      <small class="text-uppercase text-secondary">Settings</small>
      <h2>Configure the Auto-bidding</h2>
    </div>

    <div class="row">
      <div class="col-md-8 col-lg-6 col-xl-4">

        <div class="mb-5">
          <p class="mb-1 font-weight-bolder">Maximum bid amount</p>
          <small><i>
            This maximum amount will be split between all items where we have activated auto-bidding
            Get the notification about your reserved bids</i></small>
          <div class="input-group my-3 w-50">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">$</span>
            </div>
            <input type="text" class="form-control" placeholder="100">
          </div>
        </div>

        <div class="mb-4">
          <p class="mb-1 font-weight-bolder">Bid Alert notification</p>
          <small><i>Get the notification about your reserved bids</i></small>
          <div class="input-group my-3 w-50">
            <input type="text" class="form-control" placeholder="90">
            <div class="input-group-append">
              <span class="input-group-text" id="basic-addon2">%</span>
            </div>
          </div>
        </div>

        <div class="py-5">
          <button class="default-btn btn-block">Save</button>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: "SettingsComponent"
}
</script>

<style scoped>

</style>