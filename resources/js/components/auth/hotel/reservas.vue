<template>
 <div style="width:100%" class="myDiv2">
    <el-header style="background:#3F51B5; color:#fff" v-loading="loading" ><i class="fas fa-address-card"></i> Registro de clientes </el-header>
      <el-main>
        <el-table  border
          size="mini"
          :data="tableData.filter(
              data => 
              !search || data.descripcion_nivel.toLowerCase().includes(search.toLowerCase())
              || data.nivel.toLowerCase().includes(search.toLowerCase())
              || data.descripcion.toLowerCase().includes(search.toLowerCase())
              || data.categoria.toLowerCase().includes(search.toLowerCase())
              
            
          )"
          empty-text="No hay datos"
          style="width: 100%">

          <el-table-column label="op" width="60px" >
            <template slot-scope="scope">
              <span v-if="scope.row.estado_id==1" style=" background-color:green" class="dot"></span>
              <span v-if="scope.row.estado_id==2" style=" background-color:orange" class="dot"></span>
              <span v-if="scope.row.estado_id==3" style=" background-color:red" class="dot"></span>
            </template>
          </el-table-column>
          <el-table-column
            label="Edificio"    
          >
            <template slot-scope="scope" >
                                      <!-- <i class="el-icon-time"></i> -->
                  <img height="20" width="25" src="hotel.png" alt="">
                  <span style="margin-left: 10px">{{ scope.row.descripcion_nivel }}</span>
              </template>
          </el-table-column>
          <el-table-column
            label="Nivel"
            prop="nivel"
              width="90px"
            >
              <template slot-scope="scope">
                                      <!-- <i class="el-icon-time"></i> -->
                  <img height="20" width="25" src="level.png" alt="">
                  <span style="margin-left: 10px">{{ scope.row.nivel }}</span>
              </template>
          </el-table-column>
          <el-table-column
            label="Habitación"
            prop="descripcion"
            width="100px"
            >
          </el-table-column>
          <el-table-column
            label="Categoría"
            prop="categoria" width="100px">
          </el-table-column>
          <el-table-column
            label="Precio"
            prop="precio"
            width="100px"
            >
          </el-table-column>
          <el-table-column
            label="Detalle"
            prop="detalle"
            width="200px"
            >
          </el-table-column>
          <el-table-column
            label="Estado" width="100px">
              <template slot-scope="scope">
                <div  v-if="scope.row.estado_id==1">
                  <b><div style="color:green" type="text">{{ scope.row.estado }}</div></b>
                </div>
                <div  v-if="scope.row.estado_id==2">
                  <b><el-button @click="historial(scope.$index, scope.row)" style="color:orange" type="text">{{ scope.row.estado }}</el-button></b>
                </div>
                <div style="color:red" v-if="scope.row.estado_id==3">
                  <b><el-button @click="historial(scope.$index, scope.row)" style="color:red" type="text">{{ scope.row.estado }}</el-button></b>
                </div>
              </template>
          </el-table-column>
          <el-table-column
            align="right">
            <template slot="header" slot-scope="scope">
              <el-input
                v-model="search"
                size="mini"
                placeholder="Type to search"/>
            </template>
            <template slot-scope="scope">
              <el-button
                size="mini"
                @click="handReserva(scope.$index, scope.row)">Reservar</el-button>
              <el-button
                size="mini"
                type="primary"
                @click="historial(scope.$index, scope.row)">
                  <i class="fas fa-chart-bar"></i>
                </el-button>

                 <el-button
                 :disabled="scope.row.estado_id==3 ? false:true"
                size="mini"
                type="success"
                @click="servicios(scope.$index, scope.row)">
                   <i class="fas fa-concierge-bell"></i>
                 </el-button>
            </template>
          </el-table-column>
        </el-table>
      </el-main>
 </div>
  
</template>



<script>
  export default {
    data() {
      return {
        tableData: [{
          date: '2016-05-02',
          name: 'Tom',
          address: 'No. 189, Grove St, Los Angeles',
        }, {
          date: '2016-05-04',
          name: 'John',
          address: 'No. 189, Grove St, Los Angeles',
        }, {
          date: '2016-05-01',
          name: 'Morgan',
          address: 'No. 189, Grove St, Los Angeles',
        }, {
          date: '2016-05-03',
          name: 'Jessy',
          address: 'No. 189, Grove St, Santiago',
        }],
        search: ''
      }
    },
    created(){
        this.listar_hab()
    },
    methods: {
        url(name){
    		this.$router.push({name:name}).catch(error => {
			  if (error.name != "NavigationDuplicated") {
			    throw error;
			  }
			});
        },
        
        url_params(name, json){
    		this.$router.push({name:name, params:json}).catch(error => {
			  if (error.name != "NavigationDuplicated") {
			    throw error;
			  }
			});
        },

        handleEdit(index, row) {
            console.log(index, row);
        },

        handleDelete(index, row) {
            console.log(index, row);
        },

        listar_hab(){
            this.load_tabla = true;
            axios.get('api/listar_todas_habitaciones').then((res)=>{
            if(res.data.estado=="success"){
                this.tableData = res.data.response;
                this.load_tabla = false;
            }
            this.load_tabla = false;

            });
        },

        handReserva(index, row){
            console.log(row.id);

            if(row.estado_id == 2 || row.estado_id == 3){
              alert("Esta habitación tiene una reserva pendiente o esta ocupada en este momento")
              return false;
            }else{
              this.url_params("reservando",{ id: row.id });
            }
            
        },

        historial(index, row){
          
          this.url_params("historial_reserva",{ id: row.id });
        },
        servicios(index, row){
          this.url_params("servicios",{ id: row.id });
        }

        
    },
  }
</script>

<style >
  .dot {
  height: 25px;
  width: 25px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
}
</style>