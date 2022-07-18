<template>
    <div class="card" >
        <div id="card-body" v-if="loaded == true">
            <div class="report">
                <div class="report-body d-flex">
                    <i type="button" class="fas fa-eye float-left " v-on:click="ReportGen()"></i>
                    <pdf class="float-right" id="pdf" :days="days" :times="times" :sections="sections" :teachers="teachers" :rooms="rooms" :routines="routines" :courses="courses" :session="user" v-if="view == 1"/>
                </div>
            </div>
            <div class="row routineCreateBox" v-if="view == 0">
                <div class="col-8" >
                    <div class="drop row" >
                        <div class="col-6 dropbox" type="button" id="daydrop" v-on:click="ActiveSegment('#daypattle','#daydrop')" @drop.prevent="onDrop($event)"  @dragover.prevent>
                            <h4 v-if="day != null">{{day.day}}</h4>
                            <h4 v-if="day == null">Drop The Day</h4>
                            <span v-if="day == null">+</span>
                        </div>

                        <div :class="warning_time == 0 ? 'col-6 dropbox': 'col-6 dropbox bg-red'" type="button" id="timedrop" v-on:click="ActiveSegment('#timepattle','#timedrop')" @drop.prevent="onDrop($event)"  @dragover.prevent>
                            <h4   v-if="start_time != null && warning_time == 0">Start Time-{{start_time.time}} <br>End Time-{{end_time.time}}</h4>
                            <h4    v-if="warning_time == 1">{{ msg_time }}</h4>
                            <h4   v-if="start_time == null && warning_time != 1">Drop The Time</h4>
                            <span v-if="start_time == null && warning_time != 1">+</span>
                        </div>
                        <div class="col-6 dropbox" type="button" id="sectiondrop" v-on:click="ActiveSegment('#sectionpattle','#sectiondrop')" @drop.prevent="onDrop($event)"  @dragover.prevent>
                            <h4 v-if="section != null">{{ section.section }}</h4>
                            <h4 v-if="section == null">Drop The Section</h4>
                            <span v-if="section == null">+</span>
                        </div>
                        <div :class="warning_T == 0 ? 'col-6 dropbox': 'col-6 dropbox bg-red'" type="button" id="teacherdrop" v-on:click="ActiveSegment('#teacherpattle','#teacherdrop')" @drop.prevent="onDrop($event)"  @dragover.prevent>
                            <h4 v-if="teacher != null && warning_T == 0">{{teacher.short_name}}</h4>
                            <h4 v-if="warning_T == 1">{{ msg_T }}</h4>
                            <h4 v-if="teacher == null && warning_T != 1">Drop The Teacher</h4>
                            <span v-if="teacher == null && warning_T != 1">+</span>
                        </div>
                        <div :class="warning_course == 0 ? 'col-6 dropbox': 'col-6 dropbox bg-red'" type="button" id="coursedrop" v-on:click="ActiveSegment('#coursepattle','#coursedrop')" @drop.prevent="onDrop($event)"  @dragover.prevent>
                            <h4 v-if="course != null && warning_course == 0">{{course.course_code}}</h4>
                            <h4 v-if="warning_course == 1">{{ msg_course }}</h4>
                            <h4 v-if="course == null && warning_course == 0">Drop The Course</h4>
                            <span v-if="course == null && warning_course == 0">+</span>
                        </div>

                        <div :class="warning_R == 0 ? 'col-6 dropbox': 'col-6 dropbox bg-red'" type="button" id="roomdrop" v-on:click="ActiveSegment('#roompattle','#roomdrop')" @drop.prevent="onDrop($event)"  @dragover.prevent>
                            <h4 v-if="room != null && warning_R == 0">{{room.room_no}}</h4>
                            <h4 v-if="warning_R == 1 && room == null">{{ msg_R }}</h4>
                            <h4 v-if="room == null && warning_R != 1">Drop The Room</h4>
                            <span v-if="room == null && warning_R != 1">+</span>
                        </div>
                    </div>
                </div>
                <div class="col-4" >
                    <div class="pattle row">
                        <Days     class="col-12 pattlebox d-none" id="daypattle"     @DayInfo="dayData"/> 
                        <Times    class="col-12 pattlebox d-none" id='timepattle'    @TimeInfo="timeData"/> 
                        <Sections class="col-12 pattlebox d-none" id='sectionpattle' @SectionInfo="sectionData" /> 
                        <Teachers class="col-12 pattlebox d-none" id='teacherpattle' :courseID="CourseID" @TeacherInfo="teacherData"/>
                        <Courses  class="col-12 pattlebox d-none" id='coursepattle' :semister="semister" @CourseInfo="courseData"/>
                        <Rooms    class="col-12 pattlebox d-none" id='roompattle'    @RoomInfo="roomData"/>
                    </div>
                </div>
                <button style="width: 100%;" class="btn btn-primary mt-2"  v-on:click="addtoroutine()" v-show="day != null && section != null && teacher != null && room != null && course != null && start_time != null && edit_status == 0">ADD TO ROUTINE</button>
                <button style="width: 100%;" class="btn btn-success mt-2"  v-on:click="EditToRoutine()" v-show="day != null && section != null && teacher != null && room != null && course != null && start_time != null && edit_status == 1">Edit  ROUTINE</button>
            </div>
            <div class="r-list  grid-margin stretch-card" >
                <div class="card">
                    <div class="card-body">
                        <!--// Del Modal -->
                        <div class="modal fade" id="del" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header ">
                                <h5 class="modal-title text-danger" id="exampleModalLabel">Delete Warning</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h5 class="text-danger">Are You Sure To Delete </h5>
                                <p class="text-light bg-dark">
                                    {{del_day}}/{{del_section}}/{{del_course}}/{{del_stratTime}}/{{del_endTime}}/{{del_teacher}}//{{del_room}}
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-outline-danger" v-on:click="deleteToRoutine()" data-dismiss="modal">Delete</button>
                            </div>
                            </div>
                        </div>
                        </div>
                        <!-- Del //-->
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="false" >
                            <div class="carousel-inner">
                                <div :class=" day.day == 'Saturday' ? 'carousel-item active': 'carousel-item'" v-for="day in days" :key="day.id" >
                                    <div class="card">
                                        <div class="card-body" ref="routines">
                                            <h4 class="card-title">{{ day.day }}</h4>
                                            <div class="table-responsive pt-3">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr class="table-head">
                                                        <th>
                                                            Sem
                                                        </th>
                                                        <th v-for="(time,timeIndex) in times" :key="timeIndex" v-show="timeIndex+1 <countLenght(times)">
                                                            <span >{{ time.time }}</span>
                                                            <br>
                                                            <span v-if="timeIndex+1 <countLenght(times)">{{ times[timeIndex+1].time }}</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tbl-body">
                                                    <tr class="table-body" v-for="section in sections" :key="section.id" >
                                                        <th >
                                                            {{ section.section }}
                                                        </th>
                                                        <th v-for="time in showR(section.section,day.day,times)" :key="time.id" :colspan="colspan(day.day,section.section,time)" class="text-center" style="position:relative">
                                                            <div class="tooltipe" v-show="colspan(day.day,section.section,time) != 0 " v-if="view == 0">
                                                                <i class="far fa-edit btn edit" v-on:click="editSlod(day.day,section.section,time)" ></i>
                                                            
                                                                <i type="button" class="far fa-trash-alt btn-outline-primary" data-toggle="modal" data-target="#del" v-on:click="deleteModel(day.day,section.section,time)" ></i>
                                                                
                                                            </div>
                                                            {{ showInfo(day.day,section.section,time)}}
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
        <loading v-if="loaded == false"/>
    </div>
