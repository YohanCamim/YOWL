<template>
  <div class="container_radio">
    <input
      class="cursorChange"
      type="radio"
      id="choice1"
      name="source"
      value="1"
      v-model="picked"
			:checked="picked == '1'"
      @change="changeSource"
    />
    <label class="radio cursorChange" for="choice1"> Selection</label>
    <input
      class="cursorChange"
      type="radio"
      id="choice2"
      name="source"
      value="2"
      v-model="picked"
			:checked="picked == '2'"
      @change="changeSource"
    />
    <label class="radio cursorChange" for="choice2"> Flux</label>
  </div>
</template>

<script>
import settings from "@/settings.js";
export default {
  name: "SourceRadio",
  data() {
    return {
      picked: settings.RADIO_SOURCE,
    };
  },
  methods: {
    changeSource() {
      settings.RADIO_SOURCE = this.picked;
      if (this.picked == "1") {
        this.$store.commit("setModeArticleFlux", false);
      } else {
        this.$store.commit("setModeArticleFlux", true);
      }
      this.$emit("changeSource");
    },
  },
};
</script>

<style scoped>
.container_radio {
  font-size: 20px;
  padding: 3px;
  margin: 3px;
  width: 270px;
}
.radio {
  font-family: "Lato", sans-serif;
  margin-right: 15px;
}
.cursorChange {
  cursor: pointer;
}
</style>