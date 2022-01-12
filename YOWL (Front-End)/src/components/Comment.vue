<template>
  <div @mouseenter="mouseOver = true" @mouseleave="mouseOver = false">
    <div class="container_head font16">
      <div class="container_user">
        <div class="space" v-if="comment.user">
          {{ "par " + comment.user.name }}
        </div>
        <div v-else class="space">
          {{ "par " + this.author }}
        </div>
        <div class="space">
          {{
            "le " +
            comment.created_at
              .replace("T", " ")
              .slice(0, comment.created_at.length - 11)
          }}
        </div>
        <div class="space" v-if="!comment.parent_id">
          {{ "vote(" + comment.rating + ")" }}
        </div>
        <div
          v-if="showResponse"
          class="space response"
          :class="{ mouseHover: isHover }"
          @click="showResponse = false"
        >
          Masquer les réponses
        </div>
        <div v-else>
          <div
            v-if="comment.replies"
            class="space response"
            :class="{ mouseHover: isHover }"
            @click="(showResponse = true), (response = false)"
          >
						<div v-if="comment.replies.length > 0">
							Montrer les réponses ({{ comment.replies.length }})
						</div>
          </div>
        </div>
        <div v-if="connected && !comment.parent_id">
          <div
            v-if="comment.replies.length == 0 || showResponse"
            class="space response"
            :class="{ mouseHover: isHover }"
            @click="response = 1 - response"
          >
            Répondre
          </div>
        </div>
      </div>
      <div
        class="container_user"
        v-if="mouseOver && connected && !comment.parent_id"
      >
        <img
          class="arrowUp"
          src="@/assets/arrow.png"
          height="15"
          @click="callArrowUp"
        />
        <img
          class="arrowDown"
          src="@/assets/arrow.png"
          height="15"
          @click="callArrowDown"
        />
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="svgWarning"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
          />
        </svg>
      </div>
    </div>
    <div
      class="container_comment font20"
      :class="{
        secondComment: comment.parent_id > 0,
        firstComment: !comment.parent_id,
      }"
    >
      {{ comment.content }}
    </div>
    <div v-if="response && showResponse" class="container_area">
      <textarea
        class="textArea"
        v-model="responseText"
        placeholder="commentaire..."
        alt="Zone de saise pour écrire un commentaire"
      ></textarea>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="svgAddComment"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        v-on:click="addResponseCall()"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M12 4v16m8-8H4"
        />
      </svg>
    </div>
    <div
      v-if="comment.replies && comment.replies.length > 0 && showResponse"
      class="container_comments"
    >
      <Comment
        class="comment"
        v-for="commentChild in comment.replies"
        :key="commentChild.id"
        :comment="commentChild"
        @updateArrow="Emit_updateArticle"
      />
    </div>
  </div>
</template>

<script>
import settings from "@/settings.js";
import Comment from "@/components/Comment";
export default {
  name: "Comment",
  components: {
    Comment,
  },
  props: {
    comment: Object,
  },
  data() {
    return {
      mouseOver: false,
      response: false,
      isHover: false,
      responseText: "",
      author: "",
      showResponse: false,
    };
  },
  created() {
    let listUsers = this.$store.state.users;
    let user = listUsers.find((user) => user.id == this.comment.author_id);
    this.author = user.name;
  },
  computed: {
    connected() {
      return this.$store.getters["isConnected"];
    },
  },
  methods: {
    callArrowUp() {
      this.changeArrow("1");
    },
    callArrowDown() {
      this.changeArrow("0");
    },
    changeArrow(typeArrow) {
      fetch(settings.SERVICE_URI + "comments/like/" + this.comment.id, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          accept: "application/json",
          Authorization: `Bearer ${this.$store.state.token}`,
        },
        body: JSON.stringify({ type: typeArrow }),
      }).then((res) => {
        this.$emit("updateArticle");
        res.json().then((data) => {
          data;
        });
      });
    },
    addResponseCall() {
      if (this.responseText.length > 0) {
        this.$store.dispatch("addCommentResponse", {
          news_id: this.comment.news_id,
          content: this.responseText,
          parent_id: this.comment.id,
        });
        this.$emit("updateArticle");
        this.response = false;
      }
      this.responseText = "";
    },
    Emit_updateArticle() {
      this.$emit("updateArticle");
      this.$store.dispatch("getCommentsArticle", this.id_article);
    },
  },
};
</script>

<style scoped>
.font20 {
  font-size: 20px;
}
.font16 {
  font-family: "Lato", sans-serif;
  font-size: 16px;
}
.container_head {
  display: flex;
  flex-flow: row;
  justify-content: space-between;
  color: grey;
}
.container_user {
  display: flex;
  flex-flow: row;
}
.container_comment {
  width: 100%;
  padding: 5px;
  background: white;
  -webkit-box-sizing: border-box; /* chrome, safari */
  -moz-box-sizing: border-box; /* firefox */
  box-sizing: border-box;
}
.firstComment {
  border: 1px solid;
  border-style: inset;
  background: rgb(158, 158, 158);
}
.secondComment {
  border: 1px solid;
  background: rgb(199, 199, 199);
  border-style: inset;
}
.space {
  margin-right: 20px;
}
.arrowUp {
  margin-left: 30px;
}
.arrowDown {
  margin-left: 10px;
  transform: scaleY(-1);
}
.svgWarning {
  margin-left: 30px;
  width: 20px;
}
.svgAddComment {
  margin-left: 10px;
  margin-right: 10px;
  width: 25px;
  cursor: pointer;
}
.container_area {
  display: flex;
  flex-flow: row;
  width: 100%;
  height: 100%;
  margin-top: 5px;
  margin-left: 20px;
  -webkit-box-sizing: border-box; /* chrome, safari */
  -moz-box-sizing: border-box; /* firefox */
  box-sizing: border-box;
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
.response {
  cursor: pointer;
}
.response:hover {
  color: black;
}
.container_comments {
  margin-top: 10px;
  margin-left: 20px;
}
</style>