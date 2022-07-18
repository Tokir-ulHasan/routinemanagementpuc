<template>
    <div id="sections-widnow">
            <div id="sections-title_bar" class="clear-fix" >
                <div class="float-left">Sections</div>
            </div>
            <div id="sections-box" >
                <input type="text" v-model="search" placeholder="Search" style="width: 100%;" />
                <div class="container box" 
                v-for="section in  filterData" 
                :key="section.id"
                draggable="true"
                @dragstart="starDrag($event,section)"
                >
                 {{section.section}}
                </div>
            </div>
    </div>
</template>
<style>
#sections-widnow{
    width: 170px;
    margin: 0 5px;
    border-radius: 5px;
}
#sections-title_bar{
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

#sections-btn{
    border: solid 1px #807070;
    text-align: center;
    border-radius: 6px;
    width: 25px;
    height: 23px;
    float: right;
    cursor: pointer;
}
#sections-box{
    height: 150px;
    background: #DFDFDF;
    overflow-y: scroll;
}

</style>
<script>

export default ({
    setup() {
        
    },
    data () {
        return {
            search:'',
            show:false,
            sections : [],
            session_id:null,

        }
    },
    methods:{
      
        starDrag(event,sectionItem){
              event.dataTransfer.dropEffect = "move"
              event.dataTransfer.effectAllowed = "move"
              event.dataTransfer.setData("sectionID",sectionItem.id);
        },
        SectionList(){
            this.$http.get(' http://127.0.0.1:8000/api/section/list/'+this.session_id.id).then((result)=>{
                this.sections = result.data;
                if(this.sections.length > 0){
                 this.$emit('SectionInfo',this.sections);
                }
            });
        }


    },
    computed:{
        filterData:function(){
            return this.sections.filter(section => section.section.includes(this.search));
        }
    },
    
    mounted(){

        axios.get('/api/user').then((res)=>{
            this.session_id = res.data;
            this.SectionList();
            }).catch(()=>{
                this.session_id = null;
        });

       
    }
})
</script>
