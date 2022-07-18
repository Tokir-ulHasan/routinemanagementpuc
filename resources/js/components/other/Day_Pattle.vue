<template>
    <div id="days-widnow">
        <div id="days-title_bar" class="clear-fix">
            <div class="float-left pt-2">Days</div>
        </div>
        <div id="days-box">
            <div class="container box" 
                v-for="day in days"
                :key="day.id"
                draggable="true"
                @dragstart="starDrag($event,day)" 
                >
                {{day.day}}
            </div>
        </div>
    </div>
</template>
<style>
#days-widnow{
    width: 170px;
    margin: 0 5px;
    border-radius: 5px;
}
#days-title_bar{
    background: #cdd5ff;
    height: 30px;
    width: 100%;
    border: 1px solid #b3aaaa;
    justify-content: center;
    padding: 0 13px;
    margin: 2px;
    font-weight: 500;
}
#days-btn{
    background: #fff;
    border: 1px solid;    
    margin: 2px 0px;
    font-size: small;
}
#days-box{
      height: 150px;
    background: #DFDFDF;
    overflow-y: scroll;
}
.box{
    background: #f0ffdf;
    border: 1px solid;
    margin: 2px 0px;
    height: 25px;
    text-align: center;
    font-size: 14px;
    font-family: 'Nunito';
    font-weight: 900;
}
</style>
<script>

export default ({
    setup() {
        
    },
     data () {
            return {
            days : [ 
                {   id:1,
                    day:'Saturday',
                },
                {
                    id:2,
                    day:'Sunday'
                },
                {
                    id:3,
                    day:'Monday'
                },
                {
                    id:4,
                    day:'TuesDay'
                },
                {
                    id:5,
                    day:'Wednesday'
                },
                {
                    id:6,
                    day:'Thursday'
                }],
            }
        },
    methods:{
        
         starDrag(event,day){
              event.dataTransfer.dropEffect = "move"
              event.dataTransfer.effectAllowed = "move"
              event.dataTransfer.setData("day",day.id);
        },
        dragMethod() {
            setTimeout( () => {
                debugger;
            }, 500)
        }
        
    },

    mounted(){
       
        this.$emit('DayInfo',this.days);

    }
})
</script>
