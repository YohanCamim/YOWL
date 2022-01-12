<template>
  <div class="container_menu">
    <Logo class="logoAlign" />
    <div class="title">Login</div>
  </div>
  <div class="container_area">
    <div class="container_content">
			<div class="closebtn" @mousedown="close">×</div>
      <div class="space">
        <div class="label">Email</div>
        <input
          class="input boxsizingBorder"
          type="text"
          name="email"
          v-model="email"
        />
      </div>
      <div class="space">
        <div class="label">Mot de passe</div>
        <input
          class="input boxsizingBorder"
          type="password"
          name="password"
          v-model="password"
        />
      </div>
      <div class="errorFormat">{{ error }}</div>
			<div class="alignFooter">
				<button class="buttonFormat" type="button" @click="login()">
					Connect
				</button>
				<button class="buttonFormat" type="button" @click="register()">
					Register
				</button>
				<!-- <router-link to="/signup" class="registerAlign">Register</router-link> -->
			</div>
    </div>
  </div>
</template>

<script>
import settings from "@/settings.js";
import Logo from "@/components/widget/Logo";
export default {
  name: "Login",
  data() {
    return {
      email: "", // email
      password: "", // password
      error: "",
      isConnected: false,
    };
  },
  components: {
    Logo,
  },
  methods: {
    login() {
      if (this.email != "" && this.password != "") {
        fetch(settings.SERVICE_URI + "login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            accept: "application/json",
          },
          body: JSON.stringify({ email: this.email, password: this.password }),
        }).then((res) => {
          res.json().then((data) => {
            if (data.token) {
              this.error = "";
              this.isConnected = true;
              this.$store.commit("setToken", data.token);
              this.$store.commit("setUsername", data.user.name);
              this.$store.commit("setUserId", data.user.id);
              this.$router.push("/");
            } else {
              this.error = "L'email ou le mot de passe est incorrect";
            }
          });
        });
      } else {
        this.error = "Un email et un mot de passe doit être présent";
      }
    },
		register(){
			this.$router.push("/signup");
		},
		close(){
			this.$router.push("/");
		}
  },
};
</script>

<style scoped>
/********************************
		CONTAINERS
*********************************/
.container_area {
  width: 100%;
  height: 100%;
  display: flex;
  flex-flow: row;
  justify-content: center;
}
.container_content {
	position: relative;
  margin-top: 50px;
  width: 280px;
  height: 320px;
  padding: 20px;
  background: rgb(138, 138, 138);
  box-shadow: 0px 0px 20px black;

  display: flex;
  flex-flow: column;
  justify-content: space-around;
}
/********************************
		BUTTON
*********************************/
.buttonFormat {
  width: 100%;
  font-size: 20px;
  padding: 10px 3px;
  color: rgb(34, 34, 34);
	margin-top: 10px;
  border: 1px solid;
  background: none;
  cursor: pointer;
}
.buttonFormat:hover {
  background: rgb(199, 199, 199);
}
.closebtn {
	position: absolute;
	width: 30px;
	top: 5px;
	right: 5px;
  font-size: 35px;
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
/********************************
		INPUT
*********************************/
.input {
  width: 100%;
  font-size: 20px;
  padding: 4px;
  color: rgb(34, 34, 34);
  border: none;
  border-bottom: 2px solid white;
  background: none;
}
.input:focus {
  outline: none;
  border: none;
  background: white;
}
.label {
  font-size: 20px;
  padding: 3px;
  text-align: center;
  color: rgb(34, 34, 34);
}
.boxsizingBorder {
  -webkit-box-sizing: border-box; /* chrome, safari */
  -moz-box-sizing: border-box; /* firefox */
  box-sizing: border-box;
}
.errorFormat {
  color: rgb(145, 32, 32);
}
.space {
  margin-bottom: 15px;
}
.alignFooter{
	justify-self: flex-end;
}
.errorFormat {
	height: 50px;
  color: rgb(145, 32, 32);
}
/********************************
		NAV
*********************************/
.container_menu {
  position: relative;
  width: 100%;
  display: grid;
  grid-template-columns: 120px 1fr;
  background: rgb(138, 138, 138);
  margin-bottom: 5px;
  padding: 5px 10px;
}
.logoAlign {
  grid-column: 1;
  grid-row: 1 / 3;
}
.title {
  font-size: 30px;
  text-align: center;
  margin-top: 50px;
  margin-right: 140px;
  color: rgb(34, 34, 34);
}
</style>