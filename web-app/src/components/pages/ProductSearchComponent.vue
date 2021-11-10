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
            <select class="form-control"
                    v-model="filter.sort"
                    v-on:change="filterProducts">
              <option v-for="[key, value] of sort_options"
                      :key="key"
                      :value="key">{{ value }}
              </option>
            </select>
          </div>

          <div class="filter-section">
            <p class="filter-section-title">Minimum Bid</p>
            <vue-slider
                @drag-end="filterProducts"
                v-model="filter.min_bid"
                :min="0"
                :max="50"
                :tooltip-formatter="formatter"></vue-slider>
          </div>

          <div class="filter-section" v-if="categories.length > 0">
            <p class="filter-section-title">Category</p>

            <div class="custom-control custom-radio mb-2">
              <input type="radio"
                     class="custom-control-input"
                     name="category"
                     v-on:change="filterProducts"
                     v-model="filter.category"
                     :value="null"
                     id="cat_all">
              <label class="custom-control-label"
                     for="cat_all"><small>All Categories</small></label>
            </div>

            <div class="custom-control custom-radio mb-2"
                 v-for="(category, key) in categories"
                 :key="key">
              <input type="radio"
                     class="custom-control-input"
                     name="category"
                     v-on:change="filterProducts"
                     v-model="filter.category"
                     :value="category.id"
                     :id="'cat'+category.id">
              <label class="custom-control-label"
                     :for="'cat'+category.id"><small>{{ category.name }}</small></label>
            </div>
          </div>

        </div>
      </div>
      <div class="col-lg-8 col-xl-9">
        <div v-if="show_skeleton"
             class="row row-md">
          <div class="col-sm-6 col-lg-4 mb-4"
               v-for="(item, key) in 6"
               :key="key">
            <Skeleton height="15rem"/>
            <div class="mt-1 d-flex">
              <div class="w-75 pr-3">
                <Skeleton :count="2" height="18px"/>
              </div>
              <div class="w-25">
                <Skeleton height="42px"/>
              </div>
            </div>
          </div>
        </div>
        <template v-else>
          <div v-if="products.length > 0" class="product-card-deck">
            <div class="row row-md">
              <div class="col-sm-6 col-lg-4 mb-4"
                   v-for="product in products"
                   :key="product.id">
                <ProductCard :product="product"></ProductCard>
              </div>
            </div>

            <div class="py-4 text-center" v-if="show_more_btn">
              <button-spinner
                  :spinner="show_spinner"
                  @click="fetchProducts">Load More
              </button-spinner>
            </div>
          </div>
          <empty-search
              v-else
              caption="<h4>No Items Found</h4><p>Please try searching in other categories or change the min bid</p>"></empty-search>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/default.css'
import {Skeleton} from 'vue-loading-skeleton';
import ProductCard from '../ProductCard';
import {api} from "../../plugins/api";

export default {
  name: "ProductSearchComponent",
  components: {
    VueSlider,
    Skeleton,
    ProductCard
  },
  data: function () {
    return {
      products: [],
      categories: [],
      show_filter: false,
      show_skeleton: false,
      show_spinner: false,
      show_more_btn: false,
      filter: {
        min_bid: 0,
        sort: 'popular',
        category: null,
        page: 1,
        limit: 6,
      },
      sort_options: new Map([
        ['popular', 'Popular'],
        ['date_asc', 'Closing Date (Closet)'],
        ['date_desc', 'Closing Date (Oldest)'],
        ['min_bid', 'Minimum Bid']
      ]),
      formatter: v => `$${('' + v).replace(/\B(?=(\d{3})+(?!\d))/g, ',')}`,
    }
  },
  mounted: function () {
    this.fetchProducts();
    this.fetchCategories();
  },
  methods: {
    fetchProducts: function () {
      if (!(this.show_skeleton || this.show_spinner)) {
        this.show_skeleton = (this.filter.page === 1);
        this.show_spinner = true;

        api
            .get(`/products`, {
              params: this.filter
            })
            .then(response => {
              if (this.filter.page === 1) {
                this.products = response.data.data;
              } else {
                this.products.push(...response.data.data);
              }

              var meta = response.data.meta;
              if (meta) {
                this.show_more_btn = (meta.current_page < meta.last_page);
                this.filter.page = ++meta.current_page;
              }
            })
            .catch(() => {

            })
            .then(() => {
              this.show_skeleton = false;
              this.show_spinner = false;
            });
      }
    },
    fetchCategories: function () {
      api
          .get(`/products/categories`)
          .then(response => {
            this.categories = response.data.data;
          });
    },
    filterProducts: function () {
      this.filter.page = 1;
      this.fetchProducts();
    },
    toggleFilter: function () {
      this.show_filter = !this.show_filter;
    },
  }
}
</script>

<style scoped>
</style>