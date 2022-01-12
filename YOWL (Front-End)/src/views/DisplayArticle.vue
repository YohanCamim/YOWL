<template>
  <div class="container_menu">
    <Logo class="logoAlign" />
    <div v-if="connected" class="usernameFormat">Bienvenue {{ username }}</div>
    <div class="closebtn" @mousedown="returnList">Retourner à la liste</div>
  </div>
  <div class="mainResponsive">
    <div class="background_global">
      <div class="container_article">
        <div class="container_title">
          <div>{{ article.title }}</div>
        </div>
        <div class="container_image">
          <img :src="article.imageUrl" />
        </div>
        <div class="urlAndThumbs">
          <a :href="article.url" target="_blank">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="svgFormat"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              @mouseover="showLink = true"
              @mouseleave="showLink = false"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
              />
            </svg>
            <div v-if="showLink" class="link">{{ article.url }}</div>
          </a>
          <ThumbsIcon :article="article" @updateThumb="Emit_updateThumb" />
        </div>
        <div class="container_description">{{ article.content }}</div>
      </div>
      <div class="container_text">
        <div v-if="!connected" class="textNotConnected">
          Vous devez être connecté pour ajouter un commentaire
        </div>
        <div v-else class="container_area">
          <textarea
            class="textArea"
            v-model="content"
            placeholder="commentaire..."
            alt="Zone de saise pour écrire un commentaire"
          ></textarea>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="svgFormat"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            v-on:click="addCommentCall()"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 4v16m8-8H4"
            />
          </svg>
        </div>
      </div>
      <div class="container_comments">
        <Comment
          class="comment"
          v-for="comment in comments"
          :key="comment.id"
          :comment="comment"
					@updateArticle="Emit_updateArticle"
        />
      </div>
    </div>
    <Obligations class="obligation" />
  </div>
</template>

<script>
import Logo from "@/components/widget/Logo";
import ThumbsIcon from "@/components/widget/ThumbsIcon";
import Obligations from "@/components/Obligations";
import Comment from "@/components/Comment";
export default {
  name: "DisplayArticle",
  components: {
    Logo,
    ThumbsIcon,
    Obligations,
    Comment,
  },
  data() {
    return {
      id_article: Number,
      error: "",
      content: "",
      showLink: false,
    };
  },
  mounted() {
    this.id_article = this.$route.params.id;
    this.$store.dispatch("getArticle", this.id_article);
		this.$store.dispatch("getUsers");
    this.$store.dispatch("getCommentsArticle", this.id_article);
		if(this.connected){
			this.$store.dispatch("getLikes");
		}
  },
  computed: {
    connected() {
      return this.$store.getters["isConnected"];
    },
    username() {
      return this.$store.getters["username"];
    },
    article() {
      return this.$store.state.article;
    },
    comments() {
      return this.$store.state.comments;
    },
  },
  methods: {
    returnList() {
      this.$router.push("/");
    },
    addCommentCall() {
      if (this.content.length > 0) {
        this.$store.dispatch("addComment", {
          id_article: this.id_article,
          content: this.content,
        });
      }
      this.content = "";
    },
    Emit_updateThumb() {
      this.$store.dispatch("getArticle", this.id_article);
    },
		Emit_updateArticle(){
			this.$store.dispatch("getCommentsArticle", this.id_article);
		}
  },
};
</script>

