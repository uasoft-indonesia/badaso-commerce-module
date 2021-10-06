<template>
  <div>
    <badaso-breadcrumb-row>
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
              <th>{{ $t("orders.confirm.header.phoneNumber") }}</th>
              <td>{{ order.phoneNumber }}</td>
            </tr>
          </table>
        </vs-card>
        <vs-row>
          <vs-col vs-w="6" v-for="(orderDetail, index) in order.orderDetails" :key="index">
            <vs-card>
              <div slot="media">
                <img :src="orderDetail.productDetail.productImage">
              </div>
              <div>
                <h2>{{ orderDetail.productDetail.product.name }}</h2>
                <h1>{{ toCurrency(orderDetail.productDetail.price) }}</h1>
                <p>Variant: {{ orderDetail.productDetail.SKU }}</p>
                <p>Discount: {{ toCurrency(orderDetail.discounted) }}</p>
                <p>Qty: {{ orderDetail.quantity }} pcs</p>
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
              <td>{{ toCurrency(order.total) }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.discounted") }}</th>
              <td>{{ toCurrency(order.discounted) }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.shippingCost") }}</th>
              <td>{{ toCurrency(order.shippingCost) }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.payed") }}</th>
              <td>{{ toCurrency(order.payed) }}</td>
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
            <tr v-if="order.status != 'cancel' && order.status != 'done'">
              <th>{{ $t("orders.confirm.header.action") }}</th>
              <td>
                <vs-button type="relief" color="success" @click="confirm" v-if="order.status == 'waitingSellerConfirmation'">
                  <vs-icon icon="check"></vs-icon>
                  Confirm
                </vs-button>
                <vs-button type="relief" color="danger" @click="openCancelDialog" v-if="order.status == 'waitingBuyerPayment' || order.status == 'waitingSellerConfirmation'">
                  <vs-icon icon="clear"></vs-icon>
                  Reject
                </vs-button>
                <vs-button type="relief" color="primary" v-if="order.status == 'process'" @click="openTrackingNumber">
                  <vs-icon icon="local_shipping"></vs-icon>
                  Add Tracking Number
                </vs-button>
                <vs-button type="relief" color="dark" v-if="order.status == 'delivering'" @click="done">
                  <vs-icon icon="done_all"></vs-icon>
                  Done
                </vs-button>
              </td>
            </tr>
            <tr v-if="order.status == 'cancel'">
              <th>{{ $t("orders.confirm.header.cancelMessage") }}</th>
              <td>{{ order.cancelMessage }}</td>
            </tr>
          </table>
        </vs-card>
        <vs-card v-if="order.orderPayment">
          <div slot="header">
            <h3>{{ $t("orders.confirm.title.orderPayment") }}</h3>
          </div>
          <table class="badaso-table">
            <tr>
              <th>{{ $t("orders.confirm.header.orderPayment.sourceBank") }}</th>
              <td>{{ getSourceBank(order.orderPayment.sourceBank) }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.orderPayment.destinationBank") }}</th>
              <td>{{ order.orderPayment.destinationBank }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.orderPayment.accountNumber") }}</th>
              <td>{{ order.orderPayment.accountNumber }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.orderPayment.totalTransfer") }}</th>
              <td>{{ toCurrency(order.orderPayment.totalTransfered) }}</td>
            </tr>
            <tr>
              <th>{{ $t("orders.confirm.header.orderPayment.proofOfTransaction") }}</th>
              <td>
                <img class="w-100" :src="order.orderPayment.proofOfTransaction" alt="" v-if="order.orderPayment.proofOfTransaction">
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
    <vs-popup :title="$t('orders.confirm.title.cancel')" :active.sync="cancelDialog">
      <vs-row>
        <vs-col vs-w="12" vs-type="flex">
          <badaso-text
            type="text"
            v-model="cancelMessage"
            size="12"
            :label="$t('orders.confirm.field.cancel.label')"
            :placeholder="$t('orders.confirm.field.cancel.placeholder')"
            style="margin-bottom: 8px !important;"
          ></badaso-text>
        </vs-col>
        <vs-col vs-w="12" vs-type="flex" vs-justify="flex-end">
          <vs-button type="relief" color="danger" class="ml-2" @click="setCancelMessage">
            {{ $t('orders.confirm.button.save') }}
          </vs-button>
        </vs-col>
      </vs-row>
    </vs-popup>
  </div>
</template>

<script>
import moment from "moment";
import currency from 'currency.js';
export default {
  name: "OrderConfirm",
  components: {},
  data: () => ({
    trackingNumber: null,
    trackingNumberDialog: false,
    cancelDialog: false,
    cancelMessage: null,
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
      orderDetails: [],
      orderPayment: {
        sourceBank: null,
        destinationBank: null,
        accountNumber: null,
        totalTransfered: null,
        proofOfTransaction: null,
      }
    },
  }),
  mounted() {
    this.getOrderDetail();
  },
  methods: {
    toCurrency(value) {
      return currency(value, {
        precision: this.$store.state.badaso.config.currencyPrecision,
        decimal: this.$store.state.badaso.config.currencyDecimal,
        separator: this.$store.state.badaso.config.currencySeparator,
        symbol: this.$store.state.badaso.config.currencySymbol,
      }).format()
    },
    getDate(date) {
      return moment(date).format("dddd, DD MMMM YYYY HH:mm:ss");
    },
    getOrderDetail() {
      this.$openLoader();
      this.$api.badasoOrder
        .read({ id: this.$route.params.id })
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
        case 'waitingBuyerPayment':
          return this.$t("orders.status.0")
        case 'waitingSellerConfirmation':
          return this.$t("orders.status.1")
        case 'process':
          return this.$t("orders.status.2")
        case 'delivering':
          return this.$t("orders.status.3")
        case 'done':
          return this.$t("orders.status.4")
        default:
          return this.$t("orders.status.-1")
      }
    },
    getOrderStatusColor(status) {
      switch (status) {
        case 'waitingBuyerPayment':
          return "warning";
        case 'waitingSellerConfirmation':
          return "warning";
        case 'process':
          return "primary";
        case 'delivering':
          return "dark";
        case 'done':
          return "success";
        default:
          return "danger";
      }
    },
    setCancelMessage() {
      this.$openLoader();
      this.$api.badasoOrder
        .reject({ id: this.$route.params.id, cancelMessage: this.cancelMessage })
        .then((response) => {
          this.$closeLoader();
          this.cancelDialog = false
          this.getOrderDetail()
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
    confirm() {
      this.$openLoader();
      this.$api.badasoOrder
        .confirm({ id: this.$route.params.id })
        .then((response) => {
          this.$closeLoader();
          this.getOrderDetail()
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
    done() {
      this.$openLoader();
      this.$api.badasoOrder
        .done({ id: this.$route.params.id })
        .then((response) => {
          this.$closeLoader();
          this.getOrderDetail()
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
    openTrackingNumber() {
      this.trackingNumberDialog = true
    },
    setTrackingNumber() {
      this.$openLoader();
      this.trackingNumberDialog = false
      this.$api.badasoOrder
        .ship({ 
          id: this.$route.params.id,
          trackingNumber: this.trackingNumber
        })
        .then((response) => {
          this.$closeLoader();
          this.getOrderDetail()
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
    getSourceBank(bank) {
      if (!bank) return ''
      return JSON.parse(this.$store.state.badaso.config.availableBanks)[bank]
    },
    openCancelDialog() {
      this.cancelDialog = true
      this.cancelMessage = null
    },
  },
};
</script>
