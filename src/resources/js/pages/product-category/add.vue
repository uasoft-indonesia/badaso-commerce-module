<template>
  <div>
    <badaso-breadcrumb-row> </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('add_product_categories')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("productCategories.add.title") }}</h3>
          </div>
          <vs-row>
            <badaso-text
              v-model="productCategory.name"
              size="6"
              :label="$t('productCategories.add.field.name.title')"
              :placeholder="$t('productCategories.add.field.name.placeholder')"
              :alert="errors.name"
            ></badaso-text>
            <badaso-text
              v-model="productCategory.slug"
              size="6"
              :label="$t('productCategories.add.field.slug.title')"
              :placeholder="$t('productCategories.add.field.slug.placeholder')"
              :alert="errors.slug"
            ></badaso-text>
            <badaso-text
              v-model="productCategory.SKU"
              size="6"
              :label="$t('productCategories.add.field.SKU.title')"
              :placeholder="$t('productCategories.add.field.SKU.placeholder')"
              :alert="errors.SKU"
            ></badaso-text>
            <badaso-select
              v-model="productCategory.parentId"
              size="6"
              :label="$t('productCategories.add.field.parent.title')"
              :placeholder="$t('productCategories.add.field.parent.placeholder')"
              :alert="errors.parentId"
              :items="categories"
            ></badaso-select>
            <badaso-textarea
              v-model="productCategory.desc"
              size="6"
              :label="$t('productCategories.add.field.desc.title')"
              :placeholder="$t('productCategories.add.field.desc.placeholder')"
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
                <vs-icon icon="save"></vs-icon> {{ $t("productCategories.add.button") }}
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
  name: "ProductCategoryAdd",
  components: {},
  data: () => ({
    errors: {},
    productCategory: {
      name: null,
      slug: null,
      desc: null,
      parentId: '',
      SKU: null,
      image: null,
    },
    categories: []
  }),
  mounted() {
    this.getProductCategories()
  },
  watch: {
    'productCategory.name': {
      handler(val) {
        this.productCategory.slug = this.$helper.generateSlug(val)
      }
    }
  },
  methods: {
    submitForm() {
      this.errors = {};
      try {
        this.$openLoader();
        this.$api.badasoProductCategory
          .add(this.productCategory)
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
    },
  },
};
</script>