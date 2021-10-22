<template>
  <div>
    <vs-popup
      :title="$t('payments.option.popup.add.title')"
      :active.sync="addOptionPopUp"
    >
      <vs-row>
        <badaso-text
          v-model="option.name"
          size="12"
          :label="$t('payments.option.popup.add.field.name')"
          :alert="errors.name"
        ></badaso-text>
        <badaso-text
          v-model="option.slug"
          size="12"
          :label="$t('payments.option.popup.add.field.slug')"
          :alert="errors.slug"
        ></badaso-text>
        <badaso-text
          v-model="option.description"
          size="12"
          :label="$t('payments.option.popup.add.field.description')"
          :alert="errors.description"
        ></badaso-text>
        <badaso-upload-image
          size="12"
          v-model="option.image"
          :label="$t('payments.option.popup.add.field.image')"
          :alert="errors.image"
        ></badaso-upload-image>
        <badaso-text
          v-model="option.order"
          size="6"
          :label="$t('payments.option.popup.add.field.order')"
          :alert="errors.order"
        ></badaso-text>
        <badaso-switch
          v-model="option.isActive"
          size="6"
          :label="$t('payments.option.popup.add.field.isActive')"
          :alert="errors.isActive"
        ></badaso-switch>
      </vs-row>
      <vs-row vs-type="flex" vs-justify="space-between">
        <vs-col vs-lg="2" vs-type="flex" vs-align="flex-end">
          <vs-button
            class="payment-management__button"
            color="danger"
            @click="closeModal()"
            type="relief"
            >{{ $t("payments.option.popup.add.button.cancel") }}</vs-button
          >
        </vs-col>
        <vs-col vs-lg="2" vs-type="flex" vs-align="flex-end">
          <vs-button
            class="payment-management__button"
            color="primary"
            @click="saveOption()"
            type="relief"
            >{{ $t("payments.option.popup.add.button.add") }}</vs-button
          >
        </vs-col>
      </vs-row>
    </vs-popup>

    <badaso-breadcrumb-row>
      <template slot="action" v-if="$helper.isAllowed('add_payment_options')">
        <vs-button color="primary" type="relief" @click="addOption()">
          <vs-icon icon="add"></vs-icon> {{ $t("action.addItem") }}
        </vs-button>
      </template>
    </badaso-breadcrumb-row>

    <vs-row v-if="$helper.isAllowed('edit_payments')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("payments.option.title") }}</h3>
          </div>
          <vs-row>
            <vs-col class="payment-management__builder-header">
              <vs-row vs-align="center">
                <vs-col vs-lg="3">
                  Name
                </vs-col>
                <vs-col vs-lg="3">
                  Slug
                </vs-col>
                <vs-col vs-lg="3">
                  Active
                </vs-col>
              </vs-row>
            </vs-col>
            <vs-col class="payment-management__builder-col">
              <draggable v-model="paymentOptions" @start="drag=true" @end="drag=false; startArrangeItems()">
                <div class="payment-management__box" v-for="data, index in paymentOptions" :key="index">
                  <div class="payment-management__display">
                    <div class="payment-management__text-display">
                      <vs-row vs-align="center">
                        <vs-col vs-lg="3">
                          <span>{{ data.name }}</span> <br>
                        </vs-col>
                        <vs-col vs-lg="3">
                          <span>{{ data.slug }}</span>
                        </vs-col>
                        <vs-col vs-lg="3">
                          <vs-icon color="success" v-if="data.isActive == 1" icon="radio_button_checked" />
                          <vs-icon color="gray" v-else icon="radio_button_unchecked" />
                        </vs-col>
                      </vs-row>
                    </div>
                  </div>
                  <div class="payment-management__action">
                    <badaso-dropdown vs-trigger-click>
                      <vs-button
                        size="large"
                        type="flat"
                        icon="more_vert"
                      ></vs-button>
                      <vs-dropdown-menu>
                        <badaso-dropdown-item
                          icon="edit"
                          @click="editOption(data)"
                          v-if="$helper.isAllowed('edit_menu_items')"
                        >
                          Edit
                        </badaso-dropdown-item>
                        <badaso-dropdown-item
                          icon="delete"
                          @click="openConfirm(data.id)"
                          v-if="$helper.isAllowed('delete_menu_items')"
                        >
                          Delete
                        </badaso-dropdown-item>
                      </vs-dropdown-menu>
                    </badaso-dropdown>
                  </div>
                  <vs-popup
                    :title="$t('payments.option.popup.edit.title')"
                    :active.sync="data.editItem"
                  >
                    <vs-row>
                      <badaso-text
                        v-model="data.name"
                        size="12"
                        :label="$t('payments.option.popup.edit.field.name')"
                        :alert="errors.name"
                      ></badaso-text>
                      <badaso-text
                        v-model="data.slug"
                        size="12"
                        :label="$t('payments.option.popup.edit.field.slug')"
                        :alert="errors.slug"
                        disabled
                      ></badaso-text>
                      <badaso-text
                        v-model="data.description"
                        size="12"
                        :label="$t('payments.option.popup.edit.field.description')"
                        :alert="errors.description"
                      ></badaso-text>
                      <badaso-upload-image
                        size="12"
                        v-model="data.image"
                        :label="$t('payments.option.popup.edit.field.image')"
                        :alert="errors.image"
                      ></badaso-upload-image>
                      <badaso-text
                        v-model="data.order"
                        size="6"
                        :label="$t('payments.option.popup.edit.field.order')"
                        :alert="errors.order"
                      ></badaso-text>
                      <badaso-switch
                        v-model="data.isActive"
                        size="6"
                        :label="$t('payments.option.popup.edit.field.isActive')"
                        :alert="errors.isActive"
                      ></badaso-switch>
                    </vs-row>
                    <vs-row vs-type="flex" vs-justify="space-between">
                      <vs-col vs-lg="2" vs-type="flex" vs-align="flex-end">
                        <vs-button
                          class="payment-management__button"
                          color="danger"
                          @click="closeEditOption(data)"
                          type="relief"
                          >{{
                            $t("payments.option.popup.edit.button.cancel")
                          }}</vs-button
                        >
                      </vs-col>
                      <vs-col vs-lg="2" vs-type="flex" vs-align="flex-end">
                        <vs-button
                          class="payment-management__button"
                          color="primary"
                          @click="updateOption(data)"
                          type="relief"
                          >{{
                            $t("payments.option.popup.edit.button.edit")
                          }}</vs-button
                        >
                      </vs-col>
                    </vs-row>
                  </vs-popup>
                </div>
              </draggable>
            </vs-col>
          </vs-row>
        </vs-card>
      </vs-col>
    </vs-row>
    <vs-row v-else>
      <vs-col vs-lg="12">
        <vs-card>
          <vs-row>
            <vs-col vs-lg="12">
              <h3>{{ $t("payments.option.notAllowedToEdit") }}</h3>
            </vs-col>
          </vs-row>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>
