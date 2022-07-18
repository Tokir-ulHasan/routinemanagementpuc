<template>
    <div id="rooms-widnow">
        <div id="rooms-title_bar" class="clear-fix">
            <div class="float-left pt-2">Rooms</div>
        </div>
        <div id="rooms-box">
            <input type="text" v-model="search" placeholder="Search" style="width: 100%;"/>

            <div class="container box" 
                v-for="room in filterData"
                :key="room.id"
                draggable="true"
                @dragstart="starDrag($event,room)" 
                >
                {{room.room_no}}
            </div>
        </div>
    </div>
</template>
<style>
#rooms-widnow{
    width: 170px;
    margin: 0 5px;
    border-radius: 5px;
}
#rooms-title_bar{
    background: #cdd5ff;
    height: 40px;
    width: 100%;
    border: 1px solid #b3aaaa;
    justify-content: center;
    padding: 0 13px;
    margin: 2px;
    font-weight: 500;
}
#rooms-btn{
    border: solid 1px #807070;
    text-align: center;
    border-radius: 6px;
    width: 25px;
    height: 23px;
    float: right;
    cursor: pointer;
}
#rooms-box{
    height: 150px;
    background: #DFDFDF;
}
.box{
    background: #fff;
    border: 1px solid;    
    margin: 2px 0px;
    font-size: small;
}
</style>
<script>

export default ({
    setup() {
        
    },
     data () {
            return {
                search:'',
                rooms : [],
            }
        },
    methods:{
         starDrag(event,roomItem){
              event.dataTransfer.dropEffect = "move"
              event.dataTransfer.effectAllowed = "move"
              event.dataTransfer.setData("roomID",roomItem.id);
        },
        dragMethod() {
            setTimeout( () => {
                debugger;
            }, 500)
        }
        
    },
    computed:{
        filterData:function(){
            return this.rooms.filter(room => room.room_no.includes(this.search));
        }
    },

    mounted(){
        // Rooms Pattle
        $("#rooms-btn").click(function(){
            if($(this).html() == "-"){
                $(this).html("+");
            }
            else{
                $(this).html("-");
            }
            $("#rooms-box").slideToggle();
        });
        this.$http.get(' http://127.0.0.1:8000/api/room/list').then((result)=>{
            this.rooms = result.data;
            this.$emit('RoomInfo',this.rooms);

        });
        
    }
})
</script>
