<template>
  <div>
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="svgFormat"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
			@click="addArticleCall"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
      />
    </svg>
  </div>
</template>

<script>
export default {
  name: "AddArticleIcon",
	methods: {
		addArticleCall(){
			this.$emit("addArticleCall");
		}
	}
};
</script>

<style scoped>
.svgFormat {
  width: 30px;
	cursor: pointer;
}
.svgFormat:hover {
	filter: drop-shadow(0px 0px 10px white);
	fill: rgb(255, 255, 255)
}
</style>