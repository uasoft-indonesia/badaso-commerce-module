<template>
  <div>
    <badaso-breadcrumb-row> </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('add_products')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("product.add.title") }}</h3>
          </div>
          <vs-row>
            <vs-col vs-w="6" class="mb-3">
              <badaso-text
                v-model="product.name"
                size="12"
                :label="$t('product.add.field.name.title')"
                :placeholder="$t('product.add.field.name.placeholder')"
                :alert="errors.name"
                style="margin-bottom: 8px !important;"
              ></badaso-text>
              <template v-if="$v.product.$dirty">
                <span class="danger" v-if="$v.product.name.$anyError">{{ $t('vuelidate.error') }}</span>
              </template>
            </vs-col>
            <vs-col vs-w="6" class="mb-3">
              <badaso-text
                v-model="product.slug"
                size="12"
                :label="$t('product.add.field.slug.title')"
                :placeholder="$t('product.add.field.slug.placeholder')"
                :alert="errors.slug"
                style="margin-bottom: 8px !important;"
              ></badaso-text>
              <template v-if="$v.product.$dirty">
                <span class="danger" v-if="$v.product.slug.$anyError">{{ $t('vuelidate.error') }}</span>
              </template>
            </vs-col>
            <vs-col vs-w="6" class="mb-3">
              <badaso-select
                v-model="product.productCategoryId"
                size="12"
                :label="$t('product.add.field.productCategoryId.title')"
                :placeholder="$t('product.add.field.productCategoryId.placeholder')"
                :alert="errors.productCategoryId"
                :items="categories"
                style="margin-bottom: 8px !important;"
              ></badaso-select>
              <template v-if="$v.product.$dirty">
                <span class="danger" v-if="$v.product.productCategoryId.$anyError">{{ $t('vuelidate.error') }}</span>
              </template>
            </vs-col>
            <vs-col vs-w="6" class="mb-3">
              <badaso-upload-image
                v-model="product.productImage"
                size="12"
                :label="$t('product.add.field.productImage.title')"
                :placeholder="$t('product.add.field.productImage.placeholder')"
                :alert="errors.productImage"
                style="margin-bottom: 8px !important;"
              ></badaso-upload-image>
              <template v-if="$v.product.$dirty">
                <span class="danger" v-if="$v.product.productImage.$anyError">{{ $t('vuelidate.error') }}</span>
              </template>
            </vs-col>
            <badaso-textarea
              v-model="product.desc"
              size="6"
              :label="$t('product.add.field.desc.title')"
              :placeholder="$t('product.add.field.desc.placeholder')"
              :alert="errors.desc"
            ></badaso-textarea>
          </vs-row>
        </vs-card>
      </vs-col>
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("product.add.detail.title") }}</h3>
          </div>
          <badaso-table :data="items" stripe noDataText="">
            <template slot="thead">
              <badaso-th sort-key="productImage"> {{ $t("product.add.header.productImage") }} </badaso-th>
              <badaso-th sort-key="name"> {{ $t("product.add.header.name") }} </badaso-th>
              <badaso-th sort-key="quantity"> {{ $t("product.add.header.quantity") }} </badaso-th>
              <badaso-th sort-key="price"> {{ $t("product.add.header.price") }} </badaso-th>
              <badaso-th sort-key="discountId"> {{ $t("product.add.header.discount") }} </badaso-th>
              <badaso-th sort-key="SKU"> {{ $t("product.add.header.SKU") }} </badaso-th>
              <vs-th> {{ $t("product.add.header.action") }} </vs-th>
            </template>

            <template slot-scope="{ data }">
              <vs-tr :data="product" :key="index" v-for="(product, index) in data">
                <vs-td :data="product.productImage">
                  <img width="150" :src="product.productImage" loading="lazy">
                </vs-td>
                <vs-td :data="product.name">
                  {{ product.name }}
                </vs-td>
                <vs-td :data="product.quantity">
                  {{ product.quantity }}
                </vs-td>
                <vs-td :data="product.price">
                  {{ toCurrency(product.price) }}
                </vs-td>
                <vs-td :data="product.discountId">
                  {{ getDiscountName(product.discountId) }}
                </vs-td>
                <vs-td :data="product.SKU">
                  {{ product.SKU }}
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
                        icon="edit"
                        @click="openEditDialog(product, index)"
                      >
                        Edit
                      </badaso-dropdown-item>
                      <badaso-dropdown-item
                        icon="delete"
                        @click="openDeleteDialog(index)"
                      >
                        Delete
                      </badaso-dropdown-item>
                    </vs-dropdown-menu>
                  </badaso-dropdown>
                </vs-td>
              </vs-tr>
              <vs-tr>
                <vs-td colspan="8" class="product-detail__button--add">
                  <vs-button type="relief" icon="add" color="primary" @click="openAddProductDetail">
                    Add new product
                  </vs-button>
                </vs-td>
              </vs-tr>
            </template>
          </badaso-table>
        </vs-card>
      </vs-col>
      <vs-col vs-lg="12">
        <vs-card class="action-card">
          <vs-row>
            <vs-col vs-lg="12">
              <vs-button color="primary" type="relief" @click="submitForm">
                <vs-icon icon="save"></vs-icon> {{ $t("product.add.button") }}
              </vs-button>
            </vs-col>
          </vs-row>
        </vs-card>
      </vs-col>

      <vs-popup :title="$t('product.add.detail.add.title')" :active.sync="productDetailDialog">
        <vs-row>
          <vs-col vs-w="6" class="mb-3">
            <badaso-text
              v-model="addProductDetail.name"
              size="12"
              :label="$t('product.add.detail.add.field.name.title')"
              :placeholder="$t('product.add.detail.add.field.name.placeholder')"
              :alert="errors.name"
              style="margin-bottom: 8px !important;"
            ></badaso-text>
            <template v-if="$v.addProductDetail.$dirty">
              <span class="danger" v-if="$v.addProductDetail.name.$anyError">{{ $t('vuelidate.error') }}</span>
            </template>
          </vs-col>
          <vs-col vs-w="6" class="mb-3">
            <badaso-text
              v-model="addProductDetail.quantity"
              size="12"
              :label="$t('product.add.detail.add.field.quantity.title')"
              :placeholder="$t('product.add.detail.add.field.quantity.placeholder')"
              :alert="errors.quantity"
              style="margin-bottom: 8px !important;"
            ></badaso-text>
            <template v-if="$v.addProductDetail.$dirty">
              <span class="danger" v-if="$v.addProductDetail.quantity.$anyError">{{ $t('vuelidate.error') }}</span>
            </template>
          </vs-col>
          <vs-col vs-w="6" class="mb-3">
            <badaso-text
              v-model="addProductDetail.price"
              size="12"
              :label="$t('product.add.detail.add.field.price.title')"
              :placeholder="$t('product.add.detail.add.field.price.placeholder')"
              :alert="errors.price"
              style="margin-bottom: 8px !important;"
            ></badaso-text>
            <template v-if="$v.addProductDetail.$dirty">
              <span class="danger" v-if="$v.addProductDetail.price.$anyError">{{ $t('vuelidate.error') }}</span>
            </template>
          </vs-col>
          <vs-col vs-w="6" class="mb-3">
            <badaso-text
              v-model="addProductDetail.SKU"
              size="12"
              :label="$t('product.add.detail.add.field.SKU.title')"
              :placeholder="$t('product.add.detail.add.field.SKU.placeholder')"
              :alert="errors.SKU"
              style="margin-bottom: 8px !important;"
            ></badaso-text>
            <template v-if="$v.addProductDetail.$dirty">
              <span class="danger" v-if="$v.addProductDetail.SKU.$anyError">{{ $t('vuelidate.error') }}</span>
            </template>
          </vs-col>
          <badaso-select
            v-model="addProductDetail.discountId"
            size="6"
            :label="$t('product.add.detail.add.field.discount.title')"
            :placeholder="$t('product.add.detail.add.field.discount.placeholder')"
            :alert="errors.discountId"
            :items="discounts"
          ></badaso-select>
          <vs-col vs-w="6" class="mb-3">
            <badaso-upload-image
              v-model="addProductDetail.productImage"
              size="12"
              :label="$t('product.add.detail.add.field.productImage.title')"
              :placeholder="$t('product.add.detail.add.field.productImage.placeholder')"
              :alert="errors.productImage"
              style="margin-bottom: 8px !important;"
            ></badaso-upload-image>
            <template v-if="$v.addProductDetail.$dirty">
              <span class="danger" v-if="$v.addProductDetail.productImage.$anyError">{{ $t('vuelidate.error') }}</span>
            </template>
          </vs-col>
          <vs-col vs-w="12" vs-type="flex" vs-justify="flex-end">
            <vs-button type="relief" color="primary" class="ml-2" @click="addProductDetailToProduct">
              {{ $t('product.add.detail.add.button.save') }}
            </vs-button>
          </vs-col>
        </vs-row>
      </vs-popup>

      <vs-popup :title="$t('product.add.detail.edit.title')" :active.sync="editProductDetailDialog">
        <vs-row>
          <vs-col vs-w="6" class="mb-3">
            <badaso-text
              v-model="editProductDetail.name"
              size="12"
              :label="$t('product.add.detail.edit.field.name.title')"
              :placeholder="$t('product.add.detail.edit.field.name.placeholder')"
              :alert="errors.name"
              style="margin-bottom: 8px !important;"
            ></badaso-text>
            <template v-if="$v.editProductDetail.$dirty">
              <span class="danger" v-if="$v.editProductDetail.name.$anyError">{{ $t('vuelidate.error') }}</span>
            </template>
          </vs-col>
          <vs-col vs-w="6" class="mb-3">
            <badaso-text
              v-model="editProductDetail.quantity"
              size="12"
              :label="$t('product.add.detail.edit.field.quantity.title')"
              :placeholder="$t('product.add.detail.edit.field.quantity.placeholder')"
              :alert="errors.quantity"
              style="margin-bottom: 8px !important;"
            ></badaso-text>
            <template v-if="$v.editProductDetail.$dirty">
              <span class="danger" v-if="$v.editProductDetail.quantity.$anyError">{{ $t('vuelidate.error') }}</span>
            </template>
          </vs-col>
          <vs-col vs-w="6" class="mb-3">
            <badaso-text
              v-model="editProductDetail.price"
              size="12"
              :label="$t('product.add.detail.edit.field.price.title')"
              :placeholder="$t('product.add.detail.edit.field.price.placeholder')"
              :alert="errors.price"
              style="margin-bottom: 8px !important;"
            ></badaso-text>
            <template v-if="$v.editProductDetail.$dirty">
              <span class="danger" v-if="$v.editProductDetail.price.$anyError">{{ $t('vuelidate.error') }}</span>
            </template>
          </vs-col>
          <vs-col vs-w="6" class="mb-3">
            <badaso-text
              v-model="editProductDetail.SKU"
              size="12"
              :label="$t('product.add.detail.edit.field.SKU.title')"
              :placeholder="$t('product.add.detail.edit.field.SKU.placeholder')"
              :alert="errors.SKU"
              style="margin-bottom: 8px !important;"
            ></badaso-text>
            <template v-if="$v.editProductDetail.$dirty">
              <span class="danger" v-if="$v.editProductDetail.SKU.$anyError">{{ $t('vuelidate.error') }}</span>
            </template>
          </vs-col>
          <badaso-select
            v-model="editProductDetail.discountId"
            size="6"
            :label="$t('product.add.detail.edit.field.discount.title')"
            :placeholder="$t('product.add.detail.edit.field.discount.placeholder')"
            :alert="errors.discountId"
            :items="discounts"
          ></badaso-select>
          <vs-col vs-w="6" class="mb-3">
            <badaso-upload-image
              v-model="editProductDetail.productImage"
              size="12"
              :label="$t('product.add.detail.edit.field.productImage.title')"
              :placeholder="$t('product.add.detail.edit.field.productImage.placeholder')"
              :alert="errors.productImage"
              style="margin-bottom: 8px !important;"
            ></badaso-upload-image>
            <template v-if="$v.editProductDetail.$dirty">
              <span class="danger" v-if="$v.editProductDetail.productImage.$anyError">{{ $t('vuelidate.error') }}</span>
            </template>
          </vs-col>
          <vs-col vs-w="12" vs-type="flex" vs-justify="flex-end">
            <vs-button type="relief" color="primary" class="ml-2" @click="editProductDetailToProduct">
              {{ $t('product.add.detail.edit.button.save') }}
            </vs-button>
          </vs-col>
        </vs-row>
      </vs-popup>
    </vs-row>
  </div>
