<template>
    <div class="container-scroller">
        <!-- include:includes/navbar.vue -->
          <Navbar/>
        <!-- include -->
        <div class="container-fluid page-body-wrapper">
          <!-- include:includes/_settings-panel.html -->
            <Settings/>
          <!-- include -->
          <!-- include:includes/_sidebar.html -->
            <Sidebar/>
          <!-- include -->
          <div class="main-panel">
            <div class="content-wrapper">
               <router-view/>
            </div>
            <!-- content-wrapper ends -->
            <!-- include:includes/_footer.html -->
                <Footer/>
            <!-- include -->
          </div>
          <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div> 
</template>
<style>

</style>
<script>
   import Navbar from './includes/navbar.vue'
   import Footer from './includes/footer.vue'
   import Settings from './includes/settings-panel.vue'
   import Sidebar from './includes/sidebar.vue'
      export default {
      data(){
        return {
        }
      },
      components: { Navbar,Footer,Settings,Sidebar},
      mounted() {
              this.$nextTick(function () {
                axios.get('/api/athenticated').then(()=>{
                    
                }).catch(()=>{
                  this.$router.push('/login');
                });
              });

      }
    }
</script>
