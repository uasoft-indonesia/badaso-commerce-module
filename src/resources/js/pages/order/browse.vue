<template>
  <div>
    <badaso-breadcrumb-row />
    <vs-row v-if="$helper.isAllowed('browse_orders')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("orders.browse.title") }}</h3>
          </div>
          <div>
            <badaso-server-side-table
              v-model="selected"
              :data="orders.data"
              stripe
              :pagination-data="orders"
              :description-items="descriptionItems"
              :description-title="$t('orders.browse.footer.descriptionTitle')"
              :description-connector="$t('orders.browse.footer.descriptionConnector')"
              :description-body="$t('orders.browse.footer.descriptionBody')"
              @search="handleSearch"
              @changePage="handleChangePage"
              @changeLimit="handleChangeLimit"
              @select="handleSelect"
              @sort="handleSort"
            >
              <template slot="thead">
                <badaso-th sort-key="id"> {{ $t("orders.browse.header.orderId") }} </badaso-th>
                <badaso-th sort-key="user"> {{ $t("orders.browse.header.user") }} </badaso-th>
                <badaso-th sort-key="total"> {{ $t("orders.browse.header.total") }} </badaso-th>
                <badaso-th sort-key="discounted"> {{ $t("orders.browse.header.discounted") }} </badaso-th>
                <badaso-th sort-key="payed"> {{ $t("orders.browse.header.payed") }} </badaso-th>
                <badaso-th sort-key="status"> {{ $t("orders.browse.header.status") }} </badaso-th>
                <badaso-th sort-key="orderedAt"> {{ $t("orders.browse.header.orderedAt") }} </badaso-th>
                <vs-th> {{ $t("orders.browse.header.action") }} </vs-th>
              </template>

              <template slot="tbody">
                <vs-tr :data="order" :key="index" v-for="(order, index) in orders.data">
                  <vs-td :data="order.id">
                    {{ order.id }}
                  </vs-td>
                  <vs-td :data="order.user.name">
                    {{ order.user.name }}
                  </vs-td>
                  <vs-td :data="order.total">
                    {{ toCurrency(order.total) }}
                  </vs-td>
                  <vs-td :data="order.discounted">
                    {{ toCurrency(order.discounted) }}
                  </vs-td>
                  <vs-td :data="order.payed">
                    {{ toCurrency(order.payed) }}
                  </vs-td>
                  <vs-td :data="order.status">
                    {{ getOrderStatus(order.status) }}
                  </vs-td>
                  <vs-td :data="order.createdAt">
                    {{ getDate(order.createdAt) }}
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
                          icon="check"
                          :to="{ name: 'OrderConfirm', params: { id: order.id } }"
                          v-if="$helper.isAllowed('confirm_orders')"
                        >
                          Confirm
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
import currency from 'currency.js';
export default {
  name: "OrderBrowse",
  components: {},
  data() {
    return {
      selected: [],
      orders: {
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
    this.getOrderList()
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
    getDate(date) {
      return moment(date).format('DD MMMM YYYY HH:mm:ss')
    },
    getOrderStatus(status) {
      switch (status) {
        case 'waitingBuyerPayment':
          return this.$t("orders.status.0")
        case 'waitingSellerConfirmation':
          return this.$t("orders.status.1")
        case 'process':
          return this.$t("orders.status.2")
        case 'delivering':
          return this.$t("orders.status.3")
        case 'done':
          return this.$t("orders.status.4")
        default:
          return this.$t("orders.status.-1")
      }
    },
    getOrderList() {
      this.$openLoader();
      this.$api.badasoOrder
      .browse({
        page: this.page,
        limit: this.limit,
        relation: [
          'user',
        ]
      })
      .then((response) => {
        this.$closeLoader();
        this.selected = [];
        this.orders = response.data.orders;
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
      this.getPaymentProviderList();
    },
    handleChangePage(page) {
      this.page = page;
      this.getPaymentProviderList();
    },
    handleChangeLimit(limit) {
      this.page = 1;
      this.limit = limit;
      this.getPaymentProviderList();
    },
    handleSort(field, direction) {
      this.orderField = field;
      this.orderDirection = direction;
      this.getPaymentProviderList();
    },
    handleSelect(data) {
      this.selected = data;
    },
  },
};
</script>
