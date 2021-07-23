<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action">
        <vs-button
          color="warning"
          type="relief"
          :to="{ name: 'PaymentProviderEdit', params: { id: $route.params.id } }"
          v-if="$helper.isAllowed('edit_payment_providers')"
          ><vs-icon icon="edit"></vs-icon> {{ $t("action.edit") }}</vs-button
        >
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('read_payment_providers')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("paymentProvider.detail.title") }}</h3>
          </div>
          <table class="badaso-table">
            <tr>
              <th>{{ $t("paymentProvider.detail.header.name") }}</th>
              <td>{{ paymentProvider.name }}</td>
            </tr>
            <tr>
              <th>{{ $t("paymentProvider.detail.header.createdAt") }}</th>
              <td>{{ getDate(paymentProvider.createdAt) }}</td>
            </tr>
            <tr>
              <th>{{ $t("paymentProvider.detail.header.updatedAt") }}</th>
              <td>{{ getDate(paymentProvider.updatedAt) }}</td>
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
    paymentProvider: {
      name: "",
      createdAt: "",
      updatedAt: ""
    }
  }),
  mounted() {
    this.getPaymentProviderDetail();
  },
  methods: {
    getDate(date) {
      return moment(date).format('dddd, DD MMMM YYYY')
    },
    getPaymentProviderDetail() {
      this.$openLoader();
      this.$api.badasoPaymentProvider
      .read({ id: this.$route.params.id, })
      .then((response) => {
        this.$closeLoader();
        this.paymentProvider = response.data.paymentProvider;
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
