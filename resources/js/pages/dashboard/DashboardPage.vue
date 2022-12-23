<template>
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="pgender">Dashboard</li>
            </ol>
        </nav>
    <div class="row">
        <div class="col-md-6 col-12 layout-spacing  p-4">
            <div class="widget widget-sales-category">
                <div class="widget-heading">
                    <h6>Staff by Gender</h6>
                </div>
                <div class="widget-content">
                    <Donut :key="data_gender" :labels="labels" :data="data_gender" :colors="['#fcb019', '#37e396']" ></Donut>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12 layout-spacing  p-4">
            <div class="widget widget-sales-category">
                <div class="widget-heading">
                    <h6>Staff by Age</h6>
                </div>
                <div class="widget-content">
                    <Line :key="data_age" name="age" :data="data_age" :categories="categories" ></Line>
                </div>
            </div>
        </div> 
        <hr class="divider">

        <div class="col-12 layout-spacing  p-4">
            <div class="widget widget-sales-category">
                <div class="widget-heading">
                    <h6>Place API</h6>
                </div>
                <div class="widget-content">
                    <ul>
                        <li> City : {{ place.city }}</li>
                        <li> Country : {{ place.country }}</li>
                        <li> Timezone : {{ place.timezone }} </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

</template>
<script setup>

import { ref, onMounted } from 'vue';
import { useStore } from 'vuex'
import Line from '../../components/Line.vue'
import Donut from '../../components/Donut.vue'


const store = useStore();
const isLoading = ref(false);
const fullPage = ref(true);


const data_age = ref([]);
const data_gender = ref([]);
const categories = ref([]);
const labels = ref([]);
const IP = ref('');
const place = ref([]);


const getIP = async () => {

    await axios.get('https://ipinfo.io/ip').then(({data})=> {

    IP.value = data;
    }).catch(({response})=>{

    }).finally(()=>{
        getPlace();
    })
}


const getPlace = async () => {

    axios.defaults.headers.post['Content-Type'] ='application/x-www-form-urlencoded';
    await axios.get('https://ipinfo.io/'+ IP.value +'/geo').then(({data})=> {

    place.value = data;
    }).catch(({response})=>{

    }).finally(()=>{
    
    })

}


const getAge = async () => {
            isLoading.value = true;
            
            axios.defaults.headers.post['Content-Type'] ='application/x-www-form-urlencoded';
            await axios.get('/sanctum/csrf-cookie')
            await axios.get('/api/dashboard/age').then(({data})=> {

               
                data_age.value = [];
                categories.value = [];
                const keys = Object.keys(data.data);
                keys.forEach((key, index) => {
                    data_age.value.push(data.data[key]);
                    categories.value.push(key);
                });


            }).catch(({response})=>{


                if(response.data.message == 'Unauthenticated.'){
                    store.dispatch('logout')
                }
                
            }).finally(()=>{
              
                isLoading.value = false;
            })
    }


    const getGender = async () => {
            isLoading.value = true;
            await axios.get('/sanctum/csrf-cookie')
            await axios.get('/api/dashboard/gender').then(({data})=> {

          
                data_gender.value = [];
                labels.value = [];
                const keys = Object.keys(data.data);
                keys.forEach((key, index) => {
                    data_gender.value.push(data.data[key]);
                    labels.value.push(key);
                });



            }).catch(({response})=>{


                if(response.data.message == 'Unauthenticated.'){
                    store.dispatch('logout')
                }
                
            }).finally(()=>{
              
                isLoading.value = false;
            })
    }

    onMounted(() => {
        getAge();
        getGender();
        getIP();
    })


</script>
<style styled>
.divider {
    border : 1px solid lightblue;
    width: 100% !important;
}
</style>
     