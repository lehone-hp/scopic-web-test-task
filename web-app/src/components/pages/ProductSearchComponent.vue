<template>
  <div>
    <div class="row justify-content-between">
      <div class="col-lg-3">

        <button v-on:click="toggleFilter"
                class="show_filter_btn">
          <font-awesome-icon icon="filter"></font-awesome-icon>
        </button>

        <div class="filter-wrapper" :class="{'show': show_filter}">
          <div class="filter-head mb-5">
            <h5 class="mb-0">Filters</h5>
            <a href="#"
               v-on:click.prevent="toggleFilter"
               class="close">&times;</a>
          </div>

          <div class="filter-section">
            <p class="filter-section-title">Sort By</p>
            <select class="form-control">
              <option value="popular">Popular</option>
              <option value="date_desc">Date Posted (DESC)</option>
              <option value="date_desc">Date Posted (ASC)</option>
            </select>
          </div>

          <div class="filter-section">
            <p class="filter-section-title">Minimum Bid</p>
            <vue-slider v-model="filter.min_bid"
                        :min="0"
                        :max="500"
                        :tooltip-formatter="formatter"></vue-slider>
          </div>

          <div class="filter-section">
            <p class="filter-section-title">Category</p>

            <div class="custom-control custom-checkbox mb-2">
              <input type="checkbox"
                     class="custom-control-input"
                     id="customCheck1">
              <label class="custom-control-label"
                     for="customCheck1"><small>Check this custom checkbox</small></label>
            </div>
            <div class="custom-control custom-checkbox mb-2">
              <input type="checkbox"
                     class="custom-control-input"
                     id="customCheck2">
              <label class="custom-control-label"
                     for="customCheck2"><small>Check this custom checkbox</small></label>
            </div>
            <div class="custom-control custom-checkbox mb-2">
              <input type="checkbox"
                     class="custom-control-input"
                     id="customCheck3">
              <label class="custom-control-label"
                     for="customCheck3"><small>Check this custom checkbox</small></label>
            </div>
            <div class="custom-control custom-checkbox mb-2">
              <input type="checkbox"
                     class="custom-control-input"
                     id="customCheck4">
              <label class="custom-control-label"
                     for="customCheck4"><small>Check this custom checkbox</small></label>
            </div>
          </div>


        </div>
      </div>
      <div class="col-lg-8 col-xl-9">
        <div class="product-card-deck">
          <div class="row row-md">
            <div class="col-sm-6 col-lg-4 mb-3">
              <div class="product-card">
                <div class="img-wrapper"></div>
                <div class="body">
                  <div class="pr-3">
                    <h6 class="mb-1">Product No1</h6>
                    <small class="overflow-ellipsis">Lorem ipsum dolor sit amet</small>
                  </div>
                  <router-link to="/hope" class="default-btn">Bid Now</router-link>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-4 mb-3">
              <div class="product-card">
                <div class="img-wrapper"></div>
                <div class="body">
                  <div class="pr-3">
                    <h6 class="mb-1">Product No1</h6>
                    <small class="overflow-ellipsis">Lorem ipsum dolor sit amet</small>
                  </div>
                  <a href="#" class="default-btn">Bid Now</a>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-4 mb-3">
              <div class="product-card">
                <div class="img-wrapper"></div>
                <div class="body">
                  <div class="pr-3">
                    <h6 class="mb-1">Product No1</h6>
                    <small class="overflow-ellipsis">Lorem ipsum dolor sit amet</small>
                  </div>
                  <a href="#" class="default-btn">Bid Now</a>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-4 mb-3">
              <div class="product-card">
                <div class="img-wrapper"></div>
                <div class="body">
                  <div class="pr-3">
                    <h6 class="mb-1">Product No1</h6>
                    <small class="overflow-ellipsis">Lorem ipsum dolor sit amet</small>
                  </div>
                  <a href="#" class="default-btn">Bid Now</a>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-4 mb-3">
              <div class="product-card">
                <div class="img-wrapper"></div>
                <div class="body">
                  <div class="pr-3">
                    <h6 class="mb-1">Product No1</h6>
                    <small class="overflow-ellipsis">Lorem ipsum dolor sit amet</small>
                  </div>
                  <a href="#" class="default-btn">Bid Now</a>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-4 mb-3">
              <div class="product-card">
                <div class="img-wrapper"></div>
                <div class="body">
                  <div class="pr-3">
                    <h6 class="mb-1">Product No1</h6>
                    <small class="overflow-ellipsis">Lorem ipsum dolor sit amet</small>
                  </div>
                  <a href="#" class="default-btn">Bid Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>


        <empty-search
            caption="<h4>No Items Found</h4><p>Please try searching in other categories or change the min bid</p>"></empty-search>

      </div>
    </div>
  </div>
</template>

<script>
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/default.css'

export default {
  name: "ProductSearchComponent",
  components: {
    VueSlider
  },
  data: function () {
    return {
      filter: {
        min_bid: 0
      },
      formatter: v => `$${('' + v).replace(/\B(?=(\d{3})+(?!\d))/g, ',')}`,
      show_filter: false
    }
  },
  methods: {
    toggleFilter: function () {
      this.show_filter = !this.show_filter;
    }
  }
}
</script>

<style scoped>
</style>