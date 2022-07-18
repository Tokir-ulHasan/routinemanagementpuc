<template>
   <div class="container">
       <div class="card">
           <div class="card-header bg-white" >
                <form  @submit="addDay" class="row">
                     <div class="form-group col-md-8">
                        <label for="starttime">Day</label>
                        <input type="text" id="starttime" class="form-control form-control-sm"  v-model="day" required>
                    </div>

                    <div class="form-group col-md-4">
                        <button type="submit" class="form-control btn-primary mt-4 btn-sm" >ADD</button>
                    </div>
                </form>
           </div>
        
           <div class="card-footer"></div>
       </div>
   </div>
</template>
<style>
th{
    width: 35%;
}
.toast.show {
    display: inline-block;
    opacity: 1;
    z-index: 1;
    position: absolute;
    height: 120px;
    width: 309px;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}
</style>
<script>
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import "datatables.net-buttons/js/dataTables.buttons.js";
import "datatables.net-buttons/js/buttons.colVis.js";
import "datatables.net-buttons/js/buttons.flash.js";
import "datatables.net-buttons/js/buttons.html5.js";
import "datatables.net-buttons/js/buttons.print.js";
export default ({
    setup() {
        
    },
     data () {
            return {
              day : null,
              user:null,
            }
        },
    methods:{

        addDay(e){
            
            e.preventDefault();

            this.$http.post('http://127.0.0.1:8000/api/day/add',{
                day   :this.day,
            }).then((result)=>{

            });

        },

    },

    mounted(){
        
    }
});
</script>
