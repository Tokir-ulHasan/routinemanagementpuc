<template>
    <div class="container">
        <div class="card p-5">
            <div><h3>Insert Teacher Information</h3></div>
            <form class="row" @submit="addTeachert">
                <div class="form-group col-6">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="AMIR" v-model="name">
                </div>
                <div class="form-group col-6">
                    <label for="shortName">Short Name</label>
                    <input type="text" class="form-control" id="shortName" placeholder="AMR" v-model="Sname">
                </div>
                <div class="form-group col-6">
                    <label for="department">Choose Department</label>
                    <select class="form-control" id="department" v-model="department">
                        <option v-for="department in departments" :key="department.id" :value="department.id">{{department.name}}</option>
                    </select>
                </div>
                <div class="form-group col-6">
                    <label for="department">Teather Type</label>
                    <select class="form-control" id="department" v-model="type">
                        <option value="1">RAGULER</option>
                        <option value="2">GUEST</option>
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
            name:null,
            Sname:null,
            department:null,
            type:null,
            description:null,
            departments:[],
        }
    },
    methods:{

addTeachert(e){
            e.preventDefault();

            const URL = "http://127.0.0.1:8000/api/teacher/add";
            this.$http.post(URL,{
                name : this.name,
                short_name : this.Sname,
                department_id : this.department,
                teacher_type : this.type,
                description : this.description,
            }).then((result)=>{
                // this.listDepatment();
            });


            this.name = "";
            this.Sname = "";
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