<template>
  <div class="container_select">
    <select class="selectFilter" name="lists" v-model="pickFilter" @change="filterChange()">
      <option
        v-for="filter in selectFilter"
        :key="filter.id"
        :value="filter.id"
      >
        {{ filter.name }}
      </option>
    </select>
  </div>
</template>

<script>
import settings from "@/settings.js";
export default {
  name: "FilterArticles",
  data() {
    return {
			pickFilter: settings.FLUX_CURRENT,

    };
  },
	mounted(){
		this.$store.dispatch("getNamesFlux");
	},
	methods: {
		filterChange(){
			settings.FLUX_CURRENT = this.pickFilter;
		}
	}
};
</script>
<style scoped>
.container_select {
	cursor: pointer;
}
.selectFilter {
	font-family: 'Lato', sans-serif;
  width: 180px;
  font-size: 22px;
  padding: 3px;
  color: rgb(34, 34, 34);
  text-align: center;

  border: none;
  border-bottom: 2px solid white;
  background: none;
}
.selectFilter:focus {
  outline: none;
  border: none;
  background: white;
}
</style>
