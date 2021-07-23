<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action">
        <vs-button
          color="warning"
          type="relief"
          :to="{ name: 'DiscountEdit', params: { id: $route.params.id } }"
          v-if="$helper.isAllowed('edit_discounts')"
          ><vs-icon icon="edit"></vs-icon> {{ $t("action.edit") }}</vs-button
        >
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('read_discounts')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("discounts.detail.title") }}</h3>
          </div>
          <table class="badaso-table">
            <tr>
              <th>{{ $t("discounts.detail.header.name") }}</th>
              <td>{{ discount.name }}</td>
            </tr>
            <tr>
              <th>{{ $t("discounts.detail.header.desc") }}</th>
              <td>{{ discount.desc }}</td>
            </tr>
            <tr>
              <th>{{ $t("discounts.detail.header.discountType") }}</th>
              <td style="text-transform: capitalize;">{{ discount.discountType }}</td>
            </tr>
            <tr>
              <th>{{ $t("discounts.detail.header.discountPercent") }}</th>
              <td>{{ discount.discountPercent + '%' }}</td>
            </tr>
            <tr>
              <th>{{ $t("discounts.detail.header.discountFixed") }}</th>
              <td>{{ discount.discountFixed | toCurrency }}</td>
            </tr>
            <tr>
              <th>{{ $t("discounts.detail.header.createdAt") }}</th>
              <td>{{ getDate(discount.createdAt) }}</td>
            </tr>
            <tr>
              <th>{{ $t("discounts.detail.header.updatedAt") }}</th>
              <td>{{ getDate(discount.updatedAt) }}</td>
            </tr>
            <tr>
              <th>{{ $t("discounts.detail.header.deletedAt") }}</th>
              <td>{{ discount.deletedAt ? getDate(discount.deletedAt) : 'None' }}</td>
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
  name: "DiscountRead",
  components: {},
  data: () => ({
    discount: {
      name: "",
      desc: "",
      discountType: "",
      discountPercent: "",
      discountFixed: "",
      createdAt: "",
      updatedAt: ""
    }
  }),
  mounted() {
    this.getDiscountDetail();
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
    getDiscountDetail() {
      this.$openLoader();
      this.$api.badasoDiscount
      .read({ id: this.$route.params.id, })
      .then((response) => {
        this.$closeLoader();
        this.discount = response.data.discount;
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
