<template>
  <div @click="emit(option)">
    <slot />
  </div>
</template>

<script>
export default {
  props: {
    option: Object,
    value: String,
  },
  methods: {
    emit(o) {
      this.$emit("input", o.slug);
      this.$emit("checkout", this.redirect);
    },
    redirect(res) {
      this.$inertia.visit(this.route('badaso.shopuu-theme.payment-info', res.data.order))
    },
  },
};
</script>
