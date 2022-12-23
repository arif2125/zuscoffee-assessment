<template>
    <apex-chart width="450" type="line" :options="options" :series="series"></apex-chart>
</template>
<script setup>
import { ref } from 'vue'
import ApexChart from 'vue3-apexcharts';

const props = defineProps({
      data: {
          type: Array,
      },
      categories: {
          type: Array,
      },
      name: {
          type: String,
      },
  })


const series = ref([{
    name: props.name,
    data: props.data
}]); 

const options  = ref({ chart: {
        height: 350,
        type: 'line',
        zoom: {
        enabled: false
        }
    },
    stroke: {
        curve: 'straight'
    },
    grid: {
        row: {
        colors: ['#f3f3f3', 'transparent'], 
        opacity: 0.5
        },
    },
    xaxis: {
        categories : props.categories,
    },
    yaxis: [
        {
            labels: {
            formatter: function(val) {
                return val.toFixed(0);
            }
            }
        }
     ]  
    }
);

</script>