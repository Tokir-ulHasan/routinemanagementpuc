<template>
    <div class="container">
        <div class="card p-5" v-if="loaded == true">
            <div class="card-head"><h3>Insert Section </h3>
                <form class="row" @submit="addSection">
                    <div class="form-group col-6">
                        <label for="name">Section</label>
                        <input type="text" class="form-control" id="name" placeholder="1A1" v-model="section">
                    </div>
                    <div class="form-group col-6">
                        <label for="department">Semister</label>
                        <select class="form-control" id="department" v-model="semister">
                            <option v-for="sem in semisters" :key="sem.id" :value="sem.id">{{sem.name}}</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-primary ">ADD</button>
                </form>
            </div>
             <div class="card-body " >
                <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header ">
                            <h5 class="modal-title text-primary" id="exampleModalLabel">Add Sub Section</h5>
                            <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="name">Add Sub-Section of {{sectionTitle}}</label>
                            <input type="text" class="form-control" id="name" placeholder="A1.." v-model="subsection">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-outline-primary"  data-dismiss="modal" v-on:click="addSubsection()">ADD</button>
                        </div>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-center ">Section's</h3>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-2 time-style" v-for="section in sections" :key="section.id">
                        <div class="tooltipe" >
                         <i class="fas far fa-edit i-btn text-success" type="button" data-toggle="modal" data-target="#add" v-on:click="subsectionM(section)" ></i>
                         <i class="fas fa-plus i-btn" type="button" data-toggle="modal" data-target="#add" v-on:click="subsectionM(section)" ></i>
                        </div>
                        <div class="section">
                          {{section.section}}<br>
                          <!-- <span v-for="subsection in subsections" :key="subsection.id" v-show="subsection.section_id == section.id" class="subsection">{{subsection.Subsection}}</span> -->
                        </div>
                    </div>
                </div>
            
           </div>
        </div>
        <loading v-if="loaded == false" />
    </div>
</template>
<style scoped>

.tooltipe{
    position: absolute;
    right: 0;
    top: 0;
    margin: 2px;
    background: #ffffff;
    border: none;
}
.i-btn{
    color: blue;
    font-size: 14px;
}
.subsection{
    font-size: 12px;
    font-weight: 600;
    border-top: 1px solid;
}
.subsection::after{
    content: " /";
}
.section{
    margin: 12px 0;
    font-weight: 700;
}
</style>
<script>
import loading from '../loading.vue'

export default {
    setup() {
        
    },
    components: {loading},

    data(){
        return{
           loaded:false,
           section:null,
           semister:null,
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

            session_id:null,
            sections:null,
            subsection:null,
            subsections:null,
            setSection:null,
            sectionTitle:null,

        }
    },
    methods:{

        addSection(e){
            e.preventDefault();

            const URL = "http://127.0.0.1:8000/api/section/add";
            this.$http.post(URL,{
                section : this.section,
                semister : this.semister,
                session_id :this.session_id.id,

            }).then((result)=>{
              this.SectionList();
            });
            this.section = "";
            this.semister = "";
        },
        SectionList(){
            this.$http.get('http://127.0.0.1:8000/api/section/list/'+this.session_id.id).then((result)=>{
                this.sections = result.data;
                if(this.sections.length > 0){
                 this.$emit('SectionInfo',this.sections);
                }
            });
        },
        subsectionM(section){
            this.setSection = section;
            this.sectionTitle = section.section;
        },
        addSubsection(){
           if(this.setSection != null && this.subsection != null){
                this.$http.post('http://127.0.0.1:8000/api/subSection/add',{
                    Subsection   :this.subsection,
                    section_id   :this.setSection.id,
                    semister     :this.setSection.semister,
                    session_id   :this.setSection.session_id,
                }).then((result)=>{
                   this.subsectionlist();
                });
           }
        },
        subsectionlist(){
            axios.get('http://127.0.0.1:8000/api/subsection/list/'+this.session_id.id).then((res)=>{
                this.subsections = res.data;
                }).catch(()=>{
                    this.subsections = null;
            });
        },

    },
    mounted(){
        axios.get('/api/user').then((res)=>{
            this.session_id = res.data;
            this.SectionList();
            this.subsectionlist();
            this.loaded = true;
            }).catch(()=>{
                this.session_id = null;
        });

    }
}
</script>