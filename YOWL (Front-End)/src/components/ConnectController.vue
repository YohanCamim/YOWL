<template>
  <div>
    <div v-if="connected" @click="logout()" class="buttonFormat">DECONNEXION</div>
		<div v-else @click="login()" class="buttonFormat">CONNEXION</div>
    <!-- <router-link v-else to="/login" class="buttonFormat">CONNEXION</router-link> -->
  </div>
</template>

<script>
export default {
  name: "ConnectController",
  computed: {
    connected() {
      return this.$store.getters["isConnected"];
    },
  },
  methods: {
    logout() {
      this.$store.dispatch("logout");
			let arr = [];
			this.$store.commit("setLikes", arr);
			this.$emit("updateArticles");
    },
		login() {
			this.$router.push("/login");
		}
  },
};
</script>

<style scoped>
.buttonFormat {
	font-family: 'Lato', sans-serif;
  font-size: 20px;
  color: rgb(34, 34, 34);
  background: none;
  cursor: pointer;
}
.buttonFormat:hover {
  text-shadow: white 1px 0 10px;
}
</style>