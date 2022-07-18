<template>
    <div id="teachers-widnow">
            <div id="teachers-title_bar" class="clear-fix" >
                <div class="float-left pt-2">Teachers {{courseID}}</div>
            </div>
            <div id="teachers-box" > 
                <input type="text" v-model="search" placeholder="Search" style="width: 100%;"/>
                <div class="container box" 
                v-for="teacher in filterData"
                :key="teacher.id"
                draggable="true"
                @dragstart="starDrag($event,teacher)" 
                v-show="ShowTeacher(teacher.id,courseID)">
                    {{teacher.name}}

                </div>
            </div>
    </div>
</template>
<style>
#teachers-widnow{
    width: 170px;
    margin: 0 5px;
    border-radius: 5px;
}
#teachers-title_bar{
    background: #cdd5ff;
    height: 40px;
    width: 100%;
    border: 1px solid #b3aaaa;
    justify-content: center;
    padding: 0 13px;
    margin: 2px;
    font-weight: 500;
}
.box{
    background: #fff;
    border: 1px solid;    
    margin: 2px 0px;
    font-size: small;
}

#teachers-btn{
    border: solid 1px #807070;
    text-align: center;
    border-radius: 6px;
    width: 25px;
    height: 23px;
    float: right;
    cursor: pointer;
}
#teachers-box{
    height: 150px;
    background: #DFDFDF;
    overflow-y: scroll;
}

</style>
<script>

export default ({
    setup() {
        
    },
    props:['courseID'],
    data () {
        return {
            search:'',
            show:false,
            teachers : [],
            session_id:null,
            AssignedCourseList:null
        }
    },
    methods:{
        starDrag(event,teacherItem){
              event.dataTransfer.dropEffect = "move"
              event.dataTransfer.effectAllowed = "move"
              event.dataTransfer.setData("teacherID",teacherItem.id);
        },
        SessionGet:function(){
            axios.get('/api/user').then((res)=>{
                var session = res.data;
                this.session_id = session.id
                this.listAssignedCourse();
            }).catch(()=>{
                this.session_id = null;
            });
        },
        listAssignedCourse(){
            this.$http.get('http://127.0.0.1:8000/api/assigned/Course/list2/'+this.session_id).then((result)=>{
                this.AssignedCourseList = result.data;
            });
        },
        ShowTeacher(teacher_id,course_id){
            var flag = 0;
            if(this.AssignedCourseList != null && course_id != null){
                this.AssignedCourseList.forEach(asc => {
                    if(asc.teacher_id == teacher_id && asc.course_id == course_id){
                        flag = 1;
                    } 
                });
            }
            return flag;
        }
    },
     computed:{
        filterData:function(){
            return this.teachers.filter(teacher => teacher.name.includes(this.search));
        }
    },
    mounted(){
        // Teachers Pattle
        this.$http.get(' http://127.0.0.1:8000/api/routine/teachers/list').then((result)=>{
            this.teachers = result.data;
            this.$emit('TeacherInfo',this.teachers);

        });

        this.SessionGet();
    }
})
</script>