<style scoped>
.link {
  position: absolute;
  padding: 5px;
  bottom: 0;
  left: 50px;
  width: auto;
  background: beige;
  border: 1px solid;
}
.svgFormat {
  width: 25px;
}
.error {
  width: 100%;
  font-size: 20px;
  color: red;
  overflow: hidden;
  padding-top: 3px;
  padding-bottom: 3px;
  text-align: center;
  background: white;
}
.container_menu {
  font-family: "Lato", sans-serif;
  position: relative;
  width: 100%;
  display: grid;
  grid-template-columns: 120px 220px 3fr 200px;
  background: linear-gradient(rgb(138, 138, 138), rgb(70, 70, 70));
  margin-bottom: 5px;
  padding: 5px 10px;
}
.logoAlign {
  grid-column: 1;
  grid-row: 1 / 3;
}
.usernameFormat {
  grid-column: 3;
  grid-row: 1;
  text-align: right;
  align-self: center;
  font-size: 22px;
  padding: 3px;
  color: rgb(34, 34, 34);
}
.background_global {
  font-family: "Lato", sans-serif;
  padding: 10px 10px 10px 10px;
  background: rgb(223, 223, 223);
}
/********************************
		Button quit
*********************************/
.closebtn {
  grid-column: 2 / 4;
  grid-row: 2;
  justify-self: center;
  text-decoration: none;
  float: right;
  font-size: 35px;
  font-weight: bold;
  color: rgb(34, 34, 34);
}
.closebtn:hover {
  color: rgb(255, 255, 255);
  text-decoration: none;
  cursor: pointer;
}
/********************************
		Article
*********************************/
.container_article {
  position: relative;
  border: 1px solid rgb(143, 143, 143);
  overflow: hidden;
  text-align: center;
}
/********************************
		Title
*********************************/
.container_title {
  /* position: absolute; */
  top: 5px;
  right: 140px;
  width: 100%;
  text-align: center;
  margin-top: 5px;
  padding: 3px 10px;
  font-size: 30px;
  overflow: hidden;
  text-shadow: 1px 1px 2px rgb(255, 255, 255), 0 0 1em rgb(255, 255, 255),
    0 0 0.2em rgb(255, 255, 255);
  background: linear-gradient(
    to right,
    rgba(0, 0, 255, 0),
    white,
    rgba(0, 0, 255, 0)
  );
}
.urlAndThumbs {
	position: relative;
  margin-left: 5px;
  margin-right: 5px;
  display: flex;
  flex-flow: row wrap;
  width: 100%;
  justify-content: space-between;
}
/********************************
		IMAGE
*********************************/
.container_image {
  margin-top: 5px;
  margin-bottom: 5px;
  text-align: center;
}
/********************************
		DESCRIPTION
*********************************/
.container_description {
  margin: 5px;
  padding: 5px;
  font-size: 20px;
  text-align: left;
  border-top: 1px solid rgb(172, 172, 172);
}
/********************************
		COMMENTS
*********************************/
.container_text {
  width: 100%;
  height: 60px;
  margin-top: 10px;
  margin-bottom: 10px;
}
.container_area {
  display: flex;
  flex-flow: row;
  width: 100%;
  height: 100%;
  -webkit-box-sizing: border-box; /* chrome, safari */
  -moz-box-sizing: border-box; /* firefox */
  box-sizing: border-box;
}
.container_comments{
	margin-top: 10px;
}
.textNotConnected {
  font-family: "Lato", sans-serif;
  width: 100%;
  height: 100%;
  font-size: 20px;
  padding: 5px;
  -webkit-box-sizing: border-box; /* chrome, safari */
  -moz-box-sizing: border-box; /* firefox */
  box-sizing: border-box;
  color: rgb(172, 54, 54);
  text-align: center;
  background: white;
}
.textArea {
  font-family: "Lato", sans-serif;
  resize: none;
  width: 100%;
  height: 100%;
  font-size: 20px;
  padding: 5px;
  -webkit-box-sizing: border-box; /* chrome, safari */
  -moz-box-sizing: border-box; /* firefox */
  box-sizing: border-box;
  outline: none;
  border: none;
  background: white;
}
.comment {
  margin-top: 10px;
}
.svgFormat {
  margin-left: 10px;
  margin-right: 10px;
  width: 25px;
  cursor: pointer;
}
/********************************
		FOOTER
*********************************/
.obligation {
  margin-top: auto;
}
</style>