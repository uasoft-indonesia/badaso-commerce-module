<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action">
        <vs-button
          color="primary"
          type="relief"
          :to="{ name: 'PaymentProviderAdd' }"
          v-if="$helper.isAllowed('add_payment_providers')"
          ><vs-icon icon="add"></vs-icon> {{ $t("action.add") }}</vs-button
        >
        <vs-button
          color="danger"
          type="relief"
          v-if="selected.length > 0 && $helper.isAllowed('delete_payment_providers')"
          @click.stop
          @click="confirmDeleteMultiple"
          ><vs-icon icon="delete_sweep"></vs-icon>
          {{ $t("action.bulkDelete") }}</vs-button
        >
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('browse_payment_providers')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("paymentProvider.browse.title") }}</h3>
          </div>
          <div>
            <badaso-server-side-table
              v-model="selected"
              :data="paymentProviders.data"
              stripe
              :pagination-data="paymentProviders"
              :description-items="descriptionItems"
              :description-title="$t('paymentProvider.browse.footer.descriptionTitle')"
              :description-connector="$t('paymentProvider.browse.footer.descriptionConnector')"
              :description-body="$t('paymentProvider.browse.footer.descriptionBody')"
              @search="handleSearch"
              @changePage="handleChangePage"
              @changeLimit="handleChangeLimit"
              @select="handleSelect"
              @sort="handleSort"
            >
              <template slot="thead">
                <badaso-th sort-key="name"> {{ $t("paymentProvider.browse.header.name") }} </badaso-th>
                <badaso-th sort-key="createdAt"> {{ $t("paymentProvider.browse.header.createdAt") }} </badaso-th>
                <badaso-th sort-key="updatedAt"> {{ $t("paymentProvider.browse.header.updatedAt") }} </badaso-th>
                <vs-th> {{ $t("paymentProvider.browse.header.action") }} </vs-th>
              </template>

              <template slot="tbody">
                <vs-tr :data="paymentProvider" :key="index" v-for="(paymentProvider, index) in paymentProviders.data">
                  <vs-td :data="paymentProvider.name">
                    {{ paymentProvider.name }}
                  </vs-td>
                  <vs-td :data="paymentProvider.createdAt">
                    {{ getDate(paymentProvider.createdAt) }}
                  </vs-td>
                  <vs-td :data="paymentProvider.updatedAt">
                    {{ getDate(paymentProvider.updatedAt) }}
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
                          icon="visibility"
                          :to="{
                            name: 'PaymentProviderRead',
                            params: { id: paymentProvider.id },
                          }"
                          v-if="$helper.isAllowed('read_payment_providers')"
                        >
                          Detail
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="edit"
                          :to="{
                            name: 'PaymentProviderEdit',
                            params: { id: paymentProvider.id },
                          }"
                          v-if="$helper.isAllowed('edit_payment_providers')"
                        >
                          Edit
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="delete"
                          @click="confirmDelete(paymentProvider.id)"
                          v-if="$helper.isAllowed('delete_payment_providers')"
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
import moment from 'moment'
export default {
  name: "PaymentProviderBrowse",
  components: {},
  data() {
    return {
      selected: [],
      paymentProviders: {
        data: []
      },
      descriptionItems: [10, 50, 100],
      totalItem: 0,
      filter: "",
      page: 1,
      limit: 10,
      orderField: "updated_at",
      orderDirection: "desc",
    }
  },
  mounted() {
    this.getPaymentProviderList()
  },
  methods: {
    getDate(date) {
      return moment(date).format('DD MMMM YYYY')
    },
    confirmDelete(id) {
      this.willDeleteId = id;
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("action.delete.title"),
        text: this.$t("action.delete.text"),
        accept: this.deletePaymentProvider,
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {
          this.willDeleteId = null;
        },
      });
    },
    deletePaymentProvider() {
      this.$openLoader();
      this.$api.badasoPaymentProvider
      .delete({ id: this.willDeleteId })
      .then((response) => {
        this.$closeLoader();
        this.getPaymentProviderList();
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
    confirmDeleteMultiple(id) {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("action.delete.title"),
        text: this.$t("action.delete.text"),
        accept: this.bulkDeletePaymentProvider,
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {},
      });
    },
    bulkDeletePaymentProvider() {
      const ids = this.selected.map((item) => item.id);
      this.$openLoader();
      this.$api.badasoPaymentProvider
        .deleteMultiple({
          ids: ids.join(","),
        })
        .then((response) => {
          this.$closeLoader();
          this.getPaymentProviderList();
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
    getPaymentProviderList() {
      this.$openLoader();
      this.$api.badasoPaymentProvider
      .browse({ limit: this.limit, page: this.page })
      .then((response) => {
        this.$closeLoader();
        this.selected = [];
        this.paymentProviders = response.data.paymentProviders;
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
      this.getPaymentProviderList();
    },
    handleChangePage(page) {
      this.page = page;
      this.getPaymentProviderList();
    },
    handleChangeLimit(limit) {
      this.page = 1;
      this.limit = limit;
      this.getPaymentProviderList();
    },
    handleSort(field, direction) {
      this.orderField = field;
      this.orderDirection = direction;
      this.getPaymentProviderList();
    },
    handleSelect(data) {
      this.selected = data;
    },
  },
};
</script>
