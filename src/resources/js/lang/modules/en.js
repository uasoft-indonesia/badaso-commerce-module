export const label = "English";

export default {
  vuelidate: {
    error: "This field is invalid",
  },
  action: {
    bin: "Recycle Bin",
    bulkRestore: "Bulk Restore",
    bulkDeletePermanent: "Bulk Delete Permanent",
    restore: {
      title: "Restore Item",
      text: "Are you sure want to restore this item?",
      accept: "Restore",
      cancel: "Cancel",
    },
  },
  product: {
    browse: {
      title: "Product",
      header: {
        name: "Product Name",
        slug: "Slug",
        productCategoryId: "Category",
        productImage: "Product Image",
        createdAt: "Created At",
        updatedAt: "Updated At",
        action: "Action",
      },
      footer: {
        descriptionTitle: "Registries",
        descriptionConnector: "of",
        descriptionBody: "Pages",
      },
    },
    browseBin: {
      title: "Product Bin",
      header: {
        name: "Product Name",
        slug: "Slug",
        productCategoryId: "Category",
        productImage: "Product Image",
        deletedAt: "Deleted At",
        action: "Action",
      },
      footer: {
        descriptionTitle: "Registries",
        descriptionConnector: "of",
        descriptionBody: "Pages",
      },
    },
    add: {
      title: "Add Product",
      field: {
        name: {
          title: "Product Name",
          placeholder: "Product Name",
        },
        slug: {
          title: "Slug",
          placeholder: "Slug",
        },
        productCategoryId: {
          title: "Product Category",
          placeholder: "Product Category",
        },
        productImage: {
          title: "Product Image",
          placeholder: "Product Image",
        },
        desc: {
          title: "Description",
          placeholder: "Description",
        },
      },
      header: {
        productImage: "Product Image",
        name: "Product Name",
        quantity: "Quantity",
        price: "Price",
        discount: "Discount",
        SKU: "SKU",
        action: "Action",
      },
      button: "Save",
      detail: {
        title: "Product Detail",
        add: {
          title: "Add Product Detail",
          field: {
            name: {
              title: "Product Detail Name",
              placeholder: "Product Detail Name",
            },
            quantity: {
              title: "Product Stock",
              placeholder: "Product Stock",
            },
            price: {
              title: "Product Price",
              placeholder: "Product Price",
            },
            SKU: {
              title: "Product Detail SKU",
              placeholder: "Product Detail SKU",
            },
            productImage: {
              title: "Product Detail Image",
              placeholder: "Product Detail Image",
            },
            discount: {
              title: "Discount",
              placeholder: "Discount",
            },
          },
          button: {
            save: "Save",
            cancel: "Cancel",
          },
        },
        edit: {
          title: "Edit Product Detail",
          field: {
            name: {
              title: "Product Detail Name",
              placeholder: "Product Detail Name",
            },
            quantity: {
              title: "Product Stock",
              placeholder: "Product Stock",
            },
            price: {
              title: "Product Price",
              placeholder: "Product Price",
            },
            SKU: {
              title: "Product Detail SKU",
              placeholder: "Product Detail SKU",
            },
            productImage: {
              title: "Product Detail Image",
              placeholder: "Product Detail Image",
            },
            discount: {
              title: "Discount",
              placeholder: "Discount",
            },
          },
          button: {
            save: "Save",
            cancel: "Cancel",
          },
        },
      },
    },
    detail: {
      title: "Detail Product",
      header: {
        name: "Product Name",
        slug: "Slug",
        desc: "Description",
        productCategory: "Product Category",
        productImage: "Product Image",
        createdAt: "Created At",
        updatedAt: "Updated At",
        deletedAt: "Deleted At",
      },
    },
  },
  productCategories: {
    browse: {
      title: "Product Categories",
      header: {
        name: "Category Name",
        slug: "Slug",
        children: "Children",
        desc: "Description",
        SKU: "SKU",
        createdAt: "Created At",
        updatedAt: "Updated At",
        action: "Action",
      },
      footer: {
        descriptionTitle: "Registries",
        descriptionConnector: "of",
        descriptionBody: "Pages",
      },
    },
    browseBin: {
      title: "Recycle Bin for Product Categories",
      header: {
        name: "Category Name",
        slug: "Slug",
        children: "Children",
        desc: "Description",
        SKU: "SKU",
        deletedAt: "Deleted At",
        action: "Action",
      },
      footer: {
        descriptionTitle: "Registries",
        descriptionConnector: "of",
        descriptionBody: "Pages",
      },
    },
    add: {
      title: "Add Product Category",
      field: {
        name: {
          title: "Category Name",
          placeholder: "Category Name",
        },
        slug: {
          title: "Slug",
          placeholder: "Slug",
        },
        desc: {
          title: "Description",
          placeholder: "Description",
        },
        parent: {
          title: "Parent Category",
          placeholder: "Parent Category",
        },
        SKU: {
          title: "Category SKU",
          placeholder: "Category SKU",
        },
        image: {
          title: "Image",
          placeholder: "Image",
        },
      },
      button: "Save",
    },
    edit: {
      title: "Edit Product Category",
      field: {
        name: {
          title: "Category Name",
          placeholder: "Category Name",
        },
        slug: {
          title: "Slug",
          placeholder: "Slug",
        },
        desc: {
          title: "Description",
          placeholder: "Description",
        },
        parent: {
          title: "Parent Category",
          placeholder: "Parent Category",
        },
        SKU: {
          title: "Category SKU",
          placeholder: "Category SKU",
        },
        image: {
          title: "Image",
          placeholder: "Image",
        },
      },
      button: "Save",
    },
    detail: {
      title: "Detail Product Category",
      header: {
        name: "Category Name",
        slug: "Slug",
        desc: "Description",
        SKU: "SKU",
        image: "Image",
        createdAt: "Created At",
        updatedAt: "Updated At",
        deletedAt: "Deleted At",
        action: "Action",
      },
    },
  },
  discounts: {
    discountType: {
      fixed: "Fixed",
      percent: "Percent",
    },
    help: {
      discountFixed:
        "Diskon Fixed is nominal of discount has setted. Type nominal discount without set delimiter",
      discountPercent:
        "Diskon Percent is nominal of discount setting by value among 1-100",
      percentType:
        "Diskon Fixed is nominal of discount has setted and type nominal discount without set delimiter. Diskon Percent is nominal of discount setting by value among 1-100",
    },

    browse: {
      title: "Product Discount",
      header: {
        name: "Discount Name",
        desc: "Description",
        discountType: "Discount Type",
        discountPercent: "Discount Percent",
        discountFixed: "Discount Fixed",
        active: "Active",
        createdAt: "Created At",
        updatedAt: "Updated At",
        action: "Action",
      },
      footer: {
        descriptionTitle: "Registries",
        descriptionConnector: "of",
        descriptionBody: "Pages",
      },
    },
    browseBin: {
      title: "Recycle Bin for Discounts",
      header: {
        name: "Discount Name",
        desc: "Description",
        discountType: "Discount Type",
        discountPercent: "Discount Percent",
        discountFixed: "Discount Fixed",
        active: "Active",
        deletedAt: "Deleted At",
        action: "Action",
      },
      footer: {
        descriptionTitle: "Registries",
        descriptionConnector: "of",
        descriptionBody: "Pages",
      },
    },
    add: {
      title: "Add Discount",
      field: {
        name: {
          title: "Discount Name",
          placeholder: "Discount Name",
        },
        desc: {
          title: "Description",
          placeholder: "Description",
        },
        discountType: {
          title: "Discount Type",
          placeholder: "Discount Type",
        },
        discountPercent: {
          title: "Percent",
          placeholder: "Percent",
        },
        discountFixed: {
          title: "Fixed",
          placeholder: "Fixed",
        },
        active: {
          title: "Active",
          placeholder: "Active",
        },
      },
      button: "Save",
    },
    edit: {
      title: "Edit Discount",
      field: {
        name: {
          title: "Discount Name",
          placeholder: "Discount Name",
        },
        desc: {
          title: "Description",
          placeholder: "Description",
        },
        discountType: {
          title: "Discount Type",
          placeholder: "Discount Type",
        },
        discountPercent: {
          title: "Percent",
          placeholder: "Percent",
        },
        discountFixed: {
          title: "Fixed",
          placeholder: "Fixed",
        },
        active: {
          title: "Active",
          placeholder: "Active",
        },
      },
      button: "Save",
    },
    detail: {
      title: "Detail Discount",
      header: {
        name: "Discount Name",
        desc: "Description",
        discountType: "Discount Type",
        discountPercent: "Discount Percent",
        discountFixed: "Discount Fixed",
        active: "Active",
        createdAt: "Created At",
        updatedAt: "Updated At",
        deletedAt: "Deleted At",
        action: "Action",
      },
    },
  },
  orders: {
    status: {
      "-1": "Failed",
      0: "Waiting Payment",
      1: "Waiting Confirmation",
      2: "Processing",
      3: "Shipping",
      4: "Received",
    },
    browse: {
      title: "Orders",
      header: {
        orderId: "Order ID",
        user: "User",
        discounted: "Discounted",
        total: "Total",
        payed: "Payed",
        status: "Status",
        orderedAt: "Order At",
        action: "Action",
      },
      footer: {
        descriptionTitle: "Registries",
        descriptionConnector: "of",
        descriptionBody: "Pages",
      },
    },
    confirm: {
      title: {
        customerInfo: "Customer Info",
        orderInfo: "Order Info",
        trackingNumber: "Set Tracking Number",
        orderPayment: "Order Payment",
        cancel: "Cancel",
      },
      header: {
        recipientName: "Recipient Name",
        user: {
          email: "Email",
        },
        addressLine1: "Address Line 1",
        addressLine2: "Address Line 2",
        city: "City",
        postalCode: "Postal Code",
        country: "Country",
        phoneNumber: "Phone Number",
        total: "Total Order",
        status: "Status Order",
        discounted: "Discounted",
        payed: "Must Pay",
        proof: "Proof of Transaction",
        cancelMessage: "Cancel Message",
        shippingCost: "Shipping Cost",
        trackingNumber: "Tracking Number",
        expiredAt: "Expired At",
        action: "Action",
        orderPayment: {
          sourceBank: "Source Bank",
          destinationBank: "Destination Bank",
          accountNumber: "Account Number",
          totalTransfer: "Total Transfered",
          proofOfTransaction: "Proof of Transaction",
        },
      },
      field: {
        trackingNumber: {
          label: "Tracking Number",
          placeholder: "Tracking Number",
        },
        cancel: {
          label: "Cancel Message",
          placeholder: "Cancel Message",
        },
      },
      button: {
        save: "Save",
      },
    },
  },
  cart: {
    browse: {
      title: "User Cart",
      header: {
        id: "ID",
        name: "User Name & Email",
        productName: "Product Name",
        quantity: "Quantity",
        createdAt: "Created At",
        updatedAt: "Updated At",
        action: "Action",
      },
      footer: {
        descriptionTitle: "Registries",
        descriptionConnector: "of",
        descriptionBody: "Pages",
      },
    },
    detail: {
      title: "User Cart Detail",
      header: {
        id: "ID",
        name: "User Name",
        productName: "Product Name",
        quantity: "Quantity",
        createdAt: "Created At",
        updatedAt: "Updated At",
        action: "Action",
      },
    },
  },
  userAddress: {
    browse: {
      title: "User Addresses",
      header: {
        name: "User Name",
        email: "Email",
        address1: "Address 1",
        address2: "Address 2",
        createdAt: "Created At",
        updatedAt: "Updated At",
        action: "Action",
      },
      footer: {
        descriptionTitle: "Registries",
        descriptionConnector: "of",
        descriptionBody: "Pages",
      },
    },
    detail: {
      title: "User Addresses Detail",
      header: {
        name: "User Name",
        email: "Email",
        address1: "Address 1",
        address2: "Address 2",
        city: "City",
        postalCode: "Postal Code",
        country: "Country",
        phoneNumber: "Phone Number",
        createdAt: "Created At",
        updatedAt: "Updated At",
        action: "Action",
      },
    },
  },
  commerceSite: {
    action: "Action",
    deletedImage: {
      title: "Deleted Image",
      text: "The selected image was successfully deleted",
    },
    configUpdated: "Config Updated",
    add: {
      title: "Add Commerce Configuration",
      field: {
        displayName: {
          title: "Display Name",
          placeholder: "Example: Display Name",
        },
        key: {
          title: "Key",
          placeholder: "Example: key_sample",
        },
        type: {
          title: "Type",
          placeholder: "Type",
        },
        group: {
          title: "Group",
          placeholder: "Group",
        },
        options: {
          title: "Options",
          description:
            "Options is required for Checkbox, Radio, Select, Select-multiple. Example: ",
          example: `{"items": [{"label":"This is label","value":"this_is_value"}] }`,
        },
      },
      button: "Save",
    },
    edit: {
      multiple: "Update Configurations",
    },
  },
  productReview: {
    browse: {
      title: "Product Review",
      header: {
        name: "Product Name",
        orderDate: "Order Date",
        email: "Email",
        rating: "Rating",
        createdAt: "Created At",
        updatedAt: "Updated At",
        action: "Action",
      },
      footer: {
        descriptionTitle: "Registries",
        descriptionConnector: "of",
        descriptionBody: "Pages",
      },
    },
    detail: {
      title: "Detail Product Review",
      header: {
        name: "Product Name",
        orderDate: "Order Date",
        email: "Email",
        rating: "Rating",
        review: "Review",
        media: "Media",
        createdAt: "Created At",
        updatedAt: "Updated At",
        action: "Action",
      },
    },
  },
  payments: {
    browse: {
      title: "Payments",
      header: {
        name: "Name",
        slug: "Slug",
        isActive: "Active",
        action: "Action",
      },
      footer: {
        descriptionTitle: "Registries",
        descriptionConnector: "of",
        descriptionBody: "Pages",
      },
    },
    add: {
      title: "Add Payment",
      field: {
        name: {
          title: "Name",
          placeholder: "Name",
        },
        slug: {
          title: "Slug",
          placeholder: "Slug",
        },
        isActive: {
          title: "Active",
          placeholder: "Active",
        },
      },
      button: "Save",
    },
    edit: {
      title: "Edit Payment",
      field: {
        name: {
          title: "Name",
          placeholder: "Name",
        },
        slug: {
          title: "Slug",
          placeholder: "Slug",
        },
        isActive: {
          title: "Active",
          placeholder: "Active",
        },
      },
      button: "Save",
    },
    detail: {
      title: "Detail Discount",
      header: {
        name: "Discount Name",
        desc: "Description",
        discountType: "Discount Type",
        discountPercent: "Discount Percent",
        discountFixed: "Discount Fixed",
        active: "Active",
        createdAt: "Created At",
        updatedAt: "Updated At",
        deletedAt: "Deleted At",
        action: "Action",
      },
    },
    option: {
      title: "Payment Option",
      popup: {
        add: {
          title: "Add Payment Option",
          field: {
            name: "Name",
            slug: "Slug",
            description: "Description",
            image: "Image",
            isActive: "Active",
            order: "order",
          },
          button: {
            cancel: "Cancel",
            add: "Add",
          },
        },
        edit: {
          title: "Edit Payment Option",
          field: {
            name: "Name",
            slug: "Slug",
            description: "Description",
            image: "Image",
            isActive: "Active",
            order: "order",
          },
          button: {
            cancel: "Cancel",
            edit: "Edit",
          },
        },
      },
    },
  },
};
