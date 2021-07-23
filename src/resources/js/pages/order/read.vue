<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action" v-if="order.status !== 4 && order.status !== -1">
        <vs-button 
          type="relief" 
          color="success" 
          :to="{ name: 'OrderConfirm', params: { id: order.id } }"
        >
          <vs-icon icon="check"></vs-icon>
          Confirm
        </vs-button>
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('confirm_orders')">
      <vs-col vs-lg="6">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("orders.confirm.title.customerInfo") }}</h3>
          </div>
          <table class="badaso-table">
            <tr>
              <th>{{ $t("orders.confirm.header.recipientName") }}</th>
              <td>{{ order.recipientName }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.addressLine1") }}</th>
              <td>{{ order.addressLine1 }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.addressLine2") }}</th>
              <td>{{ order.addressLine2 }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.city") }}</th>
              <td>{{ order.city }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.postalCode") }}</th>
              <td>{{ order.postalCode }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.country") }}</th>
              <td>{{ order.country }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.telephone") }}</th>
              <td>{{ order.telephone }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.mobile") }}</th>
              <td>{{ order.mobile }}</td>
            </tr>
          </table>
        </vs-card>
        <vs-row>
          <vs-col vs-w="6" v-for="(orderDetail, index) in order.orderDetails" :key="index">
            <vs-card>
              <div slot="media">
                <img :src="`${$store.state.badaso.meta.mediaBaseUrl}${orderDetail.productDetail.productImage}`">
              </div>
              <div>
                <h2>{{ orderDetail.productDetail.name }} - {{ orderDetail.productDetail.product.name }}</h2>
                <h1>{{ orderDetail.productDetail.price | toCurrency }}</h1>
                <h4>SKU: {{ orderDetail.productDetail.SKU }}</h4>
                <h4>Discount: {{ orderDetail.discounted | toCurrency }}</h4>
                <h4>Qty: {{ orderDetail.quantity }} pcs</h4>
              </div>
            </vs-card>
          </vs-col>
        </vs-row>
      </vs-col>
      <vs-col vs-lg="6">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("orders.confirm.title.orderInfo") }}</h3>
          </div>
          <table class="badaso-table">
            <tr>
              <th>{{ $t("orders.confirm.header.status") }}</th>
              <td>
                <vs-chip :color="getOrderStatusColor(order.status)">
                  <b>{{ getOrderStatus(order.status) }}</b>
                </vs-chip>
              </td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.user.email") }}</th>
              <td>{{ order.user.email }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.total") }}</th>
              <td>{{ order.total | toCurrency }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.discounted") }}</th>
              <td>{{ order.discounted | toCurrency }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.payed") }}</th>
              <td>{{ order.payed | toCurrency }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.proof") }}</th>
              <td>
                <img class="w-100" :src="$store.state.badaso.meta.mediaBaseUrl + order.image" alt="" v-if="order.image">
                <span v-else>None</span>
              </td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.trackingNumber") }}</th>
              <td>
                <span v-if="order.trackingNumber">{{ order.trackingNumber }}</span>
                <span v-else>None</span>
              </td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.expiredAt") }}</th>
              <td>
                <span v-if="order.expiredAt">{{ getDate(order.expiredAt) }}</span>
                <span v-else>None</span>
              </td>
            </tr>
          </table>
        </vs-card>
      </vs-col>
    </vs-row>
    <vs-popup :title="$t('orders.confirm.title.trackingNumber')" :active.sync="trackingNumberDialog">
      <vs-row>
        <vs-col vs-w="12" vs-type="flex">
          <badaso-text
            type="text"
            v-model="trackingNumber"
            size="12"
            :label="$t('orders.confirm.field.trackingNumber.label')"
            :placeholder="$t('orders.confirm.field.trackingNumber.placeholder')"
            style="margin-bottom: 8px !important;"
          ></badaso-text>
        </vs-col>
        <vs-col vs-w="12" vs-type="flex" vs-justify="flex-end">
          <vs-button type="relief" color="primary" class="ml-2" @click="setTrackingNumber">
            {{ $t('orders.confirm.button.save') }}
          </vs-button>
        </vs-col>
      </vs-row>
    </vs-popup>
  </div>
</template>

<script>
import moment from "moment";
export default {
  name: "OrderConfirm",
  components: {},
  data: () => ({
    order: {
      recipientName: "",
      addressLine1: "",
      addressLine2: "",
      city: "",
      postalCode: "",
      country: "",
      telephone: "",
      mobile: "",
      discounted: 0,
      total: 0,
      payed: 0,
      status: 0,
      expiredAt: "",
      image: "",
      trackingNumber: null,
      user: {
        email: "",
      },
      orderDetails: []
    },
  }),
  mounted() {
    this.getOrderDetail();
  },
  filters: {
    toCurrency: function (value) {
      var formatter = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        maximumFractionDigits: 0,
      });
      return formatter.format(value);
    },
  },
  methods: {
    getDate(date) {
      return moment(date).format("dddd, DD MMMM YYYY");
    },
    getOrderDetail() {
      this.$openLoader();
      this.$api.badasoOrder
        .read({ id: this.$route.params.id, relation: ["user", "orderDetails.productDetail.product"] })
        .then((response) => {
          this.$closeLoader();
          this.order = response.data.order;
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
    getOrderStatus(status) {
      switch (status) {
        case 0:
          return this.$t("orders.status.0");
        case 1:
          return this.$t("orders.status.1");
        case 2:
          return this.$t("orders.status.2");
        case 3:
          return this.$t("orders.status.3");
        case 4:
          return this.$t("orders.status.4");
        default:
          return this.$t("orders.status.-1");
      }
    },
    getOrderStatusColor(status) {
      switch (status) {
        case 0:
          return "warning";
        case 1:
          return "warning";
        case 2:
          return "primary";
        case 3:
          return "dark";
        case 4:
          return "success";
        default:
          return "danger";
      }
    },
  },
};
</script>
