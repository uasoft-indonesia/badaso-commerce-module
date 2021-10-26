import Pages from "./../pages/index.vue";

let prefix = process.env.MIX_ADMIN_PANEL_ROUTE_PREFIX
  ? "/" + process.env.MIX_ADMIN_PANEL_ROUTE_PREFIX
  : "/badaso-dashboard";

export default [
  {
    path: prefix + "/product",
    name: "ProductBrowse",
    component: Pages,
    meta: {
      title: "Browse Product",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/product/bin",
    name: "ProductBrowseBin",
    component: Pages,
    meta: {
      title: "Browse Product Bin",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/product/:id/detail",
    name: "ProductRead",
    component: Pages,
    meta: {
      title: "Detail Product",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/product/:id/edit",
    name: "ProductEdit",
    component: Pages,
    meta: {
      title: "Edit Product",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/product/add",
    name: "ProductAdd",
    component: Pages,
    meta: {
      title: "Add Product",
      useComponent: "AdminContainer"
    },
  },

  {
    path: prefix + "/product-category",
    name: "ProductCategoryBrowse",
    component: Pages,
    meta: {
      title: "Browse Product Category",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/product-category/bin",
    name: "ProductCategoryBrowseBin",
    component: Pages,
    meta: {
      title: "Browse Product Category Bin",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/product-category/:id/detail",
    name: "ProductCategoryRead",
    component: Pages,
    meta: {
      title: "Detail Product Category",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/product-category/:id/edit",
    name: "ProductCategoryEdit",
    component: Pages,
    meta: {
      title: "Edit Product Category",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/product-category/add",
    name: "ProductCategoryAdd",
    component: Pages,
    meta: {
      title: "Add Product Category",
      useComponent: "AdminContainer"
    },
  },

  {
    path: prefix + "/discount",
    name: "DiscountBrowse",
    component: Pages,
    meta: {
      title: "Browse Discount",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/discount/bin",
    name: "DiscountBrowseBin",
    component: Pages,
    meta: {
      title: "Browse Discount Bin",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/discount/:id/detail",
    name: "DiscountRead",
    component: Pages,
    meta: {
      title: "Detail Discount",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/discount/:id/edit",
    name: "DiscountEdit",
    component: Pages,
    meta: {
      title: "Edit Discount",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/discount/add",
    name: "DiscountAdd",
    component: Pages,
    meta: {
      title: "Add Discount",
      useComponent: "AdminContainer"
    },
  },

  {
    path: prefix + "/payment",
    name: "PaymentBrowse",
    component: Pages,
    meta: {
      title: "Browse Payment",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/payment/:id/detail",
    name: "PaymentRead",
    component: Pages,
    meta: {
      title: "Detail Payment",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/payment/:id/edit",
    name: "PaymentEdit",
    component: Pages,
    meta: {
      title: "Edit Payment",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/payment/add",
    name: "PaymentAdd",
    component: Pages,
    meta: {
      title: "Add Payment",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/payment/:id/option",
    name: "PaymentOption",
    component: Pages,
    meta: {
      title: "Edit Payment Option",
      useComponent: "AdminContainer"
    },
  },

  {
    path: prefix + "/order",
    name: "OrderBrowse",
    component: Pages,
    meta: {
      title: "Browse Order",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/order/:id/confirm",
    name: "OrderConfirm",
    component: Pages,
    meta: {
      title: "Confirm Order",
      useComponent: "AdminContainer"
    },
  },

  {
    path: prefix + "/cart",
    name: "CartBrowse",
    component: Pages,
    meta: {
      title: "Browse Cart",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/cart/:id/detail",
    name: "CartRead",
    component: Pages,
    meta: {
      title: "Detail Cart",
      useComponent: "AdminContainer"
    },
  },

  {
    path: prefix + "/user-address",
    name: "UserAddressBrowse",
    component: Pages,
    meta: {
      title: "Browse User Address",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/user-address/:id/detail",
    name: "UserAddressRead",
    component: Pages,
    meta: {
      title: "Detail User Address",
      useComponent: "AdminContainer"
    },
  },

  {
    path: prefix + "/review",
    name: "ProductReviewBrowse",
    component: Pages,
    meta: {
      title: "Browse Product Review",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/review/:id/detail",
    name: "ProductReviewRead",
    component: Pages,
    meta: {
      title: "Detail Product Review",
      useComponent: "AdminContainer"
    },
  },

  {
    path: prefix + "/commerce-config",
    name: "CommerceConfiguration",
    component: Pages,
    meta: {
      title: "Commerce Configuration",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/commerce-config/add",
    name: "CommerceConfigurationAdd",
    component: Pages,
    meta: {
      title: "Add Commerce Configuration",
      useComponent: "AdminContainer"
    },
  },
];
