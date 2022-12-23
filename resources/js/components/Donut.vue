<template>
    <apex-chart width="450" type="donut" :options="options" :series="series"></apex-chart>
</template>
<script setup>
import { ref } from 'vue';
import ApexChart from 'vue3-apexcharts';

const props = defineProps({
      data: {
          type: Array,
      },
      labels: {
          type: Array,
      },
      colors: {
          type: Array,
      },
  })

const series= ref(props.data);
const options = ref({
    labels: props.labels,
    colors: props.colors
})









</script>