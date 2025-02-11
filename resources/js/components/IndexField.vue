<template>
  <span>{{ percentage }}%</span>
</template>

<script>
export default {
  props: ['resourceName', 'field'],
  data() {
    return {
      activeIntervals: [],
      percentage: 0,
      myInterval: null,
    };
  },
  methods: {
    getPercentage() {
      Nova.request()
        .get(this.field.endPoint)
        .then((response) => {
          //return response.data;
          this.percentage = response.data.percentage;
          //alert(response.data);
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
    setPercentage() {
      this.myInterval = setInterval(() => {
        if (this.percentage >= 0 && this.percentage < 100) {
          this.getPercentage();
          //this.percentage++;
        }
      }, this.field.callEvery);
    },
    startPulling() {

      this.stopPulling();

      let intervalId = setInterval(() => {
        if (this.percentage >= 0 && this.percentage < 100) {
          this.getPercentage();
          //this.percentage++;
        }
        if (this.percentage == 100) {
          this.stopPulling();
          if (this.field.reload && this.redirect) {
            window.location.reload(true);
            this.redirect = false;
            return;
          }
          if (this.field.redirectUrl != "" && this.redirect) {
            if (this.field.redirectNewTab == true) {
              window.open(this.field.redirectUrl, "_blank");
              this.redirect = false;
              return;
            }
            else {
              window.open(this.field.redirectUrl, "_self");
              this.redirect = false;
              return;
            }
          }
        }
      }, this.field.callEvery);

      this.activeIntervals.push(intervalId);
    },
    stopPulling() {
      this.activeIntervals.forEach(intervalId => {
        clearInterval(intervalId);
      });
      this.activeIntervals = [];
    },
    handleVisibilityAndFocus() {
      if (document.visibilityState === "hidden") {
        this.stopPulling();
      } else {
        this.startPulling();
      }
    },
  },
  computed: {
    fieldValue() {
      return this.field.displayedAs || this.field.value
    },
  },


  mounted() {
    if (this.field.markAsDone) {
      this.percentage = 100;
    }

    this.startPulling();
    // Add event listeners for visibilitychange, blur, and focus
    document.addEventListener("visibilitychange", this.handleVisibilityAndFocus);
  },
  unmounted() {
    this.stopPulling();
    document.removeEventListener("visibilitychange", this.handleVisibilityAndFocus);
  },

}
</script>
