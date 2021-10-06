<template>
  <div>
    <badaso-breadcrumb-row>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('browse_carts')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("cart.browse.title") }}</h3>
          </div>
          <div>
            <badaso-server-side-table
              v-model="selected"
              :data="carts.data"
              stripe
              :pagination-data="carts"
              :description-items="descriptionItems"
              :description-title="$t('cart.browse.footer.descriptionTitle')"
              :description-connector="$t('cart.browse.footer.descriptionConnector')"
              :description-body="$t('cart.browse.footer.descriptionBody')"
              @search="handleSearch"
              @changePage="handleChangePage"
              @changeLimit="handleChangeLimit"
              @select="handleSelect"
              @sort="handleSort"
            >
              <template slot="thead">
                <badaso-th sort-key="id"> {{ $t("cart.browse.header.id") }} </badaso-th>
                <badaso-th sort-key="name"> {{ $t("cart.browse.header.name") }} </badaso-th>
                <badaso-th sort-key="productName"> {{ $t("cart.browse.header.productName") }} </badaso-th>
                <badaso-th sort-key="quantity"> {{ $t("cart.browse.header.quantity") }} </badaso-th>
                <badaso-th sort-key="createdAt"> {{ $t("cart.browse.header.createdAt") }} </badaso-th>
                <badaso-th sort-key="updatedAt"> {{ $t("cart.browse.header.updatedAt") }} </badaso-th>
                <vs-th> {{ $t("cart.browse.header.action") }} </vs-th>
              </template>

              <template slot="tbody">
                <vs-tr :data="cart" :key="index" v-for="(cart, index) in carts.data">
                  <vs-td :data="cart.id">
                    {{cart.id }}
                  </vs-td>
                  <vs-td :data="cart.user.name">
                    {{ `${cart.user.name} - ${cart.user.email}` }}
                  </vs-td>
                  <vs-td :data="cart.productDetail.product.name">
                    {{ `${cart.productDetail.product.name} - ${cart.productDetail.name}` }}
                  </vs-td>
                  <vs-td :data="cart.quantity">
                    {{ cart.quantity }}
                  </vs-td>
                  <vs-td :data="cart.createdAt">
                    {{ getDate(cart.createdAt) }}
                  </vs-td>
                  <vs-td :data="cart.updatedAt">
                    {{ getDate(cart.updatedAt) }}
                  </vs-td>
                  <vs-td class="badaso-table__td">
                    <badaso-dropdown vs-trigger-click>
                      <vs-button
                        size="large"
                        type="flat"
                        icon="more_vert"
                      ></vs-button>
                      <vs-dropdown-menu>
                        <badaso-dropdown-item
                          icon="visibility"
                          :to="{
                            name: 'CartRead',
                            params: { id: cart.id },
                          }"
                          v-if="$helper.isAllowed('read_carts')"
                        >
                          Detail
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
  name: "CartBrowse",
  components: {},
  data() {
    return {
      selected: [],
      carts: {
        data: []
      },
      descriptionItems: [10, 50, 100],
      totalItem: 0,
      filter: "",
      page: 1,
      limit: 10,
      orderField: "updated_at",
      orderDirection: "desc",
    }
  },
  mounted() {
    this.getCartList()
  },
  methods: {
    getDate(date) {
      return moment(date).format('DD MMMM YYYY')
    },
    getCartList() {
      this.$openLoader();
      this.$api.badasoCart
      .browse({ limit: this.limit, page: this.page, relation: ['productDetail.product', 'user'] })
      .then((response) => {
        this.$closeLoader();
        this.selected = [];
        this.carts = response.data.carts;
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
      this.getCartList();
    },
    handleChangePage(page) {
      this.page = page;
      this.getCartList();
    },
    handleChangeLimit(limit) {
      this.page = 1;
      this.limit = limit;
      this.getCartList();
    },
    handleSort(field, direction) {
      this.orderField = field;
      this.orderDirection = direction;
      this.getCartList();
    },
    handleSelect(data) {
      this.selected = data;
    },
  },
};
</script>
