<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action">
        <vs-button
          color="warning"
          type="relief"
          :to="{ name: 'ProductEdit', params: { id: $route.params.id } }"
          v-if="$helper.isAllowed('edit_products')"
          ><vs-icon icon="edit"></vs-icon> {{ $t("action.edit") }}</vs-button
        >
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('read_products')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("product.detail.title") }}</h3>
          </div>
          <table class="badaso-table">
            <tr>
              <th>{{ $t("product.detail.header.name") }}</th>
              <td>{{ product.name }}</td>
            </tr>
            <tr>
              <th>{{ $t("product.detail.header.slug") }}</th>
              <td>{{ product.slug }}</td>
            </tr>
            <tr>
              <th>{{ $t("product.detail.header.desc") }}</th>
              <td>{{ product.desc }}</td>
            </tr>
            <tr>
              <th>{{ $t("product.detail.header.productImage") }}</th>
              <td><img width="100" v-if="product.productImage" :src="$store.state.badaso.meta.mediaBaseUrl + product.productImage" loading="lazy"></td>
            </tr>
            <tr>
              <th>{{ $t("product.detail.header.productCategory") }}</th>
              <td>{{ product.productCategory.name }}</td>
            </tr>
            <tr>
              <th>{{ $t("product.detail.header.createdAt") }}</th>
              <td>{{ getDate(product.createdAt) }}</td>
            </tr>
            <tr>
              <th>{{ $t("product.detail.header.updatedAt") }}</th>
              <td>{{ getDate(product.updatedAt) }}</td>
            </tr>
            <tr>
              <th>{{ $t("product.detail.header.deletedAt") }}</th>
              <td>{{ product.deletedAt ? getDate(product.deletedAt) : 'None' }}</td>
            </tr>
          </table>
        </vs-card>
      </vs-col>
      <vs-col vs-lg="12" vs-type="grid" vs-justify="flex-start" vs-align="center" class="product-details">
        <vs-col vs-w="12" v-for="(productDetail, index) in product.productDetails" :key="index" class="product-details__item">
          <vs-card class="mb-0 product-details--card">
            <div slot="media">
              <img width="100" v-if="productDetail.productImage" :src="$store.state.badaso.meta.mediaBaseUrl + productDetail.productImage" loading="lazy">
            </div>
            <div>
              <h6 class="mb-0"><strong>{{ productDetail.name }}</strong></h6>
              <small>{{ productDetail.SKU }}</small>
              <h3 class="mb-2 mt-2">{{ productDetail.price | toCurrency }}</h3>
              <small>{{ productDetail.quantity }} in stock</small>
              <small v-if="productDetail.discountId" class="d-block">Discount: {{  `${productDetail.discount.name} - ${productDetail.discount.discountType === 'fixed' ? $options.filters.toCurrency(productDetail.discount.discountFixed) : productDetail.discount.discountPercent + '%' }` }}</small>
            </div>
          </vs-card>
        </vs-col>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
import moment from 'moment'
export default {
  name: "ProductRead",
  components: {},
  data: () => ({
    product: {
      name: "",
      slug: "",
      desc: "",
      productImage: "",
      productCategory: "",
      createdAt: "",
      updatedAt: ""
    }
  }),
  mounted() {
    this.getProductDetail();
  },
  filters: {
    toCurrency: function (value) {
      var formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
      });
      return formatter.format(value);
    }
  },
  methods: {
    getDate(date) {
      return moment(date).format('dddd, DD MMMM YYYY')
    },
    getProductDetail() {
      this.$openLoader();
      this.$api.badasoProduct
      .read({ id: this.$route.params.id, relation: [ 'productCategory', 'productDetails.discount' ] })
      .then((response) => {
        this.$closeLoader();
        this.product = response.data.product;
      })
      .catch((error) => {
        this.$closeLoader();
        this.$vs.notify({
          title: this.$t("alert.danger"),
          text: error.message,
          color: "danger",
        });
      });
    },
  },
};
</script>

<style lang="scss">
.product-details {
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;

  &--card {
    & > .vs-card--content {
      margin-bottom: 0;
    }
  }

  &__discount {
    &--text {
      text-decoration: line-through;
    }
  }

  &__item {
    display: flex;
    height: 100%;
  }
}
</style>