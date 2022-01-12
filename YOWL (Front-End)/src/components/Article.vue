<template>
  <div class="container_article">
    <div class="container_image" @click="callArticle()">
      <img class="image" :src="article.imageUrl" :alt="article.title" />
      <div class="gradienImage"></div>
    </div>
    <div class="container_shape"></div>
    <div class="container_title" @click="callArticle()">
      <div>{{ article.title }}</div>
    </div>
    <div class="container_content hide768">
      <div class="collider" />
      <div class="description">
        {{
          article.content + (article.content.indexOf("...") !== -1 ? "" : "...")
        }}
      </div>
    </div>
    <div v-if="!flux">
      <ThumbsIcon
        class="thumbAlign hide768"
        :article="article"
        @updateThumb="updateThumb"
      />
      <CommentIcon class="hide768" :article="article"/>
    </div>
    <div v-if="!flux" class="viewMore" @click="callArticle()">Voir plus...</div>
    <div v-if="flux" class="viewMore" @click="callSaveArticle()">Enregistrer...</div>
    <div v-if="error.length > 0" class="popupInfo" id="popupInfo">
      {{ error }}
    </div>
  </div>
</template>

<script>
import ThumbsIcon from "@/components/widget/ThumbsIcon";
import CommentIcon from "@/components/widget/CommentIcon";
export default {
  name: "Article",
  components: {
    ThumbsIcon,
    CommentIcon,
  },
  props: {
    article: Object,
    flux: Boolean,
  },
  data() {
    return {
      nbrComments: 0,
      like: -1,
      error: "",
      time_interval: 0,
      time_timeout: 0,
			save: false,
    };
  },
	beforeUnmount() {
		clearInterval(this.time_interval);
		this.time_interval = null;
		clearTimeout(this.time_timeout);
		this.time_timeout = null;
	},
  methods: {
    callArticle() {
      this.$router.push("/article/" + this.article.id);
    },
    callSaveArticle() {
      if (this.$store.getters["isConnected"]) {
				if((this.articleExist(this.article.url)) || (this.save)){
					this.popup("Cette article existe déja");
				} else {
					this.$store.dispatch("addArticle", {'url':this.article.url, 'flux':true });
					this.popup("Nouvel article créé");
					this.save = true;
				}
      } else {
        this.popup("Vous devez être connecté");
      }
    },
		articleExist(url) {
			let articles = this.$store.state.articlesDB;
			let result = articles.find(article => article.url === url)
			if(result == undefined){
				return false;
			}
			return true;
		},
    updateThumb() {
      this.$emit("updateThumb");
    },
    popup(text) {
      if (this.time_interval != null) {
        clearInterval(this.time_interval);
        this.time_interval = null;
        clearTimeout(this.time_timeout);
        this.time_timeout = null;
      }
      this.error = text;
      let opacityValue = 1;
      this.time_interval = setInterval(() => {
        opacityValue -= 0.1;
        document.getElementById("popupInfo").style.opacity = opacityValue;
      }, 200);
      this.time_timeout = setTimeout(() => {
        this.error = "";
        document.getElementById("popupInfo").style.opacity = 1;
        clearInterval(this.time_interval);
        this.time_interval = null;
      }, 2000);
    },
  },
};
</script>

<style scoped>
/********************************
		Info
*********************************/
.popupInfo {
  position: absolute;
  padding: 5px;
  bottom: 30px;
  right: 20%;
  width: auto;
  background: beige;
  border: 1px solid;
}
/********************************
		Article
*********************************/
.container_article {
  position: relative;
  border: 1px solid rgb(143, 143, 143);
  width: 100%;
  height: 250px;
  margin-bottom: 10px;
  overflow: hidden;
  background-color: rgb(255, 226, 214);
}
/********************************
		Image
*********************************/
.container_image {
  display: inline-block;
  position: relative;
  height: 100%;
	cursor: pointer;
}
.image {
  top: 20px;
  left: 30px;
  min-height: 250px;
}
.gradienImage {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(
    to right,
    rgba(0, 0, 255, 0),
    rgba(0, 0, 255, 0),
    rgb(255, 226, 214)
  );
}
/********************************
		Title
*********************************/
.container_title {
  position: absolute;
  top: 5px;
  text-align: right;
  padding: 3px 10px;
  font-size: 30px;
  overflow: hidden;
  text-shadow: 1px 1px 2px rgb(255, 255, 255), 0 0 1em rgb(255, 255, 255),
    0 0 0.2em rgb(255, 255, 255);
  background: linear-gradient(to right, rgba(0, 0, 255, 0), white, white);
	cursor: pointer;
}
/********************************
		Content
*********************************/
.tmp {
  border: 1px solid;
}
.container_content {
  position: absolute;
  top: 90px;
  right: 10px;
  width: 570px;
  height: 130px;
}
.description {
  font-size: 18px;
}
.collider {
  width: 100px;
  height: 100%;
  -webkit-shape-outside: polygon(0 0, 100% 100%, 0 100%);
  shape-outside: polygon(0 0, 100% 100%, 0 100%);
  float: left;
  -webkit-clip-path: polygon(0 0, 100% 100%, 0 100%);
  clip-path: polygon(0 0, 100% 100%, 0 100%);
}
.container_shape {
  position: absolute;
  top: 0;
  right: 0;
  height: 100%;
  width: 35%;
  border-top: 250px solid rgba(255, 255, 255, 0.5);
  border-left: 150px solid transparent;
}
.viewMore {
  position: absolute;
  bottom: 5px;
  right: 20%;
  color: rgb(126, 110, 104);
  cursor: pointer;
}
.viewMore:hover {
  color: rgb(37, 33, 31);
}
/********************************
		Thumbs
*********************************/
.thumbAlign {
  position: absolute;
  top: 0;
  right: 0;
  margin-top: 10px;
}
/********************************
		Comments
*********************************/
.container_comments {
  position: absolute;
  right: 0;
  bottom: 0;
}
</style>