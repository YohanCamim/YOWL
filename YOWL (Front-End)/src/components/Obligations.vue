<template>
  <div class="footer">
    <div v-if="show" class="popupInfo">
			<div class="closebtn" @click="show=false">X</div>
			<h2>A PROPOS :</h2>
			<div class="divText">Ce site est un projet de fin d'études. Les mentions légales qui suivent sont fictives et n'ont aucune validité juridique.</div>

			<h2>AGENCE :</h2>
			<div class="divText">Dénomination sociale : Yowl.
			Siège social : Lyon.
			Numéro de téléphone : 0011223344
			Email : yohan.lacroix@epitech.eu
			Forme juridique de la société : SARL.
			Montant du capital social : xxxx
			Nom du directeur : Yohan Lacroix.</div>

			<h2>HEBERGEUR :</h2>
			<div class="divText">Nom : herokuapp
			Dénomination ou raison sociale et adresse : 415 Mission Street Suite 300 San Francisco, CA 94105
			Numéro de téléphone : (866) 278-1349</div>

			<h2>COOKIE :</h2>
			<div class="divText">Ce site n'utilise pas de cookies. Nous ne saurions être responsable d'aucune sorte des sites sur lesquels vous iriez via notre site (ni à propos de leurs cookies, ni à propos de quoi que ce soit d'autre).
			Les seules données personelles dont nous disposons sont votre adresse ip et votre adresse email.
			Vous pouvez à tout moment modifier ou supprimer vos données personnelles via votre profil.
			Il est rappelé à l’utilisateur que le pseudonyme à lui seul ne constitue pas une donnée personnelle.
			il appartient à l’utilisateur de s’assurer de la confidentialité du ou des mots de passe utilisés sur le site Yowl. La société Yowl ne dispose d’aucun mot de passe et ne saurait être tenue pour responsable en cas de perte ou d’utilisation non conforme de cet élément. L’utilisateur est invité à signaler toute utilisation non autorisée de son espace utilisateur.</div>
			
			<h2>CONTACT :</h2>
			<div class="space divText">-Yohan Lacroix : Fonction : PDG. Mail : yohan.lacroix@epitech.eu -Cedric Gros : Fonction : Développeur. Mail : Cedric.Gros@epitech.eu -Matthias Brumant : Fonction : Développeur. Mail : Matthias.brumant@epitech.eu</div>
			<div class="closeQuit" @click="show=false">Quitter</div>
    </div>
    <div class="cursorFormat" @click="show = 1 - show">Mentions légales</div>
  </div>
</template>

<script>
export default {
  name: "Obligations",
  data() {
    return {
      show: false,
    };
  },
};
</script>

<style scoped>
h2{
	margin-left: 30px;
}
.divText{
	margin-left: 50px;
	margin-right: 50px;
}
.footer {
  font-family: "Lato", sans-serif;
  padding-top: 20px;
  padding-bottom: 20px;
  display: flex;
  flex-flow: row;
  justify-content: space-evenly;
  align-content: center;
  color: rgb(185, 185, 185);
}
.cursorFormat {
  cursor: pointer;
}
.cursorFormat:hover {
  color: white;
}
.space{
	margin-bottom: 40px;
}
.popupInfo {
  position: absolute;
  padding: 10px;
  bottom: 5%;
  left: 25%;
	margin: auto;
	width: 50%;
  background: beige;
	color: black;
  border: 1px solid;
	z-index: 1000;
}
.closeQuit{
	position: absolute;
	width: 30px;
	bottom: 10px;
	right: 70px;
  font-size: 25px;
  font-weight: bold;
  text-decoration: none;
  text-align: center;
  color: rgb(34, 34, 34);
}
.closeQuit:hover{
  color: rgb(199, 199, 199);
  text-decoration: none;
  cursor: pointer;
}
.closebtn {
	position: absolute;
	width: 30px;
	top: 5px;
	right: 5px;
  font-size: 25px;
  font-weight: bold;
  text-decoration: none;
  text-align: center;
  color: rgb(34, 34, 34);
}
.closebtn:hover {
  color: rgb(199, 199, 199);
  text-decoration: none;
  cursor: pointer;
}
</style>