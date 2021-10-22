<template>
  <component
    v-if="globalComponentList[defaultComponent]"
    v-bind:is="globalComponentList[defaultComponent]"
  ></component>
  <component v-else v-bind:is="defaultComponent"></component>
</template>

<script>
import ProductBrowse from "./product/browse";
import ProductBrowseBin from "./product/browse-bin";
import ProductAdd from "./product/add";
import ProductRead from "./product/read";
import ProductEdit from "./product/edit";

import ProductCategoryBrowse from "./product-category/browse";
import ProductCategoryBrowseBin from "./product-category/browse-bin";
import ProductCategoryAdd from "./product-category/add";
import ProductCategoryRead from "./product-category/read";
import ProductCategoryEdit from "./product-category/edit";

import DiscountBrowse from "./discount/browse";
import DiscountBrowseBin from "./discount/browse-bin";
import DiscountAdd from "./discount/add";
import DiscountRead from "./discount/read";
import DiscountEdit from "./discount/edit";

import PaymentBrowse from "./payment/browse";
import PaymentAdd from "./payment/add";
import PaymentRead from "./payment/read";
import PaymentEdit from "./payment/edit";
import PaymentOption from "./payment/option";

import OrderBrowse from "./order/browse";
import OrderConfirm from "./order/confirm";

import ProductReviewBrowse from "./review/browse";
import ProductReviewRead from "./review/read";

import CartBrowse from "./cart/browse";
import CartRead from "./cart/read";

import UserAddressBrowse from "./user-address/browse";
import UserAddressRead from "./user-address/read";

import CommerceConfiguration from "./site-management/browse";
import CommerceConfigurationAdd from "./site-management/add";

export default {
  components: {
    ProductBrowse,
    ProductBrowseBin,
    ProductAdd,
    ProductRead,
    ProductEdit,
    ProductCategoryBrowse,
    ProductCategoryBrowseBin,
    ProductCategoryAdd,
    ProductCategoryRead,
    ProductCategoryEdit,
    DiscountBrowse,
    DiscountBrowseBin,
    DiscountAdd,
    DiscountRead,
    DiscountEdit,
    PaymentBrowse,
    PaymentAdd,
    PaymentRead,
    PaymentEdit,
    PaymentOption,
    OrderBrowse,
    OrderConfirm,
    ProductReviewBrowse,
    ProductReviewRead,
    CartBrowse,
    CartRead,
    UserAddressBrowse,
    UserAddressRead,
    CommerceConfiguration,
    CommerceConfigurationAdd,
  },
  name: "BlogEntryIndex",
  data: () => ({
    globalComponentList: {},
    defaultComponent: null,
  }),
  mounted() {
    const routeName = this.$route.name;
    const componentName = this.$caseConvert.kebab(routeName);
    const slug = this.$route.params ? this.$route.params.slug : "";

    this.globalComponentList = this.constructor.superOptions.components;

    this.defaultComponent = componentName;
  },
  methods: {},
};
</script>
