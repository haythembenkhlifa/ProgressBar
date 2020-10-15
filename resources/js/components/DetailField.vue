<template>
<div style="width:100%;background-color: aliceblue;border-radius: 15px;" ref="maindiv">

            <div class="skill" v-bind:style="{ width: percentage + '%' }">
                {{percentage}}%
            </div>
</div>
</template>

<script>
export default {
    props: ["resource", "resourceName", "resourceId", "field","callEvery"],
    data() {
        return {
            percentage:0,
        }
    },
    methods: {
              getPercentage() {
                    axios.get(this.field.endPoint)
                    .then(response => {
                    //return response.data;
                   this.percentage = response.data;
                   //alert(response.data);
                    })
                    .catch(error => {
                    console.log(error.response.data);
                    });
                },
              setPecentage() {
                setInterval(() => {
                   if (this.percentage<100) {
                       this.getPercentage();
                       //this.percentage++;

                   }
                },this.field.callEvery);
            },
    },
    mounted() {
        this.setPecentage();
    },


}
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


    </style>
