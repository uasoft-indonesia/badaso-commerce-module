<template>
  <div>
    <badaso-breadcrumb-row>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('read_carts')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("cart.detail.title") }}</h3>
          </div>
          <table class="badaso-table">
            <tr>
              <th>{{ $t("cart.detail.header.id") }}</th>
              <td>{{ cart.id }}</td>
            </tr>
            <tr>
              <th>{{ $t("cart.detail.header.name") }}</th>
              <td>{{ `${cart.user.name} - ${cart.user.email}` }}</td>
            </tr>
            <tr>
              <th>{{ $t("cart.detail.header.productName") }}</th>
              <td>{{ `${cart.productDetail.product.name} - ${cart.productDetail.name}` }}</td>
            </tr>
            <tr>
              <th>{{ $t("cart.detail.header.quantity") }}</th>
              <td>{{ cart.quantity }}</td>
            </tr>
            <tr>
              <th>{{ $t("cart.detail.header.createdAt") }}</th>
              <td>{{ getDate(cart.createdAt) }}</td>
            </tr>
            <tr>
              <th>{{ $t("cart.detail.header.updatedAt") }}</th>
              <td>{{ getDate(cart.updatedAt) }}</td>
            </tr>
          </table>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
import moment from 'moment'
export default {
  name: "PaymentProviderRead",
  components: {},
  data: () => ({
    cart: {
      user: {
        name: ""
      },
      productDetail: {
        name: "",
        product: {
          name: ""
        }
      },
      quantity: 0,
      createdAt: "",
      updatedAt: ""
    }
  }),
  mounted() {
    this.getCartDetail();
  },
  methods: {
    getDate(date) {
      return moment(date).format('dddd, DD MMMM YYYY')
    },
    getCartDetail() {
      this.$openLoader();
      this.$api.badasoCart
      .read({ id: this.$route.params.id, relation: ['productDetail.product', 'user'] })
      .then((response) => {
        this.$closeLoader();
        this.cart = response.data.cart;
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
