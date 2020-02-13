<template>
<div style="width:100%" class="myDiv2">
     <el-header style="background:#3F51B5; color:#fff" v-loading="loading" ><i class="fas fa-address-card"></i> Inicio </el-header>
    <el-main>
     <!-- <el-card>
          <line-chart :chart-data="datacollection" :height="100"></line-chart>
     </el-card> -->

     <el-row :gutter="10">
         <el-col :md="13" >
             <el-card>
                 <h3>Reservas y ventas <el-select @change="fillData" v-model="anio" placeholder="Select">
                    <el-option
                    
                    v-for="item in anios"
                    :key="item.id"
                    :label="item.label"
                    :value="item.id">
                    </el-option>
                </el-select> </h3>
                <bar-chart :chart-data="datacollection" :height="100"></bar-chart>
            </el-card>
         </el-col>
         <el-col :md="11">
             <el-card>
                 <h3>Habitaciones con mas ocupaciones</h3>
                <pie-chart :chart-data="piecollecte" :height="100"></pie-chart>
            </el-card>
         </el-col>
     </el-row>

     <!-- <el-card>
          <pie-chart :chart-data="datacollection" :height="100"></pie-chart>
     </el-card> -->
    </el-main>
 </div>
</template>


<script>
import LineChart from './charts/LineChart.js';
import BarChart from './charts/BarChart.js';
import PieChart from './charts/PieChart.js';

export default {
  components: {
    LineChart,
    BarChart,
    PieChart
  },
  data(){
    return {
      datacollection: null,


      piecollecte : null,


      anio:'2020',
      anios: [{
          id: '2020',
          label: '2020'
        }, {
          id: '2019',
          label: '2019'
        }], 
    }
  },
  mounted () {
    this.fillData();
    this.pie();
  },
  methods: {

    fillData (){
    //   this.datacollection = {
    //     labels: ['Enero','Febrero','Marzo','Abril','Mayo', 'Junio' , 'julio', 'agosto','septiembre',
    //     'octubre','noviembre','diciembre'],
    //     datasets: [
    //       {
    //         label: 'Reservas',
    //         backgroundColor: '#F8C471',
    //         data: [ 5, 6, 7, 8, 9, 10]
    //       },
    //       {
    //         label: 'Ocupaciones',
    //         backgroundColor: '#EC7063',
    //         data: [ 20, 40, 50, 20, 50, 40]
    //       },
    //     ]
    //   }

      axios.get('api/reservas_ocupaciones/'+this.anio).then((res)=>{
          this.datacollection = res.data;
      });
    },

    pie(){
        axios.get('api/top_mas_ocupadas').then((res)=>{
            this.piecollecte = res.data;
        })
    }
  }
}

</script>