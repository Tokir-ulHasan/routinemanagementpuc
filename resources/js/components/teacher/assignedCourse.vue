<template>
    <div class="card">
        <div class="card-head text-center pt-4">
             {{T_name}}
        </div>
        <div class="card-body">
            <table class="table" id="assignedtbl">
                <thead>
                    <tr>
                        <th>Course Title</th>
                        <th>Course Code</th>
                        <th>Total Credit</th>
                        <th>Aissgned Course</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="course in courses" :key="course.id">
                        <td>{{course.course_title}}</td>
                        <td>{{course.course_code}}</td>
                        <td>{{course.total_credit}}</td>
                        <td>
                            <input type="checkbox" :value="course.id" v-on:input="appendValue($event)"  :checked="check(course.id)" >
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<style >

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
                id:null,
                courses:null,
                teachers:null,
                teacher:null,
                coursesAssign:[],
                T_name:null,
                session_id:null,
                AssignedCourseList:null
            }
        },
    methods:{
        SessionGet:function(){
            axios.get('/api/user').then((res)=>{
                var session = res.data;
                this.session_id = session.id
                 this.listAssignedCourse();
            }).catch(()=>{
                this.session_id = null;
            });
        },
        listCourse(){
            this.$http.get(' http://127.0.0.1:8000/api/routine/courses/list').then((result)=>{
                this.courses = result.data;
            });
        },
        listTeacher(){
            this.$http.get(' http://127.0.0.1:8000/api/routine/teachers/list').then((result)=>{
                this.teachers = result.data;
                this.teacher = this.searchDataByID(this.teachers,parseInt(this.id));
                this.T_name = this.teacher.name;
            });
        },
        searchDataByID(obj,val){
                var index = obj.findIndex(e => e.id === val);
                if (index !== -1) {
                    return obj[index];
                }
        },
        listAssignedCourse(){
            this.$http.get('http://127.0.0.1:8000/api/assigned/Course/list/'+this.id+'/'+this.session_id).then((result)=>{
                this.AssignedCourseList = result.data;
            });
        },

        appendValue(e){
            var val = e.target.value;
            if(e.target.checked == true){
                const URL = "http://127.0.0.1:8000/api/assigned/Course";
                this.$http.post(URL,{
                    session_id : this.session_id,
                    teacher_id : this.teacher.id,
                    course_id : val,
                
                }).then((result)=>{
                    
                });
            }
            else{
                if(this.AssignedCourseList != null){
                    const index = this.AssignedCourseList.findIndex(asc => asc.course_id == val)
                    if (index > -1) {
                        const URL = "http://127.0.0.1:8000/api/delete/assigned/Course/"+this.AssignedCourseList[index].id;
                        this.$http.delete(URL).then((result)=>{
                        });
                    }
                }
            }
        },
        check(courseID){
            if(this.AssignedCourseList != null){
                const index = this.AssignedCourseList.findIndex(asc => asc.course_id == courseID)
                if (index > -1) {
                    return "checked"
                }
                else{
                    return ""
                }
            }
        }

    
      
    },
    computed:{
  
    },

    mounted(){
       
        this.id = this.$route.params.teacher_id;
        this.listCourse();
        this.listTeacher();
        this.SessionGet();
      
        setTimeout(function(){ $('#assignedtbl').DataTable({
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

