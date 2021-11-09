<template>
  <div class="product-card">
    <div class="img-wrapper" :style="{'background-image': 'url('+product.image+')'}"></div>
    <div class="body">
      <div class="pr-3">
        <h6 class="mb-1">{{ product.name }}</h6>
        <small class="overflow-ellipsis">{{ product.short_desc }}</small>
      </div>
      <router-link :to="{ name: 'product_detail', params: { slug: product.slug }}"
                   class="default-btn">Bid Now
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductCard",
  props: {
    product: {
      type: Object,
      required: true
    }
  }
}
</script>

<style scoped>

</style>