</template>
<style>

.pattle{
    font-family: 'Courier New', Courier, monospace;
}

.bg-red{
    background: rgb(241, 111, 111);
}

.edit , .delete{
    margin: 2px;
    padding: 0;
}
.tooltipe{
    
    position: absolute;
    right: 0;
    top: 0;
    margin: 2px;
    border: 1px solid #c4bebe;
    background: #f4f4f4;

}

.delete-box{
    border-radius: 0px;
    background: #ffff;
    padding: 15px;
}
.delete-box .card-head{
    background: red;
    padding: 6px;
    color: #fff;
    font-size: large;
    font-family: cursive;
    text-align: center;
}
.delete-box .card-body{
    padding: 35px;
    text-align: center;
    font-family: cursive;
    font-size: large;
}


/*  */

.routineCreateBox{
    margin: 14px;
    margin-top: 32px;
    border: 1px solid #057dbe3b;
    height: 200px;
    box-shadow: -1px 0px 14px 1px #eeeff08f;
}
.dropbox{
    border: 1px solid #d4c5c5;
    padding: 5px;
    height: 66px;
}
.pattlebox{
    height: 200px;
    width: 100%;
    padding: 5px;


    
}
.dropbox h4{
    text-align: center;
    

}
.dropbox span{
    display: flex;
    justify-content: center;
    font-size: 20px;
    font-weight: bold;
}

