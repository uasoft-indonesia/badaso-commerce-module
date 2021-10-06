<template>
  <div>
    <badaso-breadcrumb-row>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('browse_user_addresses')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("userAddress.browse.title") }}</h3>
          </div>
          <div>
            <badaso-server-side-table
              v-model="selected"
              :data="userAddresses.data"
              stripe
              :pagination-data="userAddresses"
              :description-items="descriptionItems"
              :description-title="$t('userAddress.browse.footer.descriptionTitle')"
              :description-connector="$t('userAddress.browse.footer.descriptionConnector')"
              :description-body="$t('userAddress.browse.footer.descriptionBody')"
              @search="handleSearch"
              @changePage="handleChangePage"
              @changeLimit="handleChangeLimit"
              @select="handleSelect"
              @sort="handleSort"
            >
              <template slot="thead">
                <badaso-th sort-key="name"> {{ $t("userAddress.browse.header.name") }} </badaso-th>
                <badaso-th sort-key="email"> {{ $t("userAddress.browse.header.email") }} </badaso-th>
                <badaso-th sort-key="address1"> {{ $t("userAddress.browse.header.address1") }} </badaso-th>
                <badaso-th sort-key="address2"> {{ $t("userAddress.browse.header.address2") }} </badaso-th>
                <badaso-th sort-key="createdAt"> {{ $t("userAddress.browse.header.createdAt") }} </badaso-th>
                <badaso-th sort-key="updatedAt"> {{ $t("userAddress.browse.header.updatedAt") }} </badaso-th>
                <vs-th> {{ $t("userAddress.browse.header.action") }} </vs-th>
              </template>

              <template slot="tbody">
                <vs-tr :data="userAddress" :key="index" v-for="(userAddress, index) in userAddresses.data">
                  <vs-td :data="userAddress.user.name">
                    {{ userAddress.user.name }}
                  </vs-td>
                  <vs-td :data="userAddress.user.email">
                    {{ userAddress.user.email }}
                  </vs-td>
                  <vs-td :data="userAddress.addressLine1">
                    {{ userAddress.addressLine1 }}
                  </vs-td>
                  <vs-td :data="userAddress.addressLine2">
                    {{ userAddress.addressLine2 }}
                  </vs-td>
                  <vs-td :data="userAddress.createdAt">
                    {{ getDate(userAddress.createdAt) }}
                  </vs-td>
                  <vs-td :data="userAddress.updatedAt">
                    {{ getDate(userAddress.updatedAt) }}
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
                            name: 'UserAddressRead',
                            params: { id: userAddress.id },
                          }"
                          v-if="$helper.isAllowed('read_user_addresses')"
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
  name: "UserAddressBrowse",
  components: {},
  data() {
    return {
      selected: [],
      userAddresses: {
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
    this.getUserAddressList()
  },
  methods: {
    getDate(date) {
      return moment(date).format('DD MMMM YYYY')
    },
    getUserAddressList() {
      this.$openLoader();
      this.$api.badasoUserAddress
      .browse({ limit: this.limit, page: this.page, relation: ['user'] })
      .then((response) => {
        this.$closeLoader();
        this.selected = [];
        this.userAddresses = response.data.userAddresses;
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
