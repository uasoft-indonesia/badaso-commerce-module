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
    path: prefix + "/order",
    name: "OrderBrowse",
    component: Pages,
    meta: {
      title: "Browse Order",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/order/:id/detail",
    name: "OrderRead",
    component: Pages,
    meta: {
      title: "Read Order",
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
    path: prefix + "/payment-provider",
    name: "PaymentProviderBrowse",
    component: Pages,
    meta: {
      title: "Browse Payment Provider",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/payment-provider/:id/detail",
    name: "PaymentProviderRead",
    component: Pages,
    meta: {
      title: "Detail Payment Provider",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/payment-provider/:id/edit",
    name: "PaymentProviderEdit",
    component: Pages,
    meta: {
      title: "Edit Payment Provider",
      useComponent: "AdminContainer"
    },
  },
  {
    path: prefix + "/payment-provider/add",
    name: "PaymentProviderAdd",
    component: Pages,
    meta: {
      title: "Add Payment Provider",
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
    path: prefix + "/commerce-config",
    name: "CommerceConfiguration",
    component: Pages,
    meta: {
      title: "Commerce Configuration",
      useComponent: "AdminContainer"
    },
  },
];
