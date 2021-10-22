<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action">
        <vs-button
          color="primary"
          type="relief"
          :to="{ name: 'PaymentAdd' }"
          v-if="$helper.isAllowed('add_payments')"
          ><vs-icon icon="add"></vs-icon> {{ $t("action.add") }}</vs-button
        >
        <vs-button
          color="danger"
          type="relief"
          v-if="selected.length > 0 && $helper.isAllowed('delete_payments')"
          @click.stop
          @click="confirmDeleteMultiple"
          ><vs-icon icon="delete_sweep"></vs-icon>
          {{ $t("action.bulkDelete") }}</vs-button
        >
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('browse_payments')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("payments.browse.title") }}</h3>
          </div>
          <div>
            <badaso-server-side-table
              v-model="selected"
              :data="payments.data"
              stripe
              :pagination-data="payments"
              :description-items="descriptionItems"
              :description-title="$t('payments.browse.footer.descriptionTitle')"
              :description-connector="$t('payments.browse.footer.descriptionConnector')"
              :description-body="$t('payments.browse.footer.descriptionBody')"
              @search="handleSearch"
              @changePage="handleChangePage"
              @changeLimit="handleChangeLimit"
              @select="handleSelect"
              @sort="handleSort"
            >
              <template slot="thead">
                <badaso-th sort-key="slug"> {{ $t("payments.browse.header.slug") }} </badaso-th>
                <badaso-th sort-key="name"> {{ $t("payments.browse.header.name") }} </badaso-th>
                <badaso-th sort-key="isActive"> {{ $t("payments.browse.header.isActive") }} </badaso-th>
                <vs-th> {{ $t("payments.browse.header.action") }} </vs-th>
              </template>

              <template slot="tbody">
                <vs-tr :data="payment" :key="index" v-for="(payment, index) in payments.data">
                  <vs-td :data="payment.slug">
                    {{ payment.slug }}
                  </vs-td>
                  <vs-td :data="payment.name">
                    {{ payment.name }}
                  </vs-td>
                  <vs-td :data="payment.isActive">
                    <vs-icon color="success" v-if="payment.isActive == 1" icon="radio_button_checked" />
                    <vs-icon color="gray" v-else icon="radio_button_unchecked" />
                  </vs-td>
                  <vs-td style="width: 1%; white-space: nowrap">
                    <badaso-dropdown vs-trigger-click>
                      <vs-button
                        size="large"
                        type="flat"
                        icon="more_vert"
                      ></vs-button>
                      <vs-dropdown-menu>
                        <badaso-dropdown-item
                          icon="list"
                          v-if="$helper.isAllowed('edit_payments')"
                          :to="{
                            name: 'PaymentOption',
                            params: { id: payment.id },
                          }"
                        >
                          Manage Options
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="visibility"
                          :to="{ name: 'PaymentRead', params: { id: payment.id } }"
                          v-if="$helper.isAllowed('read_payments')"
                        >
                          Read
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="edit"
                          :to="{ name: 'PaymentEdit', params: { id: payment.id } }"
                          v-if="$helper.isAllowed('edit_payments')"
                        >
                          Edit
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="delete"
                          @click="confirmDelete(payment.id)"
                          v-if="$helper.isAllowed('delete_payments')"
                        >
                          Delete
                        </badaso-dropdown-item>
                      </vs-dropdown-menu>
                    </badaso-dropdown>
                  </vs-td>
                </vs-tr>
              </template>
            </badaso-server-side-table>
          </div>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
export default {
  name: "PaymentBrowse",
  components: {},
  data() {
    return {
      selected: [],
      payments: {
        data: []
      },
      descriptionItems: [10, 50, 100],
      totalItem: 0,
      filter: "",
      page: 1,
      limit: 10,
      orderField: "updatedAt",
      orderDirection: "desc",
      willDeleteId: null
    }
  },
  mounted() {
    this.getPaymentList()
  },
  methods: {
    confirmDelete(id) {
      this.willDeleteId = id;
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("action.delete.title"),
        text: this.$t("action.delete.text"),
        accept: this.deletePayment,
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {
          this.willDeleteId = null;
        },
      });
    },
    confirmDeleteMultiple(id) {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("action.delete.title"),
        text: this.$t("action.delete.text"),
        accept: this.bulkDeletePayment,
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {},
      });
    },
    bulkDeletePayment() {
      const ids = this.selected.map((item) => item.id);
      this.$openLoader();
      this.$api.badasoPayment
        .deleteMultiple({
          ids: ids.join(","),
        })
        .then((response) => {
          this.$closeLoader();
          this.getPaymentList();
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
    deletePayment() {
      this.$openLoader();
      this.$api.badasoPayment
        .delete({ id: this.willDeleteId })
        .then((response) => {
          this.$closeLoader();
          this.getPaymentList();
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
    getPaymentList() {
      this.$openLoader();
      this.$api.badasoPayment
      .browse({
        page: this.page,
      })
      .then((response) => {
        this.$closeLoader();
        this.selected = [];
        this.payments = response.data.payments;
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
    handleSearch(e) {
      this.filter = e.target.value;
      this.page = 1;
      this.getPaymentList();
    },
    handleChangePage(page) {
      this.page = page;
      this.getPaymentList();
    },
    handleChangeLimit(limit) {
      this.page = 1;
      this.limit = limit;
      this.getPaymentList();
    },
    handleSort(field, direction) {
      this.orderField = field;
      this.orderDirection = direction;
      this.getPaymentList();
    },
    handleSelect(data) {
      this.selected = data;
    },
  },
};
</script>
