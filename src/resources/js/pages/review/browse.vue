<template>
  <div>
    <badaso-breadcrumb-row />
    <vs-row v-if="$helper.isAllowed('browse_product_reviews')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("productReview.browse.title") }}</h3>
          </div>
          <div>
            <badaso-server-side-table
              v-model="selected"
              :data="productReview.data"
              stripe
              :pagination-data="productReview"
              :description-items="descriptionItems"
              :description-title="$t('productReview.browse.footer.descriptionTitle')"
              :description-connector="$t('productReview.browse.footer.descriptionConnector')"
              :description-body="$t('productReview.browse.footer.descriptionBody')"
              @search="handleSearch"
              @changePage="handleChangePage"
              @changeLimit="handleChangeLimit"
              @select="handleSelect"
              @sort="handleSort"
            >
              <template slot="thead">
                <badaso-th sort-key="name"> {{ $t("productReview.browse.header.name") }} </badaso-th>
                <badaso-th sort-key="orderDate"> {{ $t("productReview.browse.header.orderDate") }} </badaso-th>
                <badaso-th sort-key="email"> {{ $t("productReview.browse.header.email") }} </badaso-th>
                <badaso-th sort-key="rating"> {{ $t("productReview.browse.header.rating") }} </badaso-th>
                <badaso-th sort-key="createdAt"> {{ $t("productReview.browse.header.createdAt") }} </badaso-th>
                <vs-th> {{ $t("productReview.browse.header.action") }} </vs-th>
              </template>

              <template slot="tbody">
                <vs-tr :data="review" :key="index" v-for="(review, index) in productReview.data">
                  <vs-td :data="review.product.name">
                    {{ review.product.name }}
                  </vs-td>
                  <vs-td :data="review.orderDetail.createdAt">
                    {{ getDate(review.orderDetail.createdAt) }}
                  </vs-td>
                  <vs-td :data="review.user.email">
                    {{ review.user.email }}
                  </vs-td>
                  <vs-td :data="review.rating">
                    {{ review.rating }}
                  </vs-td>
                  <vs-td :data="review.createdAt">
                    {{ getDate(review.createdAt) }}
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
                          :to="{ name: 'ProductReviewRead', params: { id: review.id } }"
                          v-if="$helper.isAllowed('read_product_reviews')"
                        >
                          Read
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="delete"
                          @click="confirmDelete(review.id)"
                          v-if="$helper.isAllowed('delete_product_reviews')"
                        >
                          Delete
                        </badaso-dropdown-item>
                      </vs-dropdown-menu>
                    </badaso-dropdown>
                  </vs-td>
                </vs-tr>
              </template>
            </badaso-server-side-table>
          </div>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
import moment from 'moment'
export default {
  name: "ProductReviewBrowse",
  data() {
    return {
      selected: [],
      productReview: {
        data: []
      },
      descriptionItems: [10, 50, 100],
      totalItem: 0,
      filter: "",
      page: 1,
      limit: 10,
      orderField: "updatedAt",
      orderDirection: "desc",
      willDeleteId: null
    }
  },
  mounted() {
    this.getProductReviewList()
  },
  methods: {
    confirmDelete(id) {
      this.willDeleteId = id;
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("action.delete.title"),
        text: this.$t("action.delete.text"),
        accept: this.deleteProducts,
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {
          this.willDeleteId = null;
        },
      });
    },
    deleteProducts() {
      this.$openLoader();
      this.$api.badasoReview
      .delete({ id: this.willDeleteId })
      .then((response) => {
        this.$closeLoader();
        this.getProductReviewList();
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
    getDate(date) {
      return moment(date).format('DD MMMM YYYY HH:mm:ss')
    },
    getProductReviewList() {
      this.$openLoader();
      this.$api.badasoReview
      .browse({
        page: this.page,
        limit: this.limit,
      })
      .then((response) => {
        this.$closeLoader();
        this.selected = [];
        this.productReview = response.data.reviews;
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
    handleSearch(e) {
      this.filter = e.target.value;
      this.page = 1;
      this.getProductReviewList();
    },
    handleChangePage(page) {
      this.page = page;
      this.getProductReviewList();
    },
    handleChangeLimit(limit) {
      this.page = 1;
      this.limit = limit;
      this.getProductReviewList();
    },
    handleSort(field, direction) {
      this.orderField = field;
      this.orderDirection = direction;
      this.getProductReviewList();
    },
    handleSelect(data) {
      this.selected = data;
    },
  },
};
</script>
