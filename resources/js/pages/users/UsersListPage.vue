<template>
    <div class="container-fluid ">
        <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="pgender">Users</li>
                        <li class="breadcrumb-item active" aria-current="pgender">List</li>
                    </ol>
                </nav>
                <div class="row ">

                     
                    <EasyDataTable 
                    :theme-color="'#2196f3'" :headers="headers" :items="items" >

                    <template #item-id="{ id }">
                        <router-link class="link-primary" :to="{ path :'users/edit/' + id }">Edit</router-link>
                    </template> 
                    </EasyDataTable>
              
                </div>
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router'
import Swal from 'sweetalert2';

const store = useStore();
const router = useRouter();

const headers = [
   
      { text: "Name", value: "name"},
      { text: "Email", value: "email"},
      { text: "Phone", value: "detail.phone"},
      { text: "Age", value: "detail.age"},
      { text: "Gender", value: "detail.gender"},
      { text: "Action", value: "id"},
    ];
    
const items = ref([]);

const getUsers = async () => {

    await axios.get('/sanctum/csrf-cookie')
    await axios.get('/api/user').then(({data})=> {


  
        items.value = data.data.users;


    }).catch(({response})=>{


        if(response.status == 422){
                  Swal.fire({
                      title: 'Error!',
                      text: response.data.message,
                      icon: 'error',
                      timer: 2500,
                      showCancelButton: false,
                      showConfirmButton: false
                })
              }


        if(response.data.message == 'Unauthenticated.'){
            store.dispatch('logout')
        }
        
    }).finally(()=>{

    })
}

onMounted(() => {
    getUsers();
})

</script>

     