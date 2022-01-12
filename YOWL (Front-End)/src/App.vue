<template>
  <div>
    <router-view />
  </div>
</template>

<style>
/* BACKGROUND */
/* .wallpaper {
  top: 0;
  left: 0;
	background-color: rgb(70, 70, 70);
  /* width: 100%;
  height: 100%;
} */
/*------------------ Responsive ----------------*/
@media screen and (min-width: 320px) {
  /*------------------ Main ------------------*/
  .mainResponsive {
    width: 315px;
    margin-left: auto;
    margin-right: auto;
  }
  .hide320 {
    visibility: hidden;
  }
  .hide768 {
    visibility: hidden;
  }
  .container_title {
    right: 10px;
  }
  .searcBarAlign {
    grid-column: 2 / 4;
    grid-row: 2;
  }
}
@media screen and (min-width: 768px) {
  /*------------------ Main ------------------*/
  .mainResponsive {
    width: 750px;
  }
  .hide320 {
    visibility: visible;
  }
  .hide768 {
    visibility: hidden;
  }
  .container_title {
    right: 10px;
  }
  .searcBarAlign {
    grid-column: 3;
    grid-row: 2;
  }
}
@media screen and (min-width: 1440px) {
  /*------------------ Main ------------------*/
  .mainResponsive {
    width: 1440px;
  }
  .hide768 {
    visibility: visible;
  }
  .container_title {
    right: 140px;
  }
}
</style>
