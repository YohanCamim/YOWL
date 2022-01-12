<template>
  <div :class="{ svgBorder: isFocus }">
    <svg
      xmlns="http://www.w3.org/2000/svg"
			class="svgFormat"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
			@click="articlesUserCall"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"
      />
    </svg>
  </div>
</template>

<script>
export default {
  name: "FolderIcon",
  props: {
    isFocus: Boolean,
  },
	methods:{
		articlesUserCall(){
			this.$emit("articlesUserCall");
		}
	}
};
</script>

<style scoped>
.svgFormat {
  width: 30px;
	cursor: pointer;
}
.svgBorder {
	border-bottom: 2px solid white
}
.svgFormat:hover {
	filter: drop-shadow(0px 0px 10px white);
	fill: rgb(255, 255, 255)
}
</style>