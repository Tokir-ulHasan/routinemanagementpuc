<template>
   <div class="container">
       <div class="card" v-if="loaded == true">
           <div class="card-body">
               <div>Course List</div>
               <div>
                    <table  id="roomTable">
                        <thead>
                            <tr>
                                <th>Course Title</th>
                                <th>Course Code</th>
                                <th>Credit</th>
                                <th v-show="sessionType ==1">Edit</th>
                                <th v-show="sessionType ==1">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="course in courses" :key="course.id">
                                <td id="roomName">{{course.course_title}}</td>
                                <td id="roomName">{{course.course_code}}</td>
                                <td id="roomName">{{course.total_credit}}</td>

                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit" v-on:click="editonmodal(course.course_title,course.id)" v-show="sessionType ==1">Edit</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit the room_no of {{course.course_title}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="input-group mb-2 mt-2">
                                                <input type="text" class="form-control form-control-sm"  v-model="e_name">
                                                <input type="text" class="form-control form-control-sm"  v-model="e_id" hidden>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" v-on:click="editroom" data-dismiss="modal">Edit</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </td>
                                <td><button v-show="sessionType ==1">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
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
              room_no : null,
              e_name:null,
              e_id:null,
              courses:[],
              msg:'dd',
              sessionType:null,
              loaded:false,
            }
        },
    methods:{
        addRoom(e){
            e.preventDefault();

            const URL = "http://127.0.0.1:8000/api/room/add";

            this.$http.post(URL,{
                room_no : this.room_no
            }).then((result)=>{
                this.listRooms();
            });


            this.room_no = "";
        },

        editonmodal(room_no,id){
          this.e_name = room_no;
          this.e_id = id;
        },
        editroom(){
            console.log(this.e_id);
            const URL = "http://127.0.0.1:8000/api/room/update/" + this.e_id;
            this.$http.put(URL,{
                e_name : this.e_name
            }).then((result)=>{
                this.listRooms();
            });
        },

        listCourse(){
            this.$http.get(' http://127.0.0.1:8000/api/routine/courses/list').then((result)=>{
            this.courses = result.data;
            this.loaded = true;
            this.$emit('CourseInfo',this.courses);

        });
        }
    },

    mounted(){
       

           this.listCourse();
           $('.toast').toast('show');

            axios.get('/api/user').then((res)=>{
                var session = res.data;
                this.sessionType = session.type;
            }).catch(()=>{
                this.sessionType = null;
            });

            setTimeout(function(){ $('#roomTable').DataTable({
                            pagingType: 'full_numbers',
                            pageLength: 5,
                            processing: true,
                            dom: 'Bfrtip',
                            buttons: ['copy', 'csv', 'print'],
                            aoColumnDefs:[  
                                { "bSortable": false, "aTargets": [ 1,2 ] }, 
                                { "bSearchable": true, "aTargets": [ 1, 2 ] }
                            ]
                        });
                    },
                1000);
    }
});
</script>
