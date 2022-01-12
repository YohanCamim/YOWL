<template>
  <div class="container_menu">
    <Logo class="logoAlign" />
    <SourceRadio class="radioAlign" @changeSource="Emit_changeSourceArticles" />
    <div v-if="connected" class="usernameFormat hide320">
      Bienvenue {{ username }}
    </div>
    <ConnectController class="loginAlign" @updateArticles="getArticles"/>
    <FilterArticles
      v-if="!isModeFlux"
      class="filterAlign hide320"
      @change="On_filterChange()"
    />
    <SearchBar v-if="!isModeFlux" class="searcBarAlign" @emit_searchBar="Emit_SearchBar" />
    <div v-if="connected && !isModeFlux" class="iconSubscribe">
      <AllArticlesIcon
        class="iconAlign"
        :isFocus="!isModeUser"
				@mouseenter="popup('Tous les articles.')"
        @getAllArticles="Emit_modeArticlesUser(false)"
      />
      <FolderIcon
        class="iconAlign"
        :isFocus="isModeUser"
				@mouseenter="popup('Mes articles.')"
        @articlesUserCall="Emit_modeArticlesUser(true)"
      />
      <AddArticleIcon
        class="iconAlign"
				@mouseenter="popup('Ajouter un article.')"
        @addArticleCall="Emit_modeAddArticle(true)"
      />
      <div v-if="error.length > 0" class="popupInfo" id="popupInfo">
        {{ error }}
      </div>
    </div>
  </div>
  <div class="mainResponsive flexGlobal">
    <AddArticle
      v-if="modeAddArticle == true"
      @close="Emit_modeAddArticle(false)"
      @valid="Emit_newArticle"
    />
    <div class="background_global">
      <div class="container_articles" v-if="articles.length > 0">
        <Article
          v-for="(article, index) in articles"
          :key="index"
          :article="article"
          :flux="isModeFlux"
          @updateThumb="Emit_updateThumb"
        />
      </div>
    </div>
    <Obligations class="obligation" />
  </div>
</template>

<script>
import Logo from "@/components/widget/Logo";
import Obligations from "@/components/Obligations";
import ConnectController from "@/components/ConnectController";
import AddArticle from "@/components/AddArticle";

import FilterArticles from "@/components/widget/FilterArticles";
import SearchBar from "@/components/widget/SearchBar";

import FolderIcon from "@/components/widget/FolderIcon";
import AddArticleIcon from "@/components/widget/AddArticleIcon";
import AllArticlesIcon from "@/components/widget/AllArticlesIcon";

import SourceRadio from "@/components/widget/SourceRadio";
import Article from "@/components/Article";
export default {
  name: "Display",
  components: {
    ConnectController,
    Logo,
    Obligations,
    AddArticle,
    FilterArticles,
    AddArticleIcon,
    AllArticlesIcon,
    FolderIcon,
    SearchBar,
    SourceRadio,
    Article,
  },
  data() {
    return {
      modeAddArticle: false,
      error: "",
			searchText: "",
      time_interval: 0,
      time_timeout: 0,
    };
  },
  mounted() {
    this.getArticles();
  },
	beforeUpdate() {
		if(this.connected){
			this.$store.dispatch("getLikes");
		}
	},
	beforeUnmount() {
		clearInterval(this.time_interval);
		this.time_interval = null;
		clearTimeout(this.time_timeout);
		this.time_timeout = null;
	},
  computed: {
    connected() {
      return this.$store.getters["isConnected"];
    },
    isModeFlux() {
      return this.$store.state.modeArticleFlux;
    },
    isModeUser() {
      return this.$store.state.modeArticleUser;
    },
    username() {
      return this.$store.getters["username"];
    },
    articles() {
      return this.$store.state.articles;
    },
  },
  methods: {
    Emit_modeArticlesUser(value) {
      this.$store.commit("setModeArticleUser", value);
      this.getArticles();
    },
    Emit_newArticle() {
      this.Emit_modeAddArticle(false);
      this.getArticles();
    },
    Emit_modeAddArticle(value) {
      this.modeAddArticle = value;
    },
    Emit_updateThumb() {
      this.getArticles();
    },
    Emit_changeSourceArticles() {
      window.scrollTo(0, 0);
      this.getArticles();
    },
    Emit_SearchBar(searchText) {
			this.searchText = searchText;
      if (searchText.length > 0) {
        if (this.isModeUser) {
          let obj = {
            id: this.$store.state.userId,
            text: searchText,
          };
          this.$store.dispatch("searchArticlesUser", obj);
        } else {
          this.$store.dispatch("searchArticles", searchText);
        }
      } else {
        this.getArticles();
      }
    },
    On_filterChange() {
      this.getArticles();
    },
		cancelTimer(){
			clearInterval(this.time_interval);
			this.time_interval = null;
			clearTimeout(this.time_timeout);
			this.time_timeout = null;
			this.error = "";
		},
    getArticles() {
			this.cancelTimer()
      if (this.isModeFlux) {
        this.$store.dispatch("getArticlesFlux");
      } else {
				if(this.searchText.length > 0){
					this.Emit_SearchBar(this.searchText)
				} else {
					if (this.isModeUser) {
							let idUser = this.$store.state.userId;
							this.$store.dispatch("getArticlesUser", idUser);
					} else {
							this.$store.dispatch("getArticles");
					}
				}
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
  bottom: -90%;
	margin-right: 20px;
  right: 0;
  width: auto;
  background: beige;
  border: 1px solid;
}
.error {
  width: 100%;
  font-size: 20px;
  color: red;
  padding-top: 3px;
  padding-bottom: 3px;
  text-align: center;
  background: white;
}
.background_global {
  padding: 10px 10px 0px 10px;
  background: rgb(223, 223, 223);
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
.obligation {
  margin-top: auto;
}
.flexGlobal {
  display: flex;
  flex-flow: column;
}
.loginAlign {
  position: absolute;
  right: 50px;
  top: 20px;
}
/*
    Logo and widget
*/
.iconSubscribe {
	position: relative;
  grid-column: 4;
  grid-row: 2;
  display: flex;
  flex-flow: row;
  justify-content: space-evenly;
}
.iconAlign {
  align-self: flex-end;
}
.logoAlign {
  grid-column: 1;
  grid-row: 1 / 3;
}
.radioAlign {
  grid-column: 2;
  grid-row: 1;
  align-self: flex-end;
	height: 46px;
}
.filterAlign {
  grid-column: 2;
  grid-row: 2;
  align-self: flex-end;
  text-align: center;
}
.searcBarAlign {
  align-self: flex-end;
}
/*
    Container
*/
.container_menu {
  position: sticky;
  top: 0;
  width: 100%;
  display: grid;
  grid-template-columns: 120px 220px 3fr 200px;
	background: linear-gradient(rgb(138, 138, 138), rgb(70, 70, 70));
  margin-bottom: 5px;
  padding: 5px 10px;
  z-index: 100;
}
.container_articles {
  display: flex;
  flex-flow: column;
  width: 100%;
  height: 100%;
}
</style>
