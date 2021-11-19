<template>
  <div @click="emit">
    <slot />
  </div>
</template>

<script>
export default {
  props: {
    order: Object
  },
  methods: {
    emit() {
      this.$emit("input", this.redirect);
    },
    redirect(res) {
      this.$inertia.visit(this.route('badaso.commerce-theme.payment-info', this.order.id))
    },
  },
}
</script>