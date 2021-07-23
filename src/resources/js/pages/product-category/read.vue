<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action">
        <vs-button
          color="warning"
          type="relief"
          :to="{ name: 'ProductCategoryEdit', params: { id: $route.params.id } }"
          v-if="$helper.isAllowed('edit_product_categories')"
          ><vs-icon icon="edit"></vs-icon> {{ $t("action.edit") }}</vs-button
        >
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('read_product_categories')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("productCategories.detail.title") }}</h3>
          </div>
          <table class="badaso-table">
            <tr>
              <th>{{ $t("productCategories.detail.header.name") }}</th>
              <td>{{ productCategory.name }}</td>
            </tr>
            <tr>
              <th>{{ $t("productCategories.detail.header.slug") }}</th>
              <td>{{ productCategory.slug }}</td>
            </tr>
            <tr>
              <th>{{ $t("productCategories.detail.header.desc") }}</th>
              <td>{{ productCategory.desc }}</td>
            </tr>
            <tr>
              <th>{{ $t("productCategories.detail.header.SKU") }}</th>
              <td>{{ productCategory.SKU }}</td>
            </tr>
            <tr>
              <th>{{ $t("productCategories.detail.header.createdAt") }}</th>
              <td>{{ getDate(productCategory.createdAt) }}</td>
            </tr>
            <tr>
              <th>{{ $t("productCategories.detail.header.updatedAt") }}</th>
              <td>{{ getDate(productCategory.updatedAt) }}</td>
            </tr>
            <tr>
              <th>{{ $t("productCategories.detail.header.deletedAt") }}</th>
              <td>{{ productCategory.deletedAt ? (productCategory.deletedAt) : 'None' }}</td>
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
  name: "ProductCategoryRead",
  components: {},
  data: () => ({
    productCategory: {
      name: "",
      slug: "",
      desc: "",
      SKU: "",
      createdAt: "",
      updatedAt: "",
      deletedAt: ""
    }
  }),
  mounted() {
    this.getProductCategoryDetail();
  },
  methods: {
    getDate(date) {
      return moment(date).format('dddd, DD MMMM YYYY')
    },
    getProductCategoryDetail() {
      this.$openLoader();
      this.$api.badasoProductCategory
      .read({ id: this.$route.params.id, })
      .then((response) => {
        this.$closeLoader();
        this.productCategory = response.data.productCategory;
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
