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
			pickFilter: settings.FILTER_CURRENT,
      selectFilter: [
        { id: settings.FILTER_NOVELTY, name: "Nouveautés" },
        { id: settings.FILTER_BEST_RATED, name: "Mieux notés" },
        { id: settings.FILTER_POPULAR, name: "Populaires" },
      ],
    };
  },
	methods: {
		filterChange(){
			settings.FILTER_CURRENT = this.pickFilter;
			this.$store.commit("setFilter", this.pickFilter);
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
	color: rgba(255, 255, 255, 0.5);
  text-align: center;

  border: none;
  border-bottom: 2px solid white;
  background: none;
}
.selectFilter:focus {
  outline: none;
  border: none;
  background: white;
	color: rgba(40, 40, 40);
}
</style>
