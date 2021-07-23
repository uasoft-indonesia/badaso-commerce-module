<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action">
        <vs-button
          color="success"
          type="relief"
          v-if="selected.length > 0 && $helper.isAllowed('restore_products')"
          @click.stop
          @click="confirmRestoreMultiple"
          ><vs-icon icon="restore"></vs-icon> {{ $t("action.bulkRestore") }}</vs-button
        >
        <vs-button
          color="danger"
          type="relief"
          v-if="selected.length > 0 && $helper.isAllowed('delete_permanent_products')"
          @click.stop
          @click="confirmDeleteMultiple"
          ><vs-icon icon="delete_sweep"></vs-icon>
          {{ $t("action.bulkDelete") }}</vs-button
        >
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('browse_products_bin')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("product.browseBin.title") }}</h3>
          </div>
          <div>
            <badaso-server-side-table
              v-model="selected"
              :data="products.data"
              stripe
              :pagination-data="products"
              :description-items="descriptionItems"
              :description-title="$t('product.browseBin.footer.descriptionTitle')"
              :description-connector="$t('product.browseBin.footer.descriptionConnector')"
              :description-body="$t('product.browseBin.footer.descriptionBody')"
              @search="handleSearch"
              @changePage="handleChangePage"
              @changeLimit="handleChangeLimit"
              @select="handleSelect"
              @sort="handleSort"
            >
              <template slot="thead">
                <badaso-th> {{ $t("product.browseBin.header.productImage") }} </badaso-th>
                <badaso-th sort-key="name"> {{ $t("product.browseBin.header.name") }} </badaso-th>
                <badaso-th sort-key="slug"> {{ $t("product.browseBin.header.slug") }} </badaso-th>
                <badaso-th sort-key="category"> {{ $t("product.browseBin.header.productCategoryId") }} </badaso-th>
                <badaso-th sort-key="deletedAt"> {{ $t("product.browseBin.header.deletedAt") }} </badaso-th>
                <vs-th> {{ $t("product.browseBin.header.action") }} </vs-th>
              </template>

              <template slot="tbody">
                <vs-tr :data="product" :key="index" v-for="(product, index) in products.data">
                  <vs-td :data="product.productImage">
                    <img width="100" :src="$store.state.badaso.meta.mediaBaseUrl + product.productImage" loading="lazy">
                  </vs-td>
                  <vs-td :data="product.name">
                    {{ product.name }}
                  </vs-td>
                  <vs-td :data="product.slug">
                    {{ product.slug }}
                  </vs-td>
                  <vs-td :data="product.productCategory">
                    {{ product.productCategory ? product.productCategory.name : null }}
                  </vs-td>
                  <vs-td :data="product.deletedAt">
                    {{ getDate(product.deletedAt) }}
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
                          icon="restore"
                          @click="confirmRestore(product.id)"
                          v-if="$helper.isAllowed('restore_products')"
                        >
                          Restore
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="edit"
                          @click="confirmDelete(product.id)"
                          v-if="$helper.isAllowed('delete_permanent_products')"
                        >
                          Delete Permanent
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
  name: "ProductBrowseBin",
  components: {},
  data() {
    return {
      selected: [],
      products: {
        data: []
      },
      descriptionItems: [10, 50, 100],
      totalItem: 0,
      filter: "",
      page: 1,
      limit: 10,
      orderField: "deletedAt",
      orderDirection: "desc",
      willRestoreId: null,
      willDeleteId: null
    }
  },
  mounted() {
    this.getProductList()
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
        accept: this.deleteProduct,
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {
          this.willDeleteId = null;
        },
      });
    },
    deleteProduct() {
      this.$openLoader();
      this.$api.badasoProduct
      .forceDelete({ id: this.willDeleteId })
      .then((response) => {
        this.$closeLoader();
        this.getProductList();
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
    confirmRestore(id) {
      this.willRestoreId = id
      this.$vs.dialog({
        type: "confirm",
        color: "success",
        title: this.$t("action.restore.title"),
        text: this.$t("action.restore.text"),
        accept: this.restoreProducts,
        acceptText: this.$t("action.restore.accept"),
        cancelText: this.$t("action.restore.cancel"),
        cancel: () => {},
      });
    },
    confirmRestoreMultiple() {
      this.$vs.dialog({
        type: "confirm",
        color: "success",
        title: this.$t("action.restore.title"),
        text: this.$t("action.restore.text"),
        accept: this.bulkRestoreProducts,
        acceptText: this.$t("action.restore.accept"),
        cancelText: this.$t("action.restore.cancel"),
        cancel: () => {},
      });
    },
    confirmDeleteMultiple(id) {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("action.delete.title"),
        text: this.$t("action.delete.text"),
        accept: this.bulkDeleteProduct,
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {},
      });
    },
    bulkDeleteProduct() {
      const ids = this.selected.map((item) => item.id);
      this.$openLoader();
      this.$api.badasoProduct
        .forceDeleteMultiple({
          ids: ids.join(","),
        })
        .then((response) => {
          this.$closeLoader();
          this.getProductList();
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
    bulkRestoreProducts() {
      const ids = this.selected.map((item) => item.id);
      this.$openLoader();
      this.$api.badasoProduct
      .restoreMultiple({
        ids: ids.join(","),
      })
      .then((response) => {
        this.$closeLoader();
        this.getProductList();
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
    restoreProducts() {
      this.$openLoader();
      this.$api.badasoProduct
      .restore({
        id: this.willRestoreId,
      })
      .then((response) => {
        this.$closeLoader();
        this.getProductList();
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
    getProductList() {
      this.$openLoader();
      this.$api.badasoProduct
      .browseBin({ limit: this.limit, page: this.page, relation: ['productCategory'] })
      .then((response) => {
        this.$closeLoader();
        this.selected = [];
        this.products = response.data.products;
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
      this.getProductList();
    },
    handleChangePage(page) {
      this.page = page;
      this.getProductList();
    },
    handleChangeLimit(limit) {
      this.page = 1;
      this.limit = limit;
      this.getProductList();
    },
    handleSort(field, direction) {
      this.orderField = field;
      this.orderDirection = direction;
      this.getProductList();
    },
    handleSelect(data) {
      this.selected = data;
    },
  },
};
</script>