.bg-lightblue{
    background: #cdd5ff;
}
.addbtn{
    height: 200px;
    border-radius:0px ;
    float: right;
}
.addbtn h6{
    display: flex;
    justify-content: center;
    position: relative;
    top: 50%;
    transform: translateY(-50%);
}
.r-list{
    margin-top:80px;
}
.carousel-control-prev-icon,.carousel-control-next-icon{
    background-image: none;


}
.carousel-control-prev,.carousel-control-next{
    top: 1.3rem;
    width: 1.875rem;
    height: 1.875rem;
    background: #ecedf2;
    border-radius: 0.375rem;
    opacity: 1;
    right: 1.2rem;
}

.carousel-control-prev {
    left: auto;
    right: 4rem;
}
.carousel-control-prev:after {
    font-family: "themify";
    content: '\e64a';
    font-size: .875rem;
    color: #6c7383;
    line-height: 1.875rem;
    margin-right: 0.40rem;
}
.carousel-control-next:after {
    font-family: "themify";
    content: '\e649';
    font-size: .875rem;
    color: #6c7383;
    line-height: 1.875rem;
    margin-right: 0.40rem;
}
.report{
    position: relative;
    height: 40px;
    margin: 5px 0;
}
.report-body{
    position: absolute;
    right: 15px;
    margin: 6px 0;
    font-size: 30px;
}

</style>
<script>
import loading from '../loading.vue'

import pdf from '../other/pdf.vue'

