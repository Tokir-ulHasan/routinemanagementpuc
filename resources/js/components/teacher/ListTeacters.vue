<template>
   <div class="container">
       <div class="card">
           <div class="card-body">
               <div>Teachers List</div>
               <div>
                    <table  id="roomTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Short Name</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="teacher in teachers" :key="teacher.id">
                                <td>{{teacher.name}}</td>
                                <td>{{teacher.short_name}}</td>
                                <td>{{teacher.teacher_type}}</td>
                                <td>
                                  <div class="d-flex">
                                    <router-link :to="'/assigne/course/'+teacher.id" v-show="sessionType != 1"><i class="fas fa-tasks"></i></router-link>
                                    <i class="far fa-edit" v-show="sessionType == 1"></i>
                                    <i class="far fa-trash-alt" v-show="sessionType == 1"></i>
                                  </div>
                                   
                                </td>
                            </tr>
                        </tbody>
                    </table>
               </div>
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

export default ({
    setup() {
        
    },
     data () {
            return {
              teachers:[],
              sessionType:null,
            }
        },
    methods:{

        listTeacher(){
            this.$http.get(' http://127.0.0.1:8000/api/routine/teachers/list').then((result)=>{
            this.teachers = result.data;
   
            });
        }
    },

    mounted(){

      
        axios.get('/api/user').then((res)=>{
            var session = res.data;
            this.sessionType = session.type;
        }).catch(()=>{
            this.sessionType = null;
        });
         
       
           this.listTeacher();
           $('.toast').toast('show');
    }
});
</script>
