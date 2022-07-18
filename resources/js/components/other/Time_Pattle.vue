<template>
    <div id="times-widnow">
            <div id="times-title_bar" class="clear-fix" >
                <div class="float-left">Times</div>
            </div>
            <div id="times-box" >
                <input type="text" v-model="search" placeholder="Search" style="width: 100%;"/>
                <div class="container box" 
                v-for="time in  filterData" 
                :key="time.id"
                draggable="true"
                @dragstart="starDrag($event,time)"
                >
                 {{time.time}}
                </div>
            </div>
    </div>
</template>
<style>
#times-widnow{
    width: 170px;
    margin: 0 5px;
    border-radius: 5px;
}
#times-title_bar{
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

#times-btn{
    border: solid 1px #807070;
    text-align: center;
    border-radius: 6px;
    width: 25px;
    height: 23px;
    float: right;
    cursor: pointer;
}
#times-box{
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
            times :[],
            session_id:null,

        }
    },
    methods:{
       
        starDrag(event,timeItem){
              event.dataTransfer.dropEffect = "move"
              event.dataTransfer.effectAllowed = "move"
              event.dataTransfer.setData("time",timeItem.id);
        },
        timesList(){
            axios.get('http://127.0.0.1:8000/api/time/list/'+this.session_id.id).then((res)=>{
                this.times = res.data;
                if(this.times.length > 0){
                  this.$emit('TimeInfo',this.times);
                }
                }).catch(()=>{
                    this.times = null;
            });
        },
    },
    computed:{
        filterData:function(){
            return this.times.filter(time => time.time.includes(this.search));
        }
        
    },
    
    mounted(){
        // times Pattle
        
        axios.get('/api/user').then((res)=>{
            this.session_id = res.data;
            this.timesList();
            }).catch(()=>{
                this.session_id = null;
        });

        
    }
})
</script>
