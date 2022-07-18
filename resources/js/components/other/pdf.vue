<template> 
   <div> 
    <vue-html2pdf 
        :show-layout="false" 
        :float-layout="true" 
        :enable-download="true" 
        :preview-modal="false" 
        :paginate-elements-by-height="1500" 
        :filename="session.session" 
        :pdf-quality="5"
        :manual-pagination="false" 
        pdf-format="legal" 
        pdf-orientation="landscape" 
        pdf-content-width="1500px"  
        ref="html2Pdf" 
    > 
        <section slot="pdf-content"> 
            <div v-for="day in days" :key="day.id">
                <div class="ptitle">
                  <h2 class="text-center text-dark">{{ day.day }}</h2>
                </div>
                <table >
                    <thead>
                        <tr class="t-head" >
                            <th class="rcell">
                                Sem
                            </th>
                            <th class="rcell2 text-center" v-for="(time,timeIndex) in times" :key="timeIndex" v-show="timeIndex+1 <countLenght(times)" >
                                <span >{{ time.time }}</span>
                                <br>
                                <span v-if="timeIndex+1 <countLenght(times)">{{ times[timeIndex+1].time }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody >
                        <tr  v-for="section in sections" :key="section.id" class="t-body">
                            <td >
                                {{ section.section }}
                            </td>
                            <td v-for="time in showR(section.section,day.day,times)" :key="time.id" :colspan="colspan(day.day,section.section,time)" class="text-center">
                                {{ showInfo(day.day,section.section,time)}}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="html2pdf__page-break"/> 
            </div>
        </section>
    </vue-html2pdf> 
    <i type="button" class="fas fa-file-pdf mx-3" v-on:click="generateReport()"></i>
   </div> 
</template>
<style >
.t-head,.t-body{
    border:1px solid black;
}
.t-head th,.t-body td{
    border:1px solid black;
    
}
.rcell{
    height: 180px;
    width: 60px;
    padding:10px 0;
}
.rcell2{
    height: 180px;
    width: 60px;
    padding:10px 0;

}
tr{
    height: 20px;
}
.ptitle{
    margin: 30px;
}
.ptitle:first{
    margin: 0px;
}
</style>
<script>
import VueHtml2pdf from 'vue-html2pdf' 

export default { 
    props:['days','times','sections','teachers','rooms','routines','courses','session'],
    methods: { 
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
        /* 
            Generate Report using refs and calling the 
            refs function generatePdf() 
        */ 

        generateReport () { 

            this.$refs.html2Pdf.generatePdf() 
        } 
    }, 
    components: { 
        VueHtml2pdf 
    } ,
  

} 


</script>
