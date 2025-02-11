<template>
  <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText" :full-width-content="fullWidthContent">
    <template #field>


      <div v-if="!this.field.showProgressBarInForms" class="h-full">
        <h1 class="mt-1">{{ percentage }}%</h1>
      </div>

      <div v-else class="flex border-40 -mx-6 px-6 mt-1" v-show="show">
        <div style="position:relative;width:100%;background-color: aliceblue;border-radius: 10px;"
          :style="{ 'background-color': this.field.barBackgroundColor ? this.field.barBackgroundColor : '#C0C0C0' }"
          ref="maindiv">
          <div class="skill"
            v-bind:style="{ width: percentage + '%', 'background-color': this.field.barColor ? this.field.barColor : '#74C25C' }">

          </div>
          <span class="text-lg flex flex-row overflow-x-scroll"
            :style="{ 'color': this.field.textColor ? this.field.textColor : 'white' }"
            style="position: absolute;top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="w-12"
              v-show="(this.percentage > 0 && this.percentage < 100 && this.field.animation) || (this.percentage == 0 && this.field.animation)">
            </div>
            {{ getStatus() }}
            <div class="w-12"
              v-show="(this.percentage > 0 && this.percentage < 100 && this.field.animation) || (this.percentage == 0 && this.field.animation)">
              <h1 class="loading"></h1>
            </div>
          </span>
          <span class="md:text-lg" :style="{ 'color': this.field.textColor ? this.field.textColor : 'white' }"
            style="position: absolute;top: 50%; right: 0%; transform: translate(-50%, -50%);">{{ percentage }}%</span>
        </div>
      </div>
    </template>
  </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data() {
    return {
      activeIntervals: [],
      pull: true,
      percentage: 0,
      show: true,
      status: this.field.initLabel ? this.field.initLabel : "initializing",
      redirect: false,
    };
  },
  methods: {
    getPercentage() {
      Nova.request()
        .get(this.field.endPoint)
        .then((response) => {
          this.percentage = response.data.percentage;
          this.show = response.data.show;
          if (this.percentage !== 100) {
            this.redirect = true;
          }
          //alert(response.data);
        })
        .catch((error) => {
          console.log(error.response.data);
        });
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
    getClass() {
      return {
        processing: this.percentage > 0 && this.percentage < 100,
        done: this.percentage == 100,
        initializing: this.percentage == 0,
        loading: (this.percentage > 0 && this.percentage < 100 && this.field.animation) || (this.percentage == 0 && this.field.animation),
      };
    },
    getStatus() {
      if (this.percentage == 0) {
        return this.field.initLabel ? this.field.initLabel : "Initializing";
      }
      if (this.percentage > 0 && this.percentage < 100) {
        return this.field.processingLabel ? this.field.processingLabel : "Processing";
      }
      if (this.percentage == 100) {
        return this.field.doneLabel ? this.field.doneLabel : "Done";
      }
    }
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

<style scoped>
p {
  font-size: 20px;
}

.skill {
  color: black;
  padding: 1%;
  text-align: right;
  font-size: 20px;
  height: 30px;
  border-radius: 10px;
  -webkit-transition: width 0.5s ease-in-out;
  -moz-transition: width 0.5s ease-in-out;
  -o-transition: width 0.5s ease-in-out;
  transition: width 0.5s ease-in-out;
}

.processing {
  margin-top: 4%;
  text-align: left;
  margin-left: 19%;
}

.done {
  margin-top: 4%;
  text-align: left;
  margin-left: 19%;
}

.initializing {
  margin-top: 4%;
  text-align: left;
  margin-left: 19%;
}

.statussection {
  width: 20%;
  text-align: left;
  font-weight: 700;
  overflow-y: hidden;
  overflow-x: scroll;
}

::-webkit-scrollbar {
  height: 2px;
}

Track::-webkit-scrollbar-track {
  background: white;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: gray;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: gray;
}

.loading:after {
  overflow: hidden;
  display: inline-block;
  vertical-align: bottom;
  -webkit-animation: ellipsis steps(10, end) 2000ms infinite;
  animation: ellipsis steps(10, end) 2000ms infinite;
  content: "\2026";
  /* ascii code for the ellipsis character */
  width: 0px;
}

@keyframes ellipsis {
  to {
    width: 40px;
  }
}

@-webkit-keyframes ellipsis {
  to {
    width: 40px;
  }
}
</style>
