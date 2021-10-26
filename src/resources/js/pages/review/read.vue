<template>
  <div>
    <badaso-breadcrumb-row>
    </badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('read_product_reviews')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("productReview.detail.title") }}</h3>
          </div>
          <table class="badaso-table">
            <tr>
              <th>{{ $t("productReview.detail.header.name") }}</th>
              <td>{{ review.product.name }}</td>
            </tr>
            <tr>
              <th>{{ $t("productReview.detail.header.orderDate") }}</th>
              <td>{{ getDate(review.orderDetail.createdAt) }}</td>
            </tr>
            <tr>
              <th>{{ $t("productReview.detail.header.email") }}</th>
              <td>{{ review.user.email }}</td>
            </tr>
            <tr>
              <th>{{ $t("productReview.detail.header.rating") }}</th>
              <td>{{ review.rating.toFixed(2) }}</td>
            </tr>
            <tr>
              <th>{{ $t("productReview.detail.header.review") }}</th>
              <td>{{ review.review }}</td>
            </tr>
            <tr>
              <th>{{ $t("productReview.detail.header.media") }}</th>
              <td>
                <template v-for="media, index in review.media">
                  <img width="100" v-if="review.media.length > 0 && isImage(media)" :key="`image-${index}`" :src="media" loading="lazy">
                  <video width="100" v-if="isVideo(media)" :key="`video-${index}`">
                    <source :src="media">
                  </video>
                </template>
              </td>
            </tr>
            <tr>
              <th>{{ $t("productReview.detail.header.createdAt") }}</th>
              <td>{{ getDate(review.createdAt) }}</td>
            </tr>
            <tr>
              <th>{{ $t("productReview.detail.header.updatedAt") }}</th>
              <td>{{ getDate(review.updatedAt) }}</td>
            </tr>
          </table>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
import moment from 'moment'
export default {
  name: "ProductRead",
  components: {},
  data: () => ({
    review: {
      name: "",
      product: {
        name: ""
      },
      orderDetail: {
        createdAt: ""
      },
      user: {
        email: ""
      },
      rating: 0,
      review: "",
      media: [],
      createdAt: "",
      updatedAt: ""
    }
  }),
  mounted() {
    this.getProductReviewDetail();
  },
  methods: {
    isImage(image) {
      var _validFileExtensions = [".jpg", ".jpeg", ".png"];
      var extIsValid = false;
      for (var j = 0; j < _validFileExtensions.length; j++) {
        var currentExtension = _validFileExtensions[j];
        if (image.endsWith(currentExtension)) {
          extIsValid = true;
          break;
        }
      }

      if (!extIsValid) return false;
      return true;
    },
    isVideo(video) {
      var _validFileExtensions = [".mp4", ".mkv"];
      var extIsValid = false;
      for (var j = 0; j < _validFileExtensions.length; j++) {
        var currentExtension = _validFileExtensions[j];
        if (video.endsWith(currentExtension)) {
          extIsValid = true;
          break;
        }
      }

      if (!extIsValid) return false;
      return true;
    },
    getDate(date) {
      return moment(date).format('dddd, DD MMMM YYYY')
    },
    getProductReviewDetail() {
      this.$openLoader();
      this.$api.badasoReview
      .read({ id: this.$route.params.id })
      .then((response) => {
        this.$closeLoader();
        this.review = response.data.review;
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

<style lang="scss">
.product-details {
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;

  &--card {
    & > .vs-card--content {
      margin-bottom: 0;
    }
  }

  &__discount {
    &--text {
      text-decoration: line-through;
    }
  }

  &__item {
    display: flex;
    height: 100%;
  }
}
</style>