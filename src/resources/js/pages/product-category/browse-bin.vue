<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action">
        <vs-button
          color="success"
          type="relief"
          v-if="selected.length > 0 && $helper.isAllowed('restore_product_categories')"
          @click.stop
          @click="confirmRestoreMultiple"
          ><vs-icon icon="restore"></vs-icon> {{ $t("action.bulkRestore") }}</vs-button
        >
        <vs-button
          color="danger"
          type="relief"
          v-if="selected.length > 0 && $helper.isAllowed('delete_permanent_product_categories')"
          @click.stop
          @click="confirmDeleteMultiple"
          ><vs-icon icon="delete_sweep"></vs-icon>
          {{ $t("action.bulkDelete") }}</vs-button
        >
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('browse_product_categories_bin')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("productCategories.browseBin.title") }}</h3>
          </div>
          <div>
            <badaso-table
              multiple
              v-model="selected"
              pagination
              max-items="10"
              search
              :data="productCategories"
              stripe
              description
              :description-items="descriptionItems"
              :description-title="$t('productCategories.browseBin.footer.descriptionTitle')"
              :description-connector="$t('productCategories.browseBin.footer.descriptionConnector')"
              :description-body="$t('productCategories.browseBin.footer.descriptionBody')"
            >
              <template slot="thead">
                <badaso-th sort-key="name"> {{ $t("productCategories.browseBin.header.name") }} </badaso-th>
                <badaso-th sort-key="slug"> {{ $t("productCategories.browseBin.header.slug") }} </badaso-th>
                <badaso-th sort-key="desc"> {{ $t("productCategories.browseBin.header.desc") }} </badaso-th>
                <badaso-th sort-key="SKU"> {{ $t("productCategories.browseBin.header.SKU") }} </badaso-th>
                <badaso-th sort-key="deletedAt"> {{ $t("productCategories.browseBin.header.deletedAt") }} </badaso-th>

                <vs-th> {{ $t("productCategories.browseBin.header.action") }} </vs-th>
              </template>

              <template slot-scope="{ data }">
                <vs-tr :data="productCategory" :key="index" v-for="(productCategory, index) in data">
                  <vs-td :data="productCategory.name">
                    {{ productCategory.name }}
                  </vs-td>
                  <vs-td :data="productCategory.slug">
                    {{ productCategory.slug }}
                  </vs-td>
                  <vs-td :data="productCategory.desc">
                    {{ productCategory.desc }}
                  </vs-td>
                  <vs-td :data="productCategory.SKU">
                    {{ productCategory.SKU }}
                  </vs-td>
                  <vs-td :data="productCategory.deletedAt">
                    {{ getDate(productCategory.deletedAt) }}
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
                          @click="confirmRestore(productCategory.id)"
                          v-if="$helper.isAllowed('restore_product_categories')"
                        >
                          Restore
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="edit"
                          @click="confirmDelete(productCategory.id)"
                          v-if="$helper.isAllowed('delete_permanent_product_categories')"
                        >
                          Delete Permanent
                        </badaso-dropdown-item>
                      </vs-dropdown-menu>
                    </badaso-dropdown>
                  </vs-td>
                </vs-tr>
              </template>
            </badaso-table>
          </div>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
import moment from 'moment'
export default {
  name: "ProductCategoryBrowseBin",
  components: {},
  data() {
    return {
      selected: [],
      productCategories: [],
      descriptionItems: [10, 50, 100],
      totalItem: 0,
      filter: "",
      page: 1,
      limit: 10,
      orderField: "deletedAt",
      orderDirection: "desc",
      willDeleteId: null,
      willRestoreId: null,
    }
  },
  mounted() {
    this.getProductCategoryList()
  },
  methods: {
    getDate(date) {
      return moment(date).format('dddd, DD MMMM YYYY')
    },
    confirmRestore(id) {
      this.willRestoreId = id;
      this.$vs.dialog({
        type: "confirm",
        color: "success",
        title: this.$t("action.restore.title"),
        text: this.$t("action.restore.text"),
        accept: this.restoreProductCategory,
        acceptText: this.$t("action.restore.accept"),
        cancelText: this.$t("action.restore.cancel"),
        cancel: () => {
          this.willRestoreId = null;
        },
      });
    },
    confirmDelete(id) {
      this.willDeleteId = id;
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("action.delete.title"),
        text: this.$t("action.delete.text"),
        accept: this.deleteProductCategory,
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {
          this.willDeleteId = null;
        },
      });
    },
    confirmRestoreMultiple() {
      this.$vs.dialog({
        type: "confirm",
        color: "success",
        title: this.$t("action.restore.title"),
        text: this.$t("action.restore.text"),
        accept: this.bulkRestoreProductCategory,
        acceptText: this.$t("action.restore.accept"),
        cancelText: this.$t("action.restore.cancel"),
        cancel: () => {},
      });
    },
    confirmDeleteMultiple() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("action.delete.title"),
        text: this.$t("action.delete.text"),
        accept: this.bulkDeleteProductCategory,
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {},
      });
    },
    deleteProductCategory() {
      this.$openLoader();
      this.$api.badasoProductCategory
        .forceDelete({ id: this.willDeleteId })
        .then((response) => {
          this.$closeLoader();
          this.getProductCategoryList();
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
    restoreProductCategory() {
      this.$openLoader();
      this.$api.badasoProductCategory
        .restore({ id: this.willRestoreId })
        .then((response) => {
          this.$closeLoader();
          this.getProductCategoryList();
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
    bulkDeleteProductCategory() {
      const ids = this.selected.map((item) => item.id);
      this.$openLoader();
      this.$api.badasoProductCategory
      .forceDeleteMultiple({
        ids: ids.join(","),
      })
      .then((response) => {
        this.$closeLoader();
        this.getProductCategoryList();
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
    bulkRestoreProductCategory() {
      const ids = this.selected.map((item) => item.id);
      this.$openLoader();
      this.$api.badasoProductCategory
      .restoreMultiple({
        ids: ids.join(","),
      })
      .then((response) => {
        this.$closeLoader();
        this.getProductCategoryList();
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
    getProductCategoryList() {
      this.$openLoader();
      this.$api.badasoProductCategory
      .browseBin()
      .then((response) => {
        this.$closeLoader();
        this.selected = [];
        this.productCategories = response.data.productCategories;
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
