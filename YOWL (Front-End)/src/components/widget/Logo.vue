<template>
  <div>
    <router-link to="/">
      <img class="logo" src="@/assets/iconYowl.png" height="90" width="90" />
    </router-link>
  </div>
</template>

<script>
export default {
  name: "Logo",
};
</script>

<style scoped>
.logo:hover {
  filter: drop-shadow(0px 0px 10px white);
}
</style>