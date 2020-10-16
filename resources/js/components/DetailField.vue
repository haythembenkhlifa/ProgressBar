<template>
  <div style="display:flex">
    <div
      style="width:85%;background-color: aliceblue;border-radius: 15px;"
      ref="maindiv">
      <div class="skill" v-bind:style="{ width: percentage + '%' }">
        {{ percentage }}%
      </div>
    </div>
    <div style="width:15%;text-align:center">
            <p  v-bind:class="getClass()">{{percentage == 100 ? 'Done' : 'Processing'}}</p>
    </div>

  </div>
</template>

<script>
export default {
  props: ["resource", "resourceName", "resourceId", "field", "callEvery"],
  data() {
    return {
      percentage: 0,
    };
  },
  methods: {
    getPercentage() {
      axios
        .get(this.field.endPoint)
        .then((response) => {
          //return response.data;
          this.percentage = response.data;
          //alert(response.data);
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
    setPecentage() {
      setInterval(() => {
        if (this.percentage < 100) {
          this.getPercentage();
          //this.percentage++;
        }
      }, this.field.callEvery);
    },
        getClass(){
        return {
            'loading': this.percentage<100,
            'done': this.percentage == 100
        }
        },
  },
  mounted() {
    if (this.field.markAsDone) {
      this.percentage = 100;
    }
    this.setPecentage();
  },
};
</script>
<style>
p {
  font-size: 20px;
}

.container {
  background-color: rgb(192, 192, 192);
  width: 100%;
  border-radius: 15px;
}

.skill {
  background-color: rgb(116, 194, 92);
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
.loading:after {
   overflow: hidden;
   display: inline-block;
   vertical-align: bottom;
   -webkit-animation: ellipsis steps(4,end) 2000ms infinite;
   animation: ellipsis steps(4,end) 2000ms infinite;
   content: "\2026"; /* ascii code for the ellipsis character */
   width: 0px;
}
.loading{
   margin-top: 5%;
   text-align: left;
   margin-left: 19%;
}
.done{
   margin-top: 5%;
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
