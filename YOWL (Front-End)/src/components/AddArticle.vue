<template>
  <div class="modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <header class="container">
          <div class="closebtn" @mousedown="close">×</div>
          <h2>Veuillez saisir l'url du nouvel article :</h2>
        </header>
        <div class="containerInput">
          <input class="text" type="text" v-model="urlArticle" />
        </div>
        <div class="errorFormat">{{ error }}</div>
        <footer class="container">
          <p class="closebtn" @mousedown="close">Annuler</p>
          <p class="closebtn" @mousedown="valid">Valider</p>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AddArticle",
  data() {
    return {
      urlArticle: "",
      error: "",
    };
  },
	created: function () {
    this.scrollToTop()
	},
  methods: {
		scrollToTop() {
				window.scrollTo(0,0);
		},
    close() {
      this.$emit("close");
    },
    valid() {
      if (this.urlArticle.length > 0) {
        this.$store.dispatch("addArticle", {'url':this.urlArticle, 'flux':false });
        this.$emit("valid", this.urlArticle);
      } else {
        this.error = "Veuillez saisir une url"
      }
    },
  },
};
</script>

<style scoped>
/* Décrire l'animation */
@keyframes slideDownFadeIN {
  from {
    top: -100px;
    opacity: 0;
  }
  to {
    top: 0px;
    opacity: 1;
  }
}
/* Foncer l'arrière-plan de la fenêtre modale */
.modal {
	font-family: 'Lato', sans-serif;
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
  z-index: 20;
}
/* la fenêtre modale  */
.modal-dialog {
  position: absolute;
  width: 100%;
  top: 30%;
}
/* Le contenu de la modale */
.modal-dialog .modal-content {
  margin: auto;
  background-color: rgb(223, 223, 223);
  position: relative;
  padding: 0;
  outline: 0;
  border: 1px #777 solid;
  text-align: justify;
  width: 80%;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

  animation-name: slideDownFadeIN;
  animation-duration: 0.5s;
}
/* Bouton servant à fermer la fenêtre modale */
.closebtn:hover,
.closebtn:focus {
  color: rgb(255, 255, 255);
  text-decoration: none;
  cursor: pointer;
}
.container {
  padding: 2px 16px;
}
.containerInput {
  padding: 2px 16px;
}
.text {
  padding: none;
  width: 100%;
  border: none;
  padding: 4px;
  font-size: 30px;
  font-weight: bold;
  border-bottom: 2px solid white;
  background-color: transparent;
  -webkit-box-sizing: border-box; /* chrome, safari */
  -moz-box-sizing: border-box; /* firefox */
  box-sizing: border-box;
}
.text:focus{
	outline: none;
	border: none;
  background: white;
}
.closebtn {
  text-decoration: none;
  float: right;
  font-size: 35px;
  font-weight: bold;
  color: rgb(34, 34, 34);
}
header {
  background-color: rgb(223, 223, 223);
  font-size: 20px;
  color: rgb(34, 34, 34);
}
footer {
  display: flex;
  justify-content: space-around;
  background-color: rgb(223, 223, 223);
  font-size: 20px;
  color: rgb(34, 34, 34);
}
.errorFormat {
	text-align: center;
	font-size: 15px;
  height: 30px;
  color: rgb(145, 32, 32);
}
</style>