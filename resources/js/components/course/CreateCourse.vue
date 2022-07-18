<template>
    <div class="container">
        <div class="card p-5">
            <div><h3>Insert Course Information</h3></div>
            <form class="row" @submit="addCourse">
                <div class="form-group col-6">
                    <label for="title">Course Tiltle</label>
                    <input type="text" class="form-control" id="title"  v-model="title">
                </div>
                <div class="form-group col-6">
                    <label for="code">Course Code</label>
                    <input type="text" class="form-control" id="code"  v-model="code">
                </div>
                <div class="form-group col-4">
                    <label for="Tcredite">Total Credite</label>
                    <input type="text" class="form-control" id="Tcredite"  v-model="Tcredite">
                </div>
                 <div class="form-group col-4">
                    <label for="Pcreadite">Per Hour Credite</label>
                    <input type="text" class="form-control" id="Pcreadite"  v-model="Pcreadite">
                </div>
                 <div class="form-group col-4">
                    <label for="department">Semister</label>
                    <select class="form-control" id="department" v-model="semister">
                        <option v-for="sem in semisters" :key="sem.id" :value="sem.id">{{sem.name}}</option>
                    </select>
                </div>
                <div class="form-group col-12">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" rows="3" v-model="description"></textarea>
                </div>
                <button type="submit" class="btn btn-outline-primary ">ADD</button>
            </form>
        </div>
    </div>
</template>
<style scoped>

</style>
<script>
export default {
    setup() {
        
    },
    data(){
        return{
            title:null,
            code:null,
            Tcredite:null,
            Pcreadite:null,
            description:null,
            departments:[],
            semisters:[ {
                   id:1,
                   name:'1st'
               },
               {
                   id:2,
                   name:'2nd'
               },
               {
                   id:3,
                   name:'3rd'
               },
               {
                   id:4,
                   name:'4th'
               },
               {
                   id:5,
                   name:'5th'
               },
               {
                   id:6,
                   name:'6th'
               },
               {
                   id:7,
                   name:'7th'
               },
               {
                   id:8,
                   name:'8th'
               } ],
               semister:null,
        }
    },
    methods:{

addCourse(e){
            e.preventDefault();

            const URL = "http://127.0.0.1:8000/api/course/add";

            this.$http.post(URL,{
                course_title : this.title,
                course_code : this.code,
                total_credit : this.Tcredite,
                per_credit : this.Pcreadite,
                description : this.description,
                semister:this.semister,
            }).then((result)=>{
                // this.listDepatment();
            });


            this.title = "";
            this.code = "";
            this.total_credit = "";
            this.per_credit = "";
            this.semister = "";
            this.description = "";
        },
    },
    mounted(){
        this.$http.get('http://127.0.0.1:8000/api/department/list').then((result)=>{
                this.departments = result.data;
            });
    }
}
</script>