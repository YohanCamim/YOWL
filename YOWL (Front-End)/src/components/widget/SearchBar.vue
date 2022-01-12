<template>
  <div class="container_searchBar">
    <input
      class="searchBar boxsizingBorder"
      type="text"
      v-model="searchBarText"
      v-on:keyup.enter="searchCall()"
      placeholder="recherche..."
    />
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="svgFormat"
      fill="none"
      viewBox="0 0 24 24"
      stroke="rgb(34, 34, 34)"
      v-on:click="searchCall()"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
      />
    </svg>
  </div>
</template>

<script>
export default {
  name: "SearchBar",
  data() {
    return {
      searchBarText: "",
    };
  },
  methods: {
    searchCall() {
      this.$emit("emit_searchBar", this.searchBarText);
    },
  },
};
</script>

<style scoped>
.svgFormat {
  margin-left: 10px;
  margin-right: 10px;
  width: 25px;
	cursor: pointer;
}
.container_searchBar {
  display: flex;
  flex-flow: row;
  width: 100%;
	height: 35px;
  color: white;
}
.searchBar {
	font-family: 'Lato', sans-serif;
  width: 100%;
  font-size: 22px;
  padding: 3px;
  color: rgb(34, 34, 34);

  border: none;
  border-bottom: 2px solid white;
  background: none;
}
.searchBar::placeholder {
	color: white;
}
.searchBar:focus::placeholder {
	color: transparent;
}
.searchBar:focus {
  outline: none;
  border: none;
  background: white;
}
.boxsizingBorder {
  -webkit-box-sizing: border-box; /* chrome, safari */
  -moz-box-sizing: border-box; /* firefox */
  box-sizing: border-box;
}
</style>