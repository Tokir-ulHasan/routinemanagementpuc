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
                <form  @submit="addDepartment">
                    <div class="input-group mb-2 mt-2">
                        <input type="text" class="form-control form-control-sm" placeholder="ADD DEPARTMENT NAME" v-model="name">
                        <div class="input-group-append">
                            <button type="submit" class="input-group btn-outline-primary btn-sm" >ADD</button>
                        </div>
                    </div>
                </form>
           </div>
           <div class="card-body">
               <div>Department List</div>
               <div>
                    <table  id="departmentTable">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="department in departments" :key="department.id">
                                <td id="departmentName">{{department.name}}</td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit" v-on:click="editonmodal(department.name,department.id)">Edit</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit the name of {{department.name}}</h5>
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
                                            <button type="button" class="btn btn-primary" v-on:click="editDepartment" data-dismiss="modal">Edit</button>
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
              name : null,
              e_name:null,
              e_id:null,
              departments:[],
              msg:'dd',
            }
        },
    methods:{
        addDepartment(e){
            e.preventDefault();

            const URL = "http://127.0.0.1:8000/api/department/add";

            this.$http.post(URL,{
                name : this.name
            }).then((result)=>{
                this.listDepatment();
            });


            this.name = "";
        },

        editonmodal(name,id){
          this.e_name = name;
          this.e_id = id;
        },
        editDepartment(){
            const URL = "http://127.0.0.1:8000/api/department/update/" + this.e_id;
            this.$http.put(URL,{
                e_name : this.e_name
            }).then((result)=>{
                this.listDepatment();
            });
        },

        listDepatment(){
            this.$http.get('http://127.0.0.1:8000/api/department/list').then((result)=>{
                    this.departments = result.data;
                });
            }
    },

    mounted(){
       

           this.listDepatment();
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
