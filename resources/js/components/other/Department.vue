<template>
   <div id="pdf">
        <VueHtml2pdf
            :show-layout="false"
            :float-layout="true"
            :enable-download="true"
            :preview-modal="true"
            :paginate-elements-by-height="1400"
            filename="myPDF"
            :pdf-quality="6"
            :manual-pagination="false"
            pdf-format="legal"
            pdf-orientation="landscape"
            pdf-content-width="1300px"
            ref="html2Pdf"
        >
            <section slot="pdf-content">
                 <div :class=" day.day == 'Saturday' ? 'carousel-item active': 'carousel-item'" v-for="day in days" :key="day.id" >
                    <h4 class="card-title">{{ day.day }}</h4>
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
                                    {{ showInfo(day.day,section.section,time)}}
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </VueHtml2pdf>
      <button v-on="generateReport()">pdf</button>
    </div>
</template>

<script>
import VueHtml2pdf from 'vue-html2pdf'

export default { 
    components: {
        VueHtml2pdf
    },
    props:['days','times','sections','teachers','rooms','routines','courses'],
      methods:{
        
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
            generateReport () { 
              this.$refs.html2Pdf.generatePdf();
            } 

           
        },
        mounted() {
          
        },
}
</script>