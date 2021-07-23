<template>
  <div>
    <badaso-breadcrumb-row>
      <template slot="action">
        <vs-button
          color="primary"
          type="relief"
          :to="{ name: 'DiscountAdd' }"
          v-if="$helper.isAllowed('add_discounts')"
          ><vs-icon icon="add"></vs-icon> {{ $t("action.add") }}</vs-button
        >
        <vs-button
          color="danger"
          type="relief"
          :to="{ name: 'DiscountBrowseBin' }"
          v-if="$helper.isAllowed('browse_discounts_bin')"
          ><vs-icon icon="delete"></vs-icon> {{ $t("action.bin") }}</vs-button
        >
        <vs-button
          color="danger"
          type="relief"
          v-if="selected.length > 0 && $helper.isAllowed('delete_discounts')"
          @click.stop
          @click="confirmDeleteMultiple"
          ><vs-icon icon="delete_sweep"></vs-icon>
          {{ $t("action.bulkDelete") }}</vs-button
        >
      </template>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('browse_discounts')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("discounts.browse.title") }}</h3>
          </div>
          <div>
            <badaso-table
              multiple
              v-model="selected"
              pagination
              max-items="10"
              search
              :data="discounts"
              stripe
              description
              :description-items="descriptionItems"
              :description-title="$t('discounts.browse.footer.descriptionTitle')"
              :description-connector="$t('discounts.browse.footer.descriptionConnector')"
              :description-body="$t('discounts.browse.footer.descriptionBody')"
            >
              <template slot="thead">
                <badaso-th sort-key="name"> {{ $t("discounts.browse.header.name") }} </badaso-th>
                <badaso-th sort-key="discountType"> {{ $t("discounts.browse.header.discountType") }} </badaso-th>
                <badaso-th sort-key="discountPercent"> {{ $t("discounts.browse.header.discountPercent") }} </badaso-th>
                <badaso-th sort-key="discountFixed"> {{ $t("discounts.browse.header.discountFixed") }} </badaso-th>
                <badaso-th sort-key="active"> {{ $t("discounts.browse.header.active") }} </badaso-th>
                <badaso-th sort-key="createdAt"> {{ $t("discounts.browse.header.createdAt") }} </badaso-th>
                <badaso-th sort-key="updatedAt"> {{ $t("discounts.browse.header.updatedAt") }} </badaso-th>
                <vs-th> {{ $t("discounts.browse.header.action") }} </vs-th>
              </template>

              <template slot-scope="{ data }">
                <vs-tr :data="discount" :key="index" v-for="(discount, index) in data">
                  <vs-td :data="discount.name">
                    {{ discount.name }}
                  </vs-td>
                  <vs-td :data="discount.discountType">
                    <span style="text-transform: capitalize;">
                      {{ discount.discountType }}
                    </span>
                  </vs-td>
                  <vs-td :data="discount.discountPercent">
                    {{ discount.discountPercent ? discount.discountPercent + '%' : 'None' }}
                  </vs-td>
                  <vs-td :data="discount.discountFixed">
                    {{ discount.discountFixed | toCurrency }}
                  </vs-td>
                  <vs-td :data="discount.active">
                    {{ discount.active === 1 ? 'Yes' : 'No' }}
                  </vs-td>
                  <vs-td :data="discount.createdAt">
                    {{ getDate(discount.createdAt) }}
                  </vs-td>
                  <vs-td :data="discount.updatedAt">
                    {{ getDate(discount.updatedAt) }}
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
                          :to="{ name: 'DiscountRead', params: { id: discount.id } }"
                          v-if="$helper.isAllowed('read_discounts')"
                        >
                          Detail
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="edit"
                          :to="{ name: 'DiscountEdit', params: { id: discount.id } }"
                          v-if="$helper.isAllowed('edit_discounts')"
                        >
                          Edit
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="delete"
                          @click="confirmDelete(discount.id)"
                          v-if="$helper.isAllowed('delete_discounts')"
                        >
                          Delete
                        </badaso-dropdown-item>
                      </vs-dropdown-menu>
                    </badaso-dropdown>
                  </vs-td>
                </vs-tr>
              </template>
            </badaso-table>
          </div>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
import moment from 'moment'
export default {
  name: "DiscountBrowse",
  components: {},
  data() {
    return {
      selected: [],
      discounts: [],
      descriptionItems: [10, 50, 100],
      totalItem: 0,
      filter: "",
      page: 1,
      limit: 10,
      orderField: "updated_at",
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
    this.getDiscountList()
  },
  methods: {
    getDate(date) {
      return moment(date).format('DD MMMM YYYY')
    },
    confirmDelete(id) {
      this.willDeleteId = id;
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("action.delete.title"),
        text: this.$t("action.delete.text"),
        accept: this.deleteDiscount,
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {
          this.willDeleteId = null;
        },
      });
    },
    confirmDeleteMultiple(id) {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("action.delete.title"),
        text: this.$t("action.delete.text"),
        accept: this.bulkDeleteDiscounts,
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {},
      });
    },
    deleteDiscount() {
      this.$openLoader();
      this.$api.badasoDiscount
        .delete({ id: this.willDeleteId })
        .then((response) => {
          this.$closeLoader();
          this.getDiscountList();
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
    bulkDeleteDiscounts() {
      const ids = this.selected.map((item) => item.id);
      this.$openLoader();
      this.$api.badasoDiscount
        .deleteMultiple({
          ids: ids.join(","),
        })
        .then((response) => {
          this.$closeLoader();
          this.getDiscountList();
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
    getDiscountList() {
      this.$openLoader();
      this.$api.badasoDiscount
      .browse()
      .then((response) => {
        this.$closeLoader();
        this.selected = [];
        this.discounts = response.data.discounts;
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
  },
};
</script>
