<template>
  <div>
    <badaso-breadcrumb-row></badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('add_payment_providers')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("paymentProvider.add.title") }}</h3>
          </div>
          <vs-row>
            <badaso-text
              v-model="paymentProvider.name"
              size="12"
              :label="$t('paymentProvider.add.field.name.title')"
              :placeholder="$t('paymentProvider.add.field.name.placeholder')"
              :alert="errors.name"
            ></badaso-text>
          </vs-row>
        </vs-card>
      </vs-col>
      <vs-col vs-lg="12">
        <vs-card class="action-card">
          <vs-row>
            <vs-col vs-lg="12">
              <vs-button color="primary" type="relief" @click="submitForm">
                <vs-icon icon="save"></vs-icon> {{ $t("paymentProvider.add.button") }}
              </vs-button>
            </vs-col>
          </vs-row>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
export default {
  name: "DiscountAdd",
  components: {},
  data() {
    return {
      errors: {},
      paymentProvider: {
        name: null,
      },
    }
  },
  methods: {
    submitForm() {
      this.errors = {};
      try {
        this.$openLoader();
        this.$api.badasoPaymentProvider
          .add(this.paymentProvider)
          .then((response) => {
            this.$closeLoader();
            this.$router.push({ name: "PaymentProviderBrowse" });
          })
          .catch((error) => {
            this.errors = error.errors;
            this.$closeLoader();
            this.$vs.notify({
              title: this.$t("alert.danger"),
              text: error.message,
              color: "danger",
            });
          });
      } catch (error) {
        this.errors = error.data
        this.$vs.notify({
          title: this.$t("alert.danger"),
          text: error.message,
          color: "danger",
        });
      }
    },
  },
};
</script>