<template>
  <span>{{ percentage }}%</span>
</template>

<script>
export default {
  props: ['resourceName', 'field'],
  data() {
    return {
      percentage: 0,
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
    setPecentage() {
      setInterval(() => {
        if (this.percentage>=0 && this.percentage < 100) {
          this.getPercentage();
          //this.percentage++;
        }
      }, this.field.callEvery);
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
    this.setPecentage();
  },
}
</script>
