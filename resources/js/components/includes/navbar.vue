<template>
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <h3 class="brand-name">PUCR</h3>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize" data-terget="#sidebar">
             <span class="icon-menu"></span>
        </button>
       
        <ul class="navbar-nav navbar-nav-right">
       
        <li class="nav-item nav-profile dropdown">
             <a class="dropdown-item" v-on:click="logout()">
              <i class="fas fa-sign-out-alt t-00c0f"></i>
                    {{ user.session }}
            </a>
        </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="icon-menu"></span>
        </button>
    </div>
    </nav>
</template>
<style scoped>

</style>
<script>
    export default {
        data(){
         return {
             user:[],

         }
        },
        mounted() {
            axios.get('/api/user').then((res)=>{
            this.user = res.data;
            }).catch(()=>{
            this.user = null;
            });
        },
        methods:{
            logout:function(){
                this.$http.get('/api/logout').then((result)=>{
                    this.$router.push({path: "/login"});
                });
            }
        },

    }
</script>
