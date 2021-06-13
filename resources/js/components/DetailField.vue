<template>
  <div class="flex border-b border-40 pb-4 pt-4 -mx-6 px-6" v-show="show">
    <div
      style="width:80%;background-color: aliceblue;border-radius: 15px;"
      :style="{'background-color':this.field.barBackgroundColor ? this.field.barBackgroundColor : '#C0C0C0'}"
      ref="maindiv"
    >
      <div class="skill" v-bind:style="{ width: percentage + '%','background-color':this.field.barColor ? this.field.barColor : '#74C25C'}">
        {{ percentage }}%
      </div>
    </div>
    <div style="width:20%;text-align:left;font-weight: 700;">
      <p v-bind:class="getClass()">
        {{ getStatus() }}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  props: ["resource", "resourceName", "resourceId", "field", "callEvery"],
  data() {
    return {
      percentage: 0,
      show: true,
      status:this.field.initLabel ? this.field.initLabel:"initializing",
    };
  },
  methods: {
    getPercentage() {
      axios
        .get(this.field.endPoint)
        .then((response) => {
          //return response.data;
          this.percentage = response.data.percentage;
          this.show = response.data.show;
          //alert(response.data);
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
    setPecentage() {
      setInterval(() => {
        if (this.percentage>=0 && this.percentage < 100) {
          this.getPercentage();
          //this.percentage++;
        }


      }, this.field.callEvery);
    },
    getClass() {
      return {
        processing:this.percentage>0 && this.percentage < 100 ,
        done: this.percentage == 100,
        initializing:this.percentage == 0,
        };
    },
    getStatus()
    {
      if (this.percentage == 0) {
        return this.field.initLabel ? this.field.initLabel : "Initializing";
      }
      if(this.percentage>0 && this.percentage<100) {
        return this.field.processingLabel ? this.field.processingLabel : "Processing";
      }
      if (this.percentage == 100) {
        return  this.field.doneLabel ? this.field.doneLabel : "Done";
      }

    }
  },
  mounted() {
    if (this.field.markAsDone) {
      this.percentage = 100;
    }
    this.setPecentage();
  },
};
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
  border-radius: 15px;
  -webkit-transition: width 0.5s ease-in-out;
  -moz-transition: width 0.5s ease-in-out;
  -o-transition: width 0.5s ease-in-out;
  transition: width 0.5s ease-in-out;
}
.processing:after {
  overflow: hidden;
  display: inline-block;
  vertical-align: bottom;
  -webkit-animation: ellipsis steps(4, end) 2000ms infinite;
  animation: ellipsis steps(4, end) 2000ms infinite;
  content: "\2026"; /* ascii code for the ellipsis character */
  width: 0px;
}
.initializing:after {
  overflow: hidden;
  display: inline-block;
  vertical-align: bottom;
  -webkit-animation: ellipsis steps(4, end) 2000ms infinite;
  animation: ellipsis steps(4, end) 2000ms infinite;
  content: "\2026"; /* ascii code for the ellipsis character */
  width: 0px;
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
@keyframes ellipsis {
  to {
    width: 20px;
  }
}

@-webkit-keyframes ellipsis {
  to {
    width: 20px;
  }
}
</style>
