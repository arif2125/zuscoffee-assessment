<template>
  
    <div id="loginContainer" class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
    
                    <div class="card-body">    
    
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>
    
                                <div class="col-md-6">
                                    <input v-model="user.email"  id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
                                    <div v-for="error of v$.email.$errors" :key="error.$uid" class="form-text text-danger">{{ error.$message }}</div>
                                </div>
                            </div>
    
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
    
                                <div class="col-md-6">
                                    <input v-model="user.password" id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                                    <div v-for="error of v$.password.$errors" :key="error.$uid" class="form-text text-danger">{{ error.$message }}</div>
                               
                          
                                </div>
                            </div>
    
                        
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="button" @click="submit()"  class="btn btn-primary">
                                       Login
                                    </button>
    
                              
                                </div>
                            </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    
</template>
<script setup>
import {  ref, reactive } from 'vue';
import { useStore } from 'vuex';
import Swal from 'sweetalert2';
import { useVuelidate } from '@vuelidate/core'
import { required,  helpers, email} from '@vuelidate/validators'

const store = useStore();
const user = reactive({
    email :'',
    password  :''
});


const rules = {
      email: { required :  helpers.withMessage('Email is required', required),
      email :  helpers.withMessage('Email is not valid', email)
    
      }, 
      password: { 
        required : helpers.withMessage('Password is required', required),
      }, 
    }
const v$ = useVuelidate(rules, user)

const error = ref('');
const isLoading = ref(false);

const  submit = async () => {

    isLoading.value = true;
    v$.value.$validate().then((data) => {
              return data;
    });
    error.value = '';
    
    
    await axios.get('/sanctum/csrf-cookie')
    await axios.post('/api/login', user).then(({data})=> {
            store.dispatch('login');
    }).catch(({response}) => {

    
        if(response.status === 422){
            error.value = response.data.errors;
            
            }else{

                Swal.fire({
                    title: 'Error!',
                    text: response.data.message,
                    icon: 'error'
                    })
            
            }
    }).finally(()=>{
        isLoading.value = false;
        
    })
}

</script>
<style scoped>
#loginContainer{
    margin: 0;
    position: absolute;
    top: 45%;
    left: 50%;
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    }

</style>