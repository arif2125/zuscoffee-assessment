<template>
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="pgender">Create</li>
                        <li class="breadcrumb-item active" aria-current="pgender">User</li>
                    </ol>
                </nav>
    <div class="card mt-4 p-4">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Name" v-model="form.name" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div  v-for="error of v$.name.$errors" :key="error.$uid" class="form-text text-danger">{{ error.$message }}</div>
            </div>
            <div class="col-12 mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Phone" v-model="form.phone" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div  v-for="error of v$.phone.$errors" :key="error.$uid" class="form-text text-danger">{{ error.$message }}</div>

            </div>
            <div class="col-12 mb-3">
                <div class="input-group">
                    <input type="email" class="form-control" v-model="form.email" placeholder="Email" aria-label="Phone" aria-describedby="basic-addon1">
                </div>
                <div  v-for="error of v$.email.$errors" :key="error.$uid" class="form-text text-danger">{{ error.$message }}</div>

            </div>
            <div class="col-12 mb-3">
                <div class="input-group">
                    <input type="number" class="form-control" v-model="form.age" placeholder="Age" aria-label="Phone" aria-describedby="basic-addon1">
                </div>
                <div  v-for="error of v$.age.$errors" :key="error.$uid" class="form-text text-danger">{{ error.$message }}</div>

            </div>
            <div class="col-12 mb-3">
                <div class="form-check">
                    <input v-model="form.gender" class="form-check-input" value="Male" type="radio" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                      Male
                    </label>
                  </div>
                  <div class="form-check">
                    <input v-model="form.gender" class="form-check-input"  value="Female" type="radio"  id="flexCheckChecked">
                    <label class="form-check-label" for="flexCheckChecked">
                      Female
                    </label>
                  </div>
                  <div  v-for="error of v$.gender.$errors" :key="error.$uid" class="form-text text-danger">{{ error.$message }}</div>
            </div>
        
            <div class="col-12 mb-3">
                <Multiselect
                    v-model="form.roles"
                    placeholder="Select role"
                    mode="multiple"
                    :options="options"
                />
                <div v-for="error of v$.roles.$errors" :key="error.$uid" class="form-text text-danger">{{ error.$message }}</div>
            </div>

            <div class="col-12 mt-2">
                <button class="btn btn-primary" @click="submit">Submit</button>
            </div>
            
        </div>
    </div>
  

</div>
</template>
<script setup>
import Multiselect from '@vueform/multiselect'
import { ref, reactive, onMounted } from 'vue';
import { useVuelidate } from '@vuelidate/core'
import { required,  helpers, email, numeric} from '@vuelidate/validators'
import Swal from 'sweetalert2';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router'

const router = useRouter();
const store = useStore();
const form = reactive({
    name : '',
    phone : '',
    email : '',
    roles : [],
    gender : '',
    age: ''

});

const options = ref([]);
const isLoading = ref(false);

//Vuelidate
  const rules = {
      name: { required :  helpers.withMessage('Name cannot be empty', required) }, 
      phone: { 
        required : helpers.withMessage('Phone cannot be empty', required),
        numeric: helpers.withMessage('Phone should be numbers only',numeric),
      }, 
      email: { 
        required : helpers.withMessage('Email cannot be empty', required),
         email: helpers.withMessage('Email is not valid',email),
      }, 
      roles: { 
        required : helpers.withMessage('Roles cannot be empty', required),
      }, 
      age: { 
        required : helpers.withMessage('Age cannot be empty', required),
        numeric: helpers.withMessage('Age should be numbers only',numeric),
      }, 
      gender: { 
        required : helpers.withMessage('Gender cannot be empty', required),
      }, 
    }
    const v$ = useVuelidate(rules, form)



const submit = async () => {

            const isFormCorrect = await v$.value.$validate();

            if(!isFormCorrect){
                return;
            }

          await axios.get('/sanctum/csrf-cookie')
          await axios.post('/api/user/store', form).then(({data})=> {
          
            Swal.fire({
                        title: 'Success!',
                        text: 'User added!',
                        icon: 'success',
                        timer: 2500,
                        showCancelButton: false,
                        showConfirmButton: false
                   })

            setTimeout(() => {
              router.push({ name: 'list.users'});
            }, 500);

    

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
              // this.processing = false
          })

   

}

const getRoles = async () => {

            isLoading.value = true;
            await axios.get('/sanctum/csrf-cookie')
            await axios.get('/api/roles').then(({data})=> {

          
              let roles = data.data.roles;

              roles.forEach(element => {
                options.value.push({label : element.name , value : element.id});
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
    getRoles();
})


</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style>
.container-height {
    margin-top:100px !important;
  }

</style>
     