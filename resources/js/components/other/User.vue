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
                <form  @submit="addSession" class="row">
                    <div class="form-group col-6">
                        <label for="Usession">ADD Session</label>
                        <input type="text" class="form-control" id="Usession"  v-model="Usession">
                    </div>
                    <div class="form-group col-6">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password"  v-model="password">
                    </div>
                    <div class="form-group col-6 px-2">
                        <input  type="checkbox" id="activeStatus" v-model="activeStatus">Active
                    </div>
                    <div class="form-group col-6">
                        <button type="submit" class="btn btn-outline-primary">ADD</button>
                    </div>
                </form>
           </div>
           <div class="card-body">
               <div>Session List</div>
               <div>
                    <table  id="departmentTable">
                        <thead>
                            <tr>
                                <th>Session</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="session in sessions" :key="session.id">
                                <td >{{session.session}}</td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit" v-on:click="editonmodal(session.session,session.id)">Edit</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit the Session of {{e_session}}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="input-group mb-2 mt-2">
                                                <input type="text" class="form-control form-control-sm"  v-model="e_session">
                                                <input type="text" class="form-control form-control-sm"  v-model="e_id" hidden>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" v-on:click="editSession" data-dismiss="modal">Edit</button>
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
              Usession : null,
              password:null,
              activeStatus:false,
              status:0,
              sessions:[],
              msg:null,
              e_session:null,
              e_id:null,
            }
        },
    methods:{

        
        addSession(e){
            e.preventDefault();

            if(this.activeStatus == true){
                this.status = 1;
            }
            if(this.activeStatus == false){
                this.status = 0;
            }

            const URL = "http://127.0.0.1:8000/api/session/add";

            this.$http.post(URL,{
                session : this.Usession,
                password : this.password,
                status : this.status,
                type:0,
            }).then((result)=>{
                this.listSession();
            });


            this.Usession = "";
            this.password = "";
            this.activeStatus = false;

        },

        editonmodal(session,id){
          this.e_session = session;
          this.e_id = id;
        },
        editSession(){
            console.log(this.e_id);
            const URL = "http://127.0.0.1:8000/api/session/update/" + this.e_id;
            this.$http.put(URL,{
                e_session : this.e_session
            }).then((result)=>{
                this.listSession();
            });
        },

        listSession(){
            this.$http.get('http://127.0.0.1:8000/api/session/list').then((result)=>{
                    this.sessions = result.data;
                });
            }
    },

    mounted(){
       

           this.listSession();
           $('.toast').toast('show');

            setTimeout(function(){ $('#departmentTable').DataTable({
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
