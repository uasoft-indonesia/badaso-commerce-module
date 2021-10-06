<template>
  <div>
    <badaso-breadcrumb-row> </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('edit_product_categories')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("productCategories.edit.title") }}</h3>
          </div>
          <vs-row>
            <badaso-text
              v-model="productCategory.name"
              size="6"
              :label="$t('productCategories.edit.field.name.title')"
              :placeholder="$t('productCategories.edit.field.name.placeholder')"
              :alert="errors.name"
            ></badaso-text>
            <badaso-text
              disabled
              v-model="productCategory.slug"
              size="6"
              :label="$t('productCategories.edit.field.slug.title')"
              :placeholder="$t('productCategories.edit.field.slug.placeholder')"
              :alert="errors.slug"
            ></badaso-text>
            <badaso-text
              v-model="productCategory.SKU"
              size="6"
              :label="$t('productCategories.edit.field.SKU.title')"
              :placeholder="$t('productCategories.edit.field.SKU.placeholder')"
              :alert="errors.SKU"
            ></badaso-text>
            <badaso-select
              v-model="productCategory.parentId"
              size="6"
              :label="$t('productCategories.edit.field.parent.title')"
              :placeholder="$t('productCategories.edit.field.parent.placeholder')"
              :alert="errors.parentId"
              :items="categories"
            ></badaso-select>
            <badaso-textarea
              v-model="productCategory.desc"
              size="6"
              :label="$t('productCategories.edit.field.desc.title')"
              :placeholder="$t('productCategories.edit.field.desc.placeholder')"
              :alert="errors.desc"
            ></badaso-textarea>
            <badaso-upload-image
              v-model="productCategory.image"
              size="6"
              :label="$t('productCategories.add.field.image.title')"
              :placeholder="$t('productCategories.add.field.image.placeholder')"
              :alert="errors.image"
            ></badaso-upload-image>
          </vs-row>
        </vs-card>
      </vs-col>
      <vs-col vs-lg="12">
        <vs-card class="action-card">
          <vs-row>
            <vs-col vs-lg="12">
              <vs-button color="primary" type="relief" @click="submitForm">
                <vs-icon icon="save"></vs-icon> {{ $t("productCategories.edit.button") }}
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
  name: "ProductCategoryEdit",
  components: {},
  data: () => ({
    errors: {},
    productCategory: {
      name: '',
      slug: '',
      desc: '',
      parentId: '',
      SKU: '',
      image: ''
    },
    categories: []
  }),
  mounted() {
    this.getProductCategory()
    this.getProductCategories()
  },
  methods: {
    submitForm() {
      this.errors = {};
      try {
        this.$openLoader();
        this.$api.badasoProductCategory
          .edit(this.productCategory)
          .then((response) => {
            this.$closeLoader();
            this.$router.push({ name: "ProductCategoryBrowse" });
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
    getProductCategory() {
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
    getProductCategories() {
      this.$openLoader();
      this.$api.badasoProductCategory
      .browse()
      .then((response) => {
        this.$closeLoader();
        this.categories = response.data.productCategories.map((category, index) => {
          return {
            label: category.name,
            value: category.id
          }
        });
      })
      .catch((error) => {
        this.$closeLoader();
        this.$vs.notify({
          title: this.$t("alert.danger"),
          text: error.message,
          color: "danger",
        });
      });
    }
  },
};
</script>