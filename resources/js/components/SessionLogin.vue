<template>
      <div class="Login">
            <div class="container mt-2">
              <div class="row justify-content-center align-items-center text-center p-2">
                <div class="m-1 col-sm-8 col-md-6 col-lg-4 shadow-sm p-3 mb-5 bg-white border rounded">
                  <div class="pt-5 pb-5">
                    <img class="rounded mx-auto d-block" src="https://freelogovector.net/wp-content/uploads/logo-images-13/microsoft-cortana-logo-vector-73233.png" alt="" width=70px height=70px>
                    <p class="text-center text-uppercase mt-3">Login</p>
                    <form class="form text-center"   @submit="login">
                      <div class="form-group input-group-md">
                        <input type="text" class="form-control" id="text" aria-describedby="textHelp" placeholder="Enter Session" v-model="session">
                        <!--<div class="invalid-feedback">
                          Errors in text during form validation, also add .is-invalid class to the input fields
                        </div> -->
                      </div>
                      <div class="form-group input-group-md">
                        <input type="password" class="form-control" id="password" placeholder="Password" v-model="password" >
                        <!--<div class="invalid-feedback">
                          Errors in password during form validation, also add .is-invalid class to the input fields
                        </div> -->
                      </div>
                      <button class="btn btn-lg btn-block btn-primary mt-4" type="submit">
                                    Login
                          </button>
                      <a href="#" class="float-right mt-2">Forgot Password? </a>
                    </form>
                  </div>
                  <a href="#" class="text-center d-block mt-2">Create an account? </a>
                </div>
              </div>
            </div>
      </div>
</template>
<style>



</style>
<script>
export default ({
    setup() {
        
    },
     data () {
            return {
                  session:null,
                  password:null,
                  user:null,
            }
        },
    methods:{
        login(e){
            e.preventDefault();

            const URL = "/api/login";

            this.$http.post(URL,{
                session : this.session,
                password : this.password,
            }).then((result)=>{
              this.$router.push({name: "Default"});
              
            }).catch(()=>{
                  
            });


        },
    },
    mounted() {
         this.$nextTick(function () {
           axios.get('/api/athenticated').then(()=>{
             this.$router.push('/');
           }).catch(()=>{});
             
          });
    },
   
});
</script>