</template>

<script>
import { required, minValue, maxValue, integer } from "vuelidate/lib/validators";
import currency from "currency.js"
export default {
  name: "ProductAdd",
  components: {},
  data: () => ({
    errors: {},
    product: {
      productCategoryId: "",
      name: "",
      slug: "",
      productImage: "",
      desc: "",
    },
    addProductDetail: {
      discountId: '',
      name: '',
      quantity: '0',
      price: '0',
      SKU: null,
      productImage: ''
    },
    editProductDetail: {
      discountId: '',
      name: '',
      quantity: '0',
      price: '0',
      SKU: null,
      productImage: ''
    },
    categories: [],
    discounts: [],
    items: [],
    productDetailDialog: false,
    editProductDetailDialog: false,
    deleteProductDetailDialog: false,
    willEditId: null,
    willDeleteId: null,
  }),
  validations() {
    return {
      product: {
        productCategoryId: {
          required
        },
        name: {
          required
        },
        slug: {
          required
        },
        productImage: {
          required
        },
      },
      editProductDetail: {
        name: {
          required,
        },
        quantity: {
          required,
          minValue: minValue(0),
          integer
        },
        price: {
          required,
          minValue: minValue(0),
          integer
        },
        SKU: {
          required
        },
        productImage: {
          required
        }
      },
      addProductDetail: {
        name: {
          required,
        },
        quantity: {
          required,
          minValue: minValue(0),
          integer
        },
        price: {
          required,
          minValue: minValue(0),
          integer
        },
        SKU: {
          required
        },
        productImage: {
          required
        }
      }
    };
  },
  watch: {
    'product.name': {
      handler(val) {
        this.product.slug = this.$helper.generateSlug(val)
      }
    }
  },
  mounted() {
    this.getProductCategoryList()
    this.getProductDiscounts()
  },
  methods: {
    toCurrency(value) {
      return currency(value, {
        precision: this.$store.state.badaso.config.currencyPrecision,
        decimal: this.$store.state.badaso.config.currencyDecimal,
        separator: this.$store.state.badaso.config.currencySeparator,
        symbol: this.$store.state.badaso.config.currencySymbol,
      }).format()
    },
    getProductCategoryList() {
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
    getProductDiscounts() {
      this.$openLoader();
      this.$api.badasoDiscount
      .browse()
      .then((response) => {
        this.$closeLoader();
        this.discounts = response.data.discounts.map((discount, index) => {
          return {
            label: `${discount.name} - ${discount.discountType === 'fixed' ? this.toCurrency(discount.discountFixed) : discount.discountPercent + '%' }`,
            value: discount.id
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
    openAddProductDetail() {
      this.productDetailDialog = true
      this.clearSelection()
    },
    submitForm() {
      this.errors = {};
      this.$v.product.$touch()

      if (!this.$v.product.$invalid) {
        this.$v.product.$reset()
        try {
          this.$openLoader();
          this.$api.badasoProduct
            .add({ ...this.product, items: this.items })
            .then((response) => {
              this.$closeLoader();
              this.$router.push({ name: "ProductBrowse" });
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
      }
    },
    addProductDetailToProduct() {
      this.$v.addProductDetail.$touch()

      if (!this.$v.addProductDetail.$invalid) {
        this.items.push({ ...this.addProductDetail })
        this.productDetailDialog = false
      }
    },
    editProductDetailToProduct() {
      this.$v.editProductDetail.$touch()

      if (!this.$v.editProductDetail.$invalid) {
        this.$v.editProductDetail.$reset()
        this.$set(this.items, this.willEditId, this.editProductDetail)
        this.editProductDetailDialog = false
      }
    },
    clearSelection() {
      this.$v.addProductDetail.$reset()
      this.addProductDetail.discountId = ''
      this.addProductDetail.name = ''
      this.addProductDetail.quantity = ''
      this.addProductDetail.price = ''
      this.addProductDetail.SKU = null
      this.addProductDetail.productImage = ''
    },
    openEditDialog(item, index) {
      this.editProductDetailDialog = true
      this.editProductDetail = { ...item }
      this.willEditId = index
    },
    openDeleteDialog(index) {
      this.items.splice(index, 1)
    },
    getDiscountName(discountId) {
      if (!discountId || discountId === '') return ''

      var discount = this.discounts.find(discount => discount.value === discountId)
      if (!discount) return ''
      return discount.label
    }
  },
};
</script>

<style lang="scss">
.product-detail {
  &__button {
    &--add {
      & > span {
        display: flex;
        justify-content: center;
        align-items: center;
      }
    }
  }
}

.danger {
  color: rgba(var(--vs-danger), 1);
  display: inline-block;
}
</style>