import Rooms from '../other/Rooms_Pattle'
import Teachers from '../other/Teachers_Pattle.vue'
import Courses from '../other/Courses_Pattle.vue'
import Days from '../other/Day_Pattle.vue'
import Times from '../other/Time_Pattle.vue'
import Sections from '../other/Section_Pattle.vue'
    export default {
        
        components: {Rooms,Teachers,Courses,Days,Times,Sections,loading,pdf},

        data () {
             return {
                view:0,
                loaded:false,
                session:null,
                day:null,
                days:null, // day list
                start_time:null,
                remaning_credit:null,
                end_time:null,
                times:null, // times list
                semister:null,
                section:null,
                sections:null, // sections list
                subsection:null,
                teacher:null,
                teachers:null, // teacher List
                course:null,
                CourseID:null,
                courses:null, // course List
                room:null,
                rooms:null, //  room List

                preactivepattle:null,
                preactivedrop:null,
                
                user:[],
             
                routines:[],
                routineTime:[],
                warning_T:0,
                warning_R:0,
                warning_time:0,
                msg_T:null,
                msg_R:null,
                msg_time:null,
                edit_status:0,
                edit_id:null,
                warning_course:0,
                msg_course:null,

                del_teacher :null,
                del_day :null,
                del_room :null,
                del_section :null,
                del_course :null,
                del_id :null,
                del_stratTime :null,
                del_endTime :null,
                del_status :0,
                pdfData:null,
             }
        },
        methods:{
            
            // get data 
            dayData:function(data){
              this.days = data;
            },
            // get times 
            timeData: function(data){
              this.times = data;
            },
            // get sections 
            sectionData: function(data){
              this.sections = data;
            },
            // get teachers
            teacherData:function(data){
               this.teachers = data;
            },
            // get courses
            courseData:function(data){
                this.courses = data;
            },
            //get room
            roomData:function(data){
              this.rooms = data;
            },
            // routine List get
            RoutineList:function(session){
                axios.get('/api/routine/list/'+session).then((res)=>{
                    this.routines = res.data;
                    this.loaded = true;
                }).catch(()=>{
                    this.routines = null;
                });
            },
            SessionGet:function(){
                axios.get('/api/user').then((res)=>{
                    this.user = res.data;
                    this.RoutineList(this.user.id);
                }).catch(()=>{
                    this.user = null;
                });
            },

            onDrop(event){
                /// day Drop
                if(event.dataTransfer.getData('day')){
                    var day_id    = event.dataTransfer.getData('day');
                    this.day = this.searchDataByID(this.days,parseInt(day_id));
                    if(this.day != null && this.edit_status != 1){
                            this.section = null;
                            this.course = null;
                            this.start_time = null;
                            this.end_time = null;
                            this.teacher = null;
                            this.room = null;
                            this.msg_time = null;
                            this.warning_time = 0;
                            this.warning_R = 0;
                            this.msg = null;
                            this.warning_T = 0;
                            this.msg = null;
                            this.warning_course = 0;
                            this.msg_course = null ;
                    }
                }
                /// section Drop
                if(event.dataTransfer.getData('sectionID')){
                    var section_id = event.dataTransfer.getData('sectionID');
                    this.section = this.searchDataByID(this.sections,parseInt(section_id));
                        if(this.section != null){
                            this.semister = this.section.semister;
                            if(this.edit_status != 1){
                                this.course = null;
                                this.start_time = null;
                                this.end_time = null;
                                this.teacher = null;
                                this.room = null;
                                this.msg_time = null;
                            }
                            this.warning_time = 0;
                            this.warning_R = 0;
                            this.msg = null;
                            this.warning_T = 0;
                            this.msg = null;
                            this.warning_course = 0;
                            this.msg_course = null ;
                        }
                }
                /// course Drop
                if(event.dataTransfer.getData('courseID')){
                    var course_id = event.dataTransfer.getData('courseID');
                    this.course = this.searchDataByID(this.courses,parseInt(course_id));
                    if(this.course != null){
                       this.CourseID = this.course.id;
                       if(this.edit_status != 1){
                        this.start_time = null;
                        this.end_time = null;
                        this.teacher = null;
                        this.room = null;
                        this.msg_time = null;
                       }
                       this.warning_time = 0;
                       this.warning_R = 0;
                       this.msg = null;
                       this.warning_T = 0;
                       this.msg = null;
                       this.warning_course = 0;
                       this.msg_course = null ;
                       var d_course = 0;
                       var d1_course = 0;
                       this.routines.filter(r=>{
                          if(r.day == this.day.day && r.section == this.section.section && r.course_id == this.course.id){
                             d_course = 1;
                             return d_course ;
                          }
                          if(r.day != this.day.day && r.section == this.section.section && r.course_id == this.course.id){
                             d1_course = 1;
                             this.remaning_credit = r.per_credit;
                             return d1_course ;
                          }
                       });

                       if(d_course == 0 && d1_course == 0){
                          this.remaning_credit = this.course.per_credit;
                       }
                       if(d_course == 0 && d1_course == 1){
                          this.remaning_credit = (this.remaning_credit - this.course.per_credit);
                       }
                       if(d_course == 1){
                          this.course = null;
                          this.warning_course = 1;
                          this.msg_course = "This Course is Already Added in this Slod";
                       }
                       if(this.remaning_credit == 0){
                          this.course = null;
                          this.warning_course = 1;
                          this.msg_course = "This Course Credit is Over";
                       }
                      
                    }
                }
                /// time Drop
                if(event.dataTransfer.getData('time')){
                    var time_id = event.dataTransfer.getData('time');
                    this.start_time = this.searchDataByID(this.times,parseInt(time_id));
                    var t = 0;
                    if( this.start_time != null){
                        if(this.edit_status != 1){
                            this.teacher = null;
                            this.room = null;
                        }
                        this.warning_R = 0;
                        this.msg = null;
                        this.warning_T = 0;
                        this.msg = null;
                        // find end Time
                        var endTime_id = this.start_time.id+(2*this.course.per_credit);
                        this.end_time = this.searchDataByID(this.times,endTime_id);
                    }
                    if(this.end_time != null && this.start_time != null && this.routines != null){
                         
                         var routines = this.routines;
                         for(var i = 0;i<routines.length;i++){
                             var day = routines[i].day;
                             var section = routines[i].section;
                             var start_time = routines[i].start_time;
                             var end_time = routines[i].end_time;
                              if(day == this.day.day && section == this.section.section){
                                t = this.CheckTime(start_time,end_time);
                                 break;
                                }
                         }
                       
                    }
                    if(t == 1){
                        this.warning_time = 1;
                        this.msg_time = "This Time Slod is Blocked.("+this.start_time.time+'-to-'+this.end_time.time+")";
                        this.start_time = null;
                    }
                    if(t == 0){
                        this.warning_time = 0;
                        this.msg_time = null;
                    }
                   

                }
                /// teacher Drop
                if(event.dataTransfer.getData('teacherID')){
                    var teacher_id = event.dataTransfer.getData('teacherID');
                    this.teacher = this.searchDataByID(this.teachers,parseInt(teacher_id));
                    var t = 0;
                    if(this.teacher != null){
                        this.routines.filter(r => {
                            if(r.teacher_id == this.teacher.id && r.day == this.day.day && this.teacher != null){
                                 t = this.CheckTime(r.start_time,r.end_time);
                                 return t;
                            }

                        });
                    }
                    if(t == 1){
                        this.warning_T = 1;
                        this.msg_T = "The Teacher Slod is Blocked to.("+this.start_time.time+'-to-'+this.end_time.time+")";
                        this.teacher = null;
                    }
                    if(t == 0){
                        this.warning_T = 0;
                        this.msg = null;
                    }
                }
                /// room Drop
                if(event.dataTransfer.getData('roomID')){
                    var room_id = event.dataTransfer.getData('roomID');
                    this.room = this.searchDataByID(this.rooms,parseInt(room_id));
                    var t = 0;
                    if(this.room != null){
                        this.routines.filter(r => {
                            if(r.room_id == this.room.id && r.day == this.day.day  ){
                                t =  this.CheckTime(r.start_time,r.end_time);
                                return t;
                            }
                        }); 
                    }
                    if(t == 1){
                        this.warning_R = 1;
                        this.msg_R = "This Room Slod is Blocked to.("+this.start_time.time+'-to-'+this.end_time.time+")"
                        this.room = null;
                    }
                    if(t == 0){
                        this.warning_R = 0;
                        this.msg = null;
                    }
                }
            },

            addtoroutine(){

               var routine =  {
                    session_id      : this.user.id,
                    day             : this.day.day,
                    day_id          : this.day.id,
                    course_id       : this.course.id,
                    course_code     : this.course.course_code,
                    per_credit      : this.course.per_credit,
                    remaning_credit : this.remaning_credit,//
                    total_credit    : this.course.total_credit,
                    start_time      : this.start_time.time,
                    start_time_id   : this.start_time.id,
                    end_time        : this.end_time.time,//
                    end_time_id     : this.end_time.id,//
                    teacher_id      : this.teacher.id,
                    teacherS_name   : this.teacher.short_name,
                    section_id      : this.section.id,
                    section         : this.section.section,
                    semister        : this.section.semister,
                    room_id         : this.room.id,
                    room_no         : this.room.room_no,
                    room_status     : this.room.status,
                };
                const URL = "http://127.0.0.1:8000/api/routine/add";
                this.$http.post(URL,routine).then((result)=>{
                    this.SessionGet();
                    this.day = null;
                    this.section = null;
                    this.room = null;
                    this.course = null;
                    this.start_time = null;
                    this.teacher= null;
                });
            },

            EditToRoutine(){

               var routine =  {
                    day             : this.day.day,
                    day_id          : this.day.id,
                    course_id       : this.course.id,
                    course_code     : this.course.course_code,
                    per_credit      : this.course.per_credit,
                    remaning_credit : this.remaning_credit,//
                    total_credit    : this.course.total_credit,
                    start_time      : this.start_time.time,
                    start_time_id   : this.start_time.id,
                    end_time        : this.end_time.time,//
                    end_time_id     : this.end_time.id,//
                    teacher_id      : this.teacher.id,
                    teacherS_name   : this.teacher.short_name,
                    section_id      : this.section.id,
                    section         : this.section.section,
                    semister        : this.section.semister,
                    room_id         : this.room.id,
                    room_no         : this.room.room_no,
                    room_status     : this.room.status,
                };
                const URL = "http://127.0.0.1:8000/api/routine/update/" + this.edit_id;
                this.$http.put(URL,routine).then((result)=>{
                    this.SessionGet();
                    this.day = null;
                    this.section = null;
                    this.room = null;
                    this.course = null;
                    this.start_time = null;
                    this.teacher= null;
                    this.edit_id = null;
                    this.edit_status = 0;
                });
            },

            editSlod(day,section,time){
              
              var Index = this.routines.findIndex(r => r.day === day && r.section === section && r.start_time === time);
                if(Index !== -1){
                   this.day = this.searchDataByID(this.days,parseInt(this.routines[Index].day_id));
                   this.section = this.searchDataByID(this.sections,parseInt(this.routines[Index].section_id));
                   this.semister = this.section.semister;
                   this.course = this.searchDataByID(this.courses,parseInt(this.routines[Index].course_id));;
                   this.start_time = this.searchDataByID(this.times,parseInt(this.routines[Index].start_time_id));
                   this.end_time = this.searchDataByID(this.times,parseInt(this.routines[Index].end_time_id));
                   this.CourseID = this.course.id;
                   this.teacher = this.searchDataByID(this.teachers,parseInt(this.routines[Index].teacher_id));
                   this.room = this.searchDataByID(this.rooms,parseInt(this.routines[Index].room_id));
                   this.edit_status = 1;
                   this.edit_id = this.routines[Index].id;
                } 
            },

            deleteModel(day,section,time){
                var Index = this.routines.findIndex(r => r.day === day && r.section === section && r.start_time === time);
                if(Index !== -1){
                     this.del_id = this.routines[Index].id;
                     this.del_day = this.routines[Index].day;
                     this.del_section = this.routines[Index].section;
                     this.del_teacher = this.routines[Index].teacherS_name;
                     this.del_room = this.routines[Index].room_no;
                     this.del_course = this.routines[Index].course_code;
                     this.del_stratTime = this.routines[Index].start_time;
                     this.del_endTime = this.routines[Index].end_time;
                     this.del_status = 1;
                }
            },

            deleteToRoutine(){
                const URL = "http://127.0.0.1:8000/api/routine/delete/" + this.del_id;
                this.$http.delete(URL).then((result)=>{
                    this.SessionGet();
                    this.del_id = null;
                    this.del_day = null;
                    this.del_section = null;
                    this.del_teacher = null;
                    this.del_room = null;
                    this.del_course = null;
                    this.del_stratTime = null;
                    this.del_endTime = null;
                    this.del_status = 0;
                });
            },
            colspan(day,section,time){
                var Index = this.routines.findIndex(r => r.day === day && r.section === section && r.start_time === time);
                if(Index !== -1){
                    return (this.routines[Index].per_credit*2);
                }
                else{
                    return 0;
                }
               
            },
            showInfo(day,section,time){
               var Index = this.routines.findIndex(r => r.day === day && r.section === section && r.start_time === time);
                if(Index !== -1){
                    return this.routines[Index].teacherS_name+'/'+this.routines[Index].course_code+'/'+this.routines[Index].room_no;
                } 
            },
            showR(section,day,times){
                var timeArray = [];
                var ioftime = null;
                var perCredit = null;
                var ioftime1 = null;
                if(times != null ){
                   var l_t = times.length - 1;
                    times.forEach(t => {
                        if(times[l_t].time != t.time){
                         timeArray.push(t.time);
                        }
                    });
                    this.routines.forEach(r => {
                        if(section == r.section && day == r.day){
                            ioftime = timeArray.indexOf(r.start_time);
                            ioftime1 = timeArray.indexOf(r.end_time);
                            perCredit = r.per_credit*2;
                            if(ioftime != -1){
                            timeArray.splice(ioftime+1,perCredit-1);

                            }
                        }
                    });
                    return timeArray;
                }
            },
            countLenght(obj){
                return  obj.length;
            },
           
            /*Event Handle*/    
            ActiveSegment: function(pattle,drop){
             var activepattle = this.$el.querySelector(pattle);
             var activeDrop = this.$el.querySelector(drop);
             if(this.preactivepattle != activepattle && this.preactivedrop != activeDrop && this.       preactivepattle != null && this.preactivedrop != null){
                this.preactivepattle.classList.add('d-none');
                this.preactivedrop.classList.remove('bg-lightblue');
             }
             activepattle.classList.remove('d-none');
             activeDrop.classList.add('bg-lightblue');
             this.preactivepattle = activepattle;
             this.preactivedrop   = activeDrop;
            },
            searchDataByID(obj,val){
                var index = obj.findIndex(e => e.id === val);
                if (index !== -1) {
                    return obj[index];
                }
            },
            // check time 
            CheckTime(start_time,end_time){
                var i_0 = this.times.findIndex(t => t.time == start_time);
                var i_1 = this.times.findIndex(t => t.time == end_time);
                var i = i_0;
                for(i;i<i_1;i++){
                   if(this.times[i].time == this.start_time.time){
                      return 1;
                   }
                   if(this.times[i].time == this.end_time.time && this.end_time.time != start_time){
                    return 1;
                   }
                }
                return 0;
            },
            ReportGen(){
                if(this.view == 0){
                    this.view = 1;
                }
                else{
                    this.view = 0;
                }
            }
        },
        computed: {
          
            filterData:function(){
            return this.rooms.filter(room => room.room_no.includes(this.search));
            },

        },
        mounted() {

            $('#carouselExampleControls').carousel({
                interval: false,
                
            });

            this.SessionGet();

            this.pdf = this.$refs.routines;
            console.log(this.pdf);
      
        },
    }
</script>
