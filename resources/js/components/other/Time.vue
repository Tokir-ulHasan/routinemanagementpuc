<template>
   <div class="container">
       <div class="card" v-if="loaded == true">
           <div class="card-header bg-white" v-show="t_add == 0">
                <form  @submit="addTime" class="row">
                     <div class="form-group col-md-3">
                        <label for="starttime">Start Time</label>
                        <input type="time" id="starttime" class="form-control form-control-sm"  v-model="start_time" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="endtime">End Time</label>
                        <input type="time"  id="endtime" class="form-control form-control-sm" v-model="end_time" required>
                    </div>
                     <div class="form-group col-md-3">
                        <label for="intervaltime">Interval Time</label>
                        <select v-model="interval_Time" id="intervaltime" class="form-control form-control-sm" >
                            <option value="00:30" selected>30 min</option>
                            <option value="01:00">1 Hour</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <button type="submit" class="form-control btn-primary mt-4 btn-sm" >ADD</button>
                    </div>
                </form>
           </div>
           <div class="card-body " v-show="t_add == 1">
                <div>
                    <h1 class="text-center ">Times</h1>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-2 time-style" v-for="time in times" :key="time.id">
                        {{time.time}}
                    </div>
                </div>
            
           </div>
           <div class="card-footer"></div>
       </div>
       <loading v-if="loaded == false"/>
   </div>
</template> 
<style>
th{
    width: 35%;
}
.time-style{
    border: 1px solid #dcd8d8;
    text-align: center;
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
import loading from '../loading.vue'

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
    components: {loading},
     data () {
            return {
              start_time : null,
              end_time:null,
              interval_Time:null,
              session_id:null,
              times:[],
              t_add:0,
              loaded:false,
            }
        },
    methods:{

        addTime(e){
            
            e.preventDefault();

            this.$http.post('http://127.0.0.1:8000/api/time/add',{
                start_time   :this.start_time,
                end_time     :this.end_time,
                interval_time:this.interval_Time,
                session_id   :this.session_id.id,
            }).then((result)=>{
              this.timesList();
            });

        },

        timesList(){
            
            axios.get('http://127.0.0.1:8000/api/time/list/'+this.session_id.id).then((res)=>{
                this.times = res.data;
                if(this.times.length > 0){
                    this.t_add = 1;
                    this.loaded = true;
                }
                }).catch(()=>{
                    this.times = null;
            });
        },
    },

    mounted(){
       
        axios.get('/api/user').then((res)=>{
            this.session_id = res.data;
            this.timesList();
            }).catch(()=>{
                this.session_id = null;
        });
    }
});
</script>
