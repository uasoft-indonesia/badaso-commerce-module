<template>
  <div @click="$router.push({ name: 'PaymentInfo', params: { id: order.id } })">
    <slot />
  </div>
</template>

<script>
export default {
  props: {
    order: Object
  },
}
</script>