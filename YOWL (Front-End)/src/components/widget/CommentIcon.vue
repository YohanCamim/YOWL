<template>
  <div class="container_comments">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="svgFormat"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"
      />
    </svg>
    <div class="textAlign">{{ ((article.comments) ? article.comments.length : 0) }}</div>
  </div>
</template>

<script>
export default {
  name: "CommentIcon",
  props: {
		article: Object,
  },
};
</script>

<style scoped>
/********************************
		Comments
*********************************/
.container_comments {
  display: grid;
  grid-template-columns: 1fr 1fr;
  column-gap: 5px;
  margin-bottom: 5px;
}
.svgFormat {
  width: 25px;
}
.textAlign {
	font-family: 'Lato', sans-serif;
	align-self: center;
}
</style>