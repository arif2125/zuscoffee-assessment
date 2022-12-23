<template>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0" style="background-color:#2b3a7e !important;">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
               
                        <span class="fs-5 d-none d-sm-inline mt-2">ZusCoffee Staff</span>
                    <hr class="horizontal-line">
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start list-unstyled" id="menu">
                        <li>
                            <router-link  class="nav-link px-0 align-middle text-light list p-2" :to="{ name : 'dashboard' }">
                                Dashboard
                            </router-link>
                        </li>
                        <li>  
                            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle list text-light p-2">
                               Users</a>
                            <ul class="collapse show nav flex-column ms-1 p-2" id="submenu1" data-bs-parent="#menu">
                                <li>
                                    <router-link class="nav-link px-0 align-middle text-light list p-2" :to="{ name : 'list.users' }">
                                        List
                                    </router-link>
                                </li>
                                <li>
                                    <router-link class="nav-link px-0 align-middle text-light list p-2" :to="{ name : 'create.users' }">
                                        Create
                                    </router-link>
                                </li>
                               
                            </ul>
                        </li>
                       
                    </ul>
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <a class="dropdown-item" href="javascript:void(0)" @click="store.dispatch('logout');">Sign out</a>
                   
                        </a>
                  
                    </div>
         
                </div>
            </div>
            <div class="col py-3">
                <slot></slot>
            </div>
        </div>
    </div>
</template>
<script setup>
import { useStore } from 'vuex';
const store = useStore();


</script>
<style styled>

.list {
    text-decoration: none !important;
}

a.router-link-exact-active{
   
    text-decoration: underline !important;
    text-decoration-color: #1673b0 !important;
    text-underline-position: under !important;
}



.horizontal-line {
    border : 1px ridge white;
    min-width: 100px;
}
</style>
     