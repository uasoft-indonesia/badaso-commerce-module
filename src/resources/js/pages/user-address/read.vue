<template>
  <div>
    <badaso-breadcrumb-row>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('read_user_addresses')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("userAddress.detail.title") }}</h3>
          </div>
          <table class="badaso-table">
            <tr>
              <th>{{ $t("userAddress.detail.header.name") }}</th>
              <td>{{ userAddress.user.name }}</td>
            </tr>
            <tr>
              <th>{{ $t("userAddress.detail.header.email") }}</th>
              <td>{{ userAddress.user.email }}</td>
            </tr>
            <tr>
              <th>{{ $t("userAddress.detail.header.address1") }}</th>
              <td>{{ userAddress.addressLine1 }}</td>
            </tr>
            <tr>
              <th>{{ $t("userAddress.detail.header.address2") }}</th>
              <td>{{ userAddress.addressLine2 }}</td>
            </tr>
            <tr>
              <th>{{ $t("userAddress.detail.header.city") }}</th>
              <td>{{ userAddress.city }}</td>
            </tr>
            <tr>
              <th>{{ $t("userAddress.detail.header.postalCode") }}</th>
              <td>{{ userAddress.postalCode }}</td>
            </tr>
            <tr>
              <th>{{ $t("userAddress.detail.header.country") }}</th>
              <td>{{ userAddress.country }}</td>
            </tr>
            <tr>
              <th>{{ $t("userAddress.detail.header.phone_number") }}</th>
              <td>{{ userAddress.phone_number }}</td>
            </tr>
            <tr>
              <th>{{ $t("userAddress.detail.header.is_main") }}</th>
              <td>{{ userAddress.is_main == 1 ? 'Main' : 'Not Main' }}</td>
            </tr>
            <tr>
              <th>{{ $t("userAddress.detail.header.createdAt") }}</th>
              <td>{{ getDate(userAddress.createdAt) }}</td>
            </tr>
            <tr>
              <th>{{ $t("userAddress.detail.header.updatedAt") }}</th>
              <td>{{ getDate(userAddress.updatedAt) }}</td>
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
    userAddress: {
      user: {
        name: "",
        email: "",
      },
      addressLine1: "",
      addressLine2: "",
      city: "",
      postalCode: "",
      country: "",
      phone_number: "",
      is_main: 0,
      createdAt: "",
      updatedAt: ""
    }
  }),
  mounted() {
    this.getUserAddressDetail();
  },
  methods: {
    getDate(date) {
      return moment(date).format('dddd, DD MMMM YYYY')
    },
    getUserAddressDetail() {
      this.$openLoader();
      this.$api.badasoUserAddress
      .read({ id: this.$route.params.id, relation: ['user'] })
      .then((response) => {
        this.$closeLoader();
        this.userAddress = response.data.userAddress;
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
