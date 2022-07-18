<template>
   <div class="container">
            <div class="toast d-none" data-autohide="false">
                <div class="toast-header">
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                </div>
                <div class="toast-body font-weight-bolder text-center text-white">
                 {{msg}}
                </div>
            </div>
       <div class="card">
           <div class="card-header bg-white" >
                <form  @submit="addRoom">
                    <div class="input-group mb-2 mt-2">
                        <input type="text" class="form-control form-control-sm" placeholder="ADD ROOM NO" v-model="room_no">
                        <div class="input-group-append">
                            <button type="submit" class="input-group btn-outline-primary btn-sm" >ADD</button>
                        </div>
                    </div>
                </form>
           </div>
           <div class="card-body">
               <div>room List</div>
               <div>
                    <table  id="roomTable">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="room in rooms" :key="room.id">
                                <td id="roomName">{{room.room_no}}</td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit" v-on:click="editonmodal(room.room_no,room.id)">Edit</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit the room_no of {{room.room_no}}</h5>
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
                                <td><button>Delete</button></td>
                                 
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
              room_no : null,
              e_name:null,
              e_id:null,
              rooms:[],
              msg:'dd',
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
            const URL = "http://127.0.0.1:8000/api/room/update/" + this.e_id;
            this.$http.put(URL,{
                e_name : this.e_name
            }).then((result)=>{
                this.listRooms();
            });
        },

        listRooms(){
            this.$http.get('http://127.0.0.1:8000/api/room/list').then((result)=>{
                    this.rooms = result.data;
                });
            }
    },

    mounted(){
       

           this.listRooms();
           $('.toast').toast('show');

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
