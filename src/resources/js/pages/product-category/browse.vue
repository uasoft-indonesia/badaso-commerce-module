<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action">
        <vs-button
          color="primary"
          type="relief"
          :to="{ name: 'ProductCategoryAdd' }"
          v-if="$helper.isAllowed('add_product_categories')"
          ><vs-icon icon="add"></vs-icon> {{ $t("action.add") }}</vs-button
        >
        <vs-button
          color="danger"
          type="relief"
          :to="{ name: 'ProductCategoryBrowseBin' }"
          v-if="$helper.isAllowed('browse_product_categories_bin')"
          ><vs-icon icon="delete"></vs-icon> {{ $t("action.bin") }}</vs-button
        >
        <vs-button
          color="danger"
          type="relief"
          v-if="selected.length > 0 && $helper.isAllowed('delete_product_categories')"
          @click.stop
          @click="confirmDeleteMultiple"
          ><vs-icon icon="delete_sweep"></vs-icon>
          {{ $t("action.bulkDelete") }}</vs-button
        >
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('browse_product_categories')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("productCategories.browse.title") }}</h3>
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
              :description-title="$t('productCategories.browse.footer.descriptionTitle')"
              :description-connector="$t('productCategories.browse.footer.descriptionConnector')"
              :description-body="$t('productCategories.browse.footer.descriptionBody')"
            >
              <template slot="thead">
                <badaso-th sort-key="name"> {{ $t("productCategories.browse.header.name") }} </badaso-th>
                <badaso-th sort-key="slug"> {{ $t("productCategories.browse.header.slug") }} </badaso-th>
                <badaso-th sort-key="children"> {{ $t("productCategories.browse.header.children") }} </badaso-th>
                <badaso-th sort-key="SKU"> {{ $t("productCategories.browse.header.SKU") }} </badaso-th>
                <badaso-th sort-key="createdAt"> {{ $t("productCategories.browse.header.createdAt") }} </badaso-th>
                <badaso-th sort-key="updatedAt"> {{ $t("productCategories.browse.header.updatedAt") }} </badaso-th>
                <vs-th> {{ $t("productCategories.browse.header.action") }} </vs-th>
              </template>

              <template slot-scope="{ data }">
                <vs-tr :data="productCategory" :key="index" v-for="(productCategory, index) in data">
                  <vs-td :data="productCategory.name">
                    {{ productCategory.name }}
                  </vs-td>
                  <vs-td :data="productCategory.slug">
                    {{ productCategory.slug }}
                  </vs-td>
                  <vs-td :data="productCategory.children">
                    <p class="mb-0" v-for="(child, index) in productCategory.children" :key="index">
                      - {{ child.name }}
                    </p>
                  </vs-td>
                  <vs-td :data="productCategory.SKU">
                    {{ productCategory.SKU }}
                  </vs-td>
                  <vs-td :data="productCategory.createdAt">
                    {{ getDate(productCategory.createdAt) }}
                  </vs-td>
                  <vs-td :data="productCategory.updatedAt">
                    {{ getDate(productCategory.updatedAt) }}
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
                          :to="{ name: 'ProductCategoryRead', params: { id: productCategory.id } }"
                          v-if="$helper.isAllowed('read_product_categories')"
                        >
                          Detail
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="edit"
                          :to="{ name: 'ProductCategoryEdit', params: { id: productCategory.id } }"
                          v-if="$helper.isAllowed('edit_product_categories')"
                        >
                          Edit
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="delete"
                          @click="confirmDelete(productCategory.id)"
                          v-if="$helper.isAllowed('delete_product_categories')"
                        >
                          Delete
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
  name: "ProductCategoryBrowse",
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
      orderField: "updated_at",
      orderDirection: "desc",
      willDeleteId: null
    }
  },
  mounted() {
    this.getProductCategoryList()
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
        accept: this.deleteProductCategory,
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
        accept: this.bulkDeleteProductCategories,
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {},
      });
    },
    deleteProductCategory() {
      this.$openLoader();
      this.$api.badasoProductCategory
        .delete({ id: this.willDeleteId })
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
    bulkDeleteProductCategories() {
      const ids = this.selected.map((item) => item.id);
      this.$openLoader();
      this.$api.badasoProductCategory
        .deleteMultiple({
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
      .browse()
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
