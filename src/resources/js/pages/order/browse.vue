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
                <badaso-th sort-key="id"> # </badaso-th>
                <badaso-th sort-key="user"> {{ $t("orders.browse.header.user") }} </badaso-th>
                <badaso-th sort-key="provider"> {{ $t("orders.browse.header.provider") }} </badaso-th>
                <badaso-th sort-key="discounted"> {{ $t("orders.browse.header.discounted") }} </badaso-th>
                <badaso-th sort-key="total"> {{ $t("orders.browse.header.total") }} </badaso-th>
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
                  <vs-td :data="order.provider.name">
                    {{ order.provider.name }}
                  </vs-td>
                  <vs-td :data="order.discounted">
                    {{ order.discounted | toCurrency }}
                  </vs-td>
                  <vs-td :data="order.total">
                    {{ order.total | toCurrency }}
                  </vs-td>
                  <vs-td :data="order.payed">
                    {{ order.payed | toCurrency }}
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
                          icon="visibility"
                          :to="{ name: 'OrderRead', params: { id: order.id } }"
                          v-if="$helper.isAllowed('read_orders')"
                        >
                          Detail
                        </badaso-dropdown-item>
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
  filters: {
    toCurrency: function (value) {
      var formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
      });
      return formatter.format(value);
    }
  },
  mounted() {
    this.getOrderList()
  },
  methods: {
    getDate(date) {
      return moment(date).format('DD MMMM YYYY')
    },
    getOrderStatus(status) {
      switch (status) {
        case 0:
          return this.$t("orders.status.0")
        case 1:
          return this.$t("orders.status.1")
        case 2:
          return this.$t("orders.status.2")
        case 3:
          return this.$t("orders.status.3")
        case 4:
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
          'provider',
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
