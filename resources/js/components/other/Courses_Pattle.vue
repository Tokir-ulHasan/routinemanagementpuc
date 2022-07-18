<template>
    <div id="courses-widnow">
            <div id="courses-title_bar" class="clear-fix" >
                <div class="float-left">Courses</div>
            </div>
            <div id="courses-box" >
                <input type="text" v-model="search" placeholder="Search" style="width: 100%;"/>
                <div class="container box" 
                v-for="course in  filterData" 
                :key="course.id"
                draggable="true"
                @dragstart="starDrag($event,course)"
                v-show="course.semister == semister" >
                 {{course.course_title}}
                </div>
            </div>
    </div>
</template>
<style>
#courses-widnow{
    width: 170px;
    margin: 0 5px;
    border-radius: 5px;
}
#courses-title_bar{
    background: #cdd5ff;
    height: 30px;
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

#courses-btn{
    border: solid 1px #807070;
    text-align: center;
    border-radius: 6px;
    width: 25px;
    height: 23px;
    float: right;
    cursor: pointer;
}
#courses-box{
    height: 150px;
    background: #DFDFDF;
    overflow-y: scroll;
}

</style>
<script>

export default ({
    setup() {
        
    },
    props:['semister'],
    data () {
        return {
            search:'',
            show:false,
            courses : [],
        }
    },
    methods:{
        
        starDrag(event,courseItem){
              event.dataTransfer.dropEffect = "move"
              event.dataTransfer.effectAllowed = "move"
              event.dataTransfer.setData("courseID",courseItem.id);
        },


    },
    computed:{
        filterData:function(){
            return this.courses.filter(course => course.course_title.includes(this.search));
        }
    },
    
    mounted(){
        // courses Pattle
        $("#courses-btn").click(function(){
            if($(this).html() == "-"){
                $(this).html("+");
            }
            else{
                $(this).html("-");
            }
            $("#courses-box").slideToggle();
        });

        this.$http.get(' http://127.0.0.1:8000/api/routine/courses/list').then((result)=>{
            this.courses = result.data;
            this.$emit('CourseInfo',this.courses);

        });
    }
})
</script>
