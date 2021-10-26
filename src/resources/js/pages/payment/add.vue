<template>
  <div>
    <badaso-breadcrumb-row></badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('add_payments')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("payments.add.title") }}</h3>
          </div>
          <vs-row>
            <badaso-text
              v-model="payment.name"
              size="6"
              :label="$t('payments.add.field.name.title')"
              :placeholder="$t('payments.add.field.name.placeholder')"
              :alert="errors.name"
            ></badaso-text>
            <badaso-text
              v-model="payment.slug"
              size="6"
              :label="$t('payments.add.field.slug.title')"
              :placeholder="$t('payments.add.field.slug.placeholder')"
              :alert="errors.slug"
            ></badaso-text>
            <badaso-switch
              v-model="payment.isActive"
              size="6"
              :label="$t('payments.add.field.isActive.title')"
              :placeholder="$t('payments.add.field.isActive.placeholder')"
              :alert="errors.isActive"
            ></badaso-switch>
          </vs-row>
        </vs-card>
      </vs-col>
      <vs-col vs-lg="12">
        <vs-card class="action-card">
          <vs-row>
            <vs-col vs-lg="12">
              <vs-button color="primary" type="relief" @click="submitForm">
                <vs-icon icon="save"></vs-icon> {{ $t("payments.add.button") }}
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
  name: "PaymentAdd",
  components: {},
  data() {
    return {
      errors: {},
      payment: {
        name: null,
        slug: null,
        isActive: true,
      },
    }
  },
  watch: {
    'payment.name': {
      handler(val) {
        if (val) this.payment.slug = this.$helper.generateSlug(val)
      }
    }
  },
  methods: {
    submitForm() {
      this.errors = {};
      this.$openLoader();
      this.$api.badasoPayment
        .add(this.payment)
        .then((response) => {
          this.$closeLoader();
          this.$router.push({ name: "PaymentBrowse" });
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
    },
  },
};
</script>