<script>
import _ from "lodash";
import '../../assets/style.scss';
import draggable from 'vuedraggable'
export default {
  name: "PaymentOption",
  components: {
    draggable
  },
  data: () => ({
    errors: {},
    fieldList: [],
    paymentOptions: [],
    option: {
      name: null,
      slug: null,
      description: null,
      image: null,
      isActive: true,
      order: "0"
    },
    savedItems: [],
    flatSavedItems: [],
    arrangeItems: false,
    addOptionPopUp: false,
    editOptionPopUp: false,
    optionIdWillDelete: null,
  }),
  watch: {
    'option.name': {
      handler(val) {
        if (val) this.option.slug = this.$helper.generateSlug(val)
      }
    }
  },
  mounted() {
    this.getOptions();
  },
  methods: {
    openConfirm(id) {
      this.optionIdWillDelete = id;
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("action.delete.title"),
        text: this.$t("action.delete.text"),
        accept: this.deleteOption,
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
        cancel: () => {
          this.willDeleteId = null;
        },
      });
    },
    getOptions() {
      this.arrangeItems = false;
      this.$openLoader();
      this.$api.badasoPayment
        .browseOption({
          id: this.$route.params.id,
        })
        .then((response) => {
          if (response.data.options.length > 0) {
            let paymentOptions = response.data.options.map(val => {
              return {
                ...val,
                editItem: false
              }
            })
            this.paymentOptions = _.orderBy(paymentOptions, 'order', 'asc')
          }
        })
        .catch((error) => {
          this.$vs.notify({
            title: this.$t("alert.danger"),
            text: error.message,
            color: "danger",
          });
        })
        .finally(() => {
          this.$closeLoader();
        })
    },
    buildArrangeItems() {
      let ls = []
      for (let index = 0; index < this.paymentOptions.length; index++) {
        const element = this.paymentOptions[index];
        ls.push({
          ...element,
          order: index + 1
        })
      }
      return ls
    },
    startArrangeItems() {
      this.$openLoader();
      let paymentOptions = this.buildArrangeItems()
      this.$api.badasoPayment
        .arrangeOption({
          id: this.$route.params.id,
          paymentOptions
        })
        .then((response) => {
          this.getOptions();
        })
        .catch((error) => {
          this.$vs.notify({
            title: this.$t("alert.danger"),
            text: error.message,
            color: "danger",
          });
        })
        .finally(() => {
          this.$closeLoader();
        })
    },
    editOption(option) {
      option.editItem = true;
    },
    addOption(option) {
      this.option.order = this.paymentOptions.length + 1
      this.addOptionPopUp = true;
    },
    closeModal() {
      this.addOptionPopUp = false;
      this.editOptionPopUp = false;

      this.option.name = null;
      this.option.slug = null;
      this.option.description = null;
      this.option.image = null;
      this.option.isActive = true;
      this.option.order = "0";
    },
    closeEditOption(option) {
      option.editItem = false
    },
    saveOption() {
      this.errors = {};
      this.$openLoader();
      this.$api.badasoPayment
        .addOption({ ...this.option, id: this.$route.params.id })
        .then((response) => {
          this.getOptions();
          this.closeModal()
        })
        .catch((error) => {
          this.errors = error.errors;
          this.$vs.notify({
            title: this.$t("alert.danger"),
            text: error.message,
            color: "danger",
          });
        })
        .finally(() => {
          this.$closeLoader();
        })
    },
    deleteOption() {
      this.errors = {};
      this.$openLoader();
      this.$api.badasoPayment
        .deleteOption({
          id: this.optionIdWillDelete,
          paymentId: this.$route.params.id,
        })
        .then((response) => {
          this.willDeleteId = null;
          this.getOptions();
        })
        .catch((error) => {
          this.errors = error.errors;
          this.$vs.notify({
            title: this.$t("alert.danger"),
            text: error.message,
            color: "danger",
          });
        })
        .finally(() => {
          this.$closeLoader();
        })
    },
    updateOption(data) {
      this.errors = {};
      this.$openLoader();
      this.$api.badasoPayment
        .editOption({
          id: data.id,
          name: data.name,
          description: data.description,
          image: data.image,
          order: data.order,
          isActive: data.isActive,
          paymentId: this.$route.params.id
        })
        .then((response) => {
          this.closeModal()
          this.getOptions();
        })
        .catch((error) => {
          this.errors = error.errors;
          this.$vs.notify({
            title: this.$t("alert.danger"),
            text: error.message,
            color: "danger",
          });
        })
        .finally(() => {
          this.$closeLoader();
        })
    },
  },
};
</script>
