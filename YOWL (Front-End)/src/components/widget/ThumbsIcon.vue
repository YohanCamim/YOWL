<template>
  <div class="container_thumbGroup">
    <div class="container_thumb">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="svgFormat"
        :fill="like == 1 ? 'grey' : 'none'"
        viewBox="0 0 24 24"
        stroke="currentColor"
        title="test"
        v-on:click="clickThumbUp()"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"
        />
      </svg>
      <div class="textAlign">
        {{ article.ratingUp > 0 ? article.ratingUp : 0 }}
      </div>
    </div>
    <div class="container_thumb">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="svgFormat"
        :fill="like == 0 ? 'grey' : 'none'"
        viewBox="0 0 24 24"
        stroke="currentColor"
        v-on:click="clickThumbDown()"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"
        />
      </svg>
      <div class="textAlign">
        {{ article.ratingDown > 0 ? article.ratingDown : 0 }}
      </div>
      <div v-if="error.length > 0" class="popupInfo" id="popupInfo">
        {{ error }}
      </div>
    </div>
  </div>
</template>

<script>
import settings from "@/settings.js";
export default {
  name: "Thumbs",
  props: {
    article: Object,
  },
  data() {
    return {
			like: -1,
      error: "",
      time_interval: 0,
      time_timeout: 0,
    };
  },
  computed: {
    isModeUser() {
      return this.$store.state.modeArticleUser;
    },
    connected() {
      return this.$store.getters["isConnected"];
    },
		listlike() {
			return this.$store.state.likes;
		}
  },
	beforeUpdate(){
		if(this.connected){
			setTimeout(() => {
				const alreadyLiked = this.$store.state.likes.find((like) => like.news_id == this.article.id);
				this.like = (alreadyLiked) ? alreadyLiked.type : -1;
			}, 1000);
		}
	},
	beforeUnmount() {
		clearInterval(this.time_interval);
		this.time_interval = null;
		clearTimeout(this.time_timeout);
		this.time_timeout = null;
	},
  methods: {
    clickThumbUp() {
      this.clickThumb("1");
    },
    clickThumbDown() {
      this.clickThumb("0");
    },
    clickThumb(typeThumb) {
      if (this.connected) {
				this.like = (typeThumb == "1") ? 1 : 0
        fetch(settings.SERVICE_URI + "news/like/" + this.article.id, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            accept: "application/json",
            Authorization: `Bearer ${this.$store.state.token}`,
          },
          body: JSON.stringify({ type: typeThumb }),
        }).then((res) => {
					this.$store.dispatch("getLikes");
          this.$emit("updateThumb");
          res.json().then((data) => {
            data;
          });
        });
      } else {
        this.popup("Vous devez être connecté");
      }
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
.popupInfo {
  position: absolute;
  padding: 5px;
  bottom: -150%;
  left: 0;
  width: auto;
  background: beige;
  border: 1px solid;
}
/********************************
		Thumbs
*********************************/
.container_thumbGroup {
  position: relative;
  height: 30px;
  /* inside */
  display: flex;
  flex-flow: row;
}
.container_thumb {
  display: grid;
  cursor: pointer;
  grid-template-columns: 1fr 1fr;
  column-gap: 5px;
}
.textAlign {
  font-family: "Lato", sans-serif;
  align-self: center;
  text-align: left;
}
.svgFormat {
  width: 25px;
}
</style>