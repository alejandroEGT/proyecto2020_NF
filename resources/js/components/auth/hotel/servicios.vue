<template>
    <div style="width:100%" class="myDiv2">
    <el-header style="background:#3F51B5; color:#fff" ><i class="fas fa-concierge-bell"></i> Servicios </el-header>
      <el-main>
        <el-card>
               <el-row :gutter="20" v-loading="hab_load" >
                            <el-col :sm="24" :md="20" >
                                <img height="20" width="25" src="hotel.png" alt="">
                                {{habitacion.descripcion_nivel}}
                                <br>
                                <img height="20" width="25" src="level.png" alt="">
                                {{'Nivel '+habitacion.nivel+', numero o nombre '+habitacion.descripcion}}
                            </el-col>
                            <el-col :sm="24" :md="4">
                                <el-select 
                                id="miselect"
                                :disabled="true"
                             
                                v-model="habitacion.estado" 
                                placeholder="Selecione">
                                   
                                </el-select>
                                 <!-- <el-button type="text" @click="modalboleta = true;">Comprobante PDF</el-button> -->
                                <!-- <h1 v-if="habitacion.estado_id == 1" style="color:green; font-size:24px">{{ habitacion.estado }}</h1>
                                <h1 v-if="habitacion.estado_id == 2" style="color:orange; font-size:24px">{{ habitacion.estado }}</h1>
                                <h1 v-if="habitacion.estado_id == 3" style="color:red; font-size:24px">{{ habitacion.estado }}</h1> -->
                            </el-col>
              </el-row>
        </el-card>

         <el-card>
                <h3 style="color:#3F51B5"><i class="fas fa-concierge-bell"></i> Formulario de servicios</h3>


                <el-row>
                    <el-col :sm="24" :md="15" :xl="15" :xs="24" >
                        <el-form  label-width="180px">
                            <el-form-item label="Cantidad">
                                 <el-input-number size="mini" v-model="num" :step="1"></el-input-number>
                            </el-form-item>

                            <el-form-item label="Descripción">
                                <el-input v-model="descripcion" type="textarea" ></el-input>
                            </el-form-item>

                            <el-form-item label="Precio unitario">
                                <el-input v-model="precio_unit" size="small" type="nueric" ></el-input>
                            </el-form-item>

                            <el-form-item label="Precio Total">
                                <el-input v-model="precio_total" :load="precio_total = (num*precio_unit)" size="mini" type="text" ></el-input>
                            </el-form-item>

                            <div style="float:right"><el-form-item >
                                <el-button @click="agregar(data.estado_historico_habitaciones_id)" type="primary" > + Añadir</el-button>
                            </el-form-item></div>
                        </el-form>
                    </el-col>
                </el-row>
         </el-card>



          <el-card>
               <h3 style="color:#3F51B5"><i class="fas fa-concierge-bell"></i> Tabla de servicios</h3>

                  <el-table
                            :data="lista"
                            style="width: 100%">
                                <el-table-column label="Cantidad" width="180">
                                    <template slot-scope="scope">
                                        {{ scope.row.cantidad }}
                                    </template>
                                </el-table-column>

                                <el-table-column label="Descripcion" width="180">
                                    <template slot-scope="scope">
                                        {{ scope.row.descripcion }}
                                    </template>
                                </el-table-column>

                                <el-table-column label="Precio unitario" width="180">
                                    <template slot-scope="scope">
                                        {{ formatPrice(scope.row.precio_unitario) }}
                                    </template>
                                </el-table-column>

                                <el-table-column label="Precio total" width="180">
                                    <template slot-scope="scope">
                                        {{ formatPrice(scope.row.precio_total) }}
                                    </template>
                                </el-table-column>
                            </el-table>
          </el-card>
      </el-main>
    </div>
</template>


<script>
export default {
    data(){
        return{
           
            hab_id: this.$route.params.id,
            habitacion:{},
            hab_load:true,
            num:1,
            precio_unit:0,
            precio_total:0,
            descripcion:'',

            data:{},

            lista:[],
        }
    },

    created(){
        this.traer_habitacion();
        this.datos_reserva();

        
    },

    methods:{
         traer_habitacion(){
            axios.get("api/traer_hotel_habitacion/"+this.hab_id).then((res)=>{
                if(res.data.estado=="success"){
                    this.habitacion = res.data.response;
                    this.hab_load = false;
                }
                
            });
        },

        datos_reserva(){
            axios.get("api/traer_hotel_estado_habitacion/"+this.hab_id).then((res)=>{
                if(res.data.estado == "success"){
                    this.data = res.data.response;
                    this.pago = res.data.response.pagada;
                    console.log("id del data: "+ this.data.estado_historico_habitaciones_id)
                    this.traer_servicios(this.data.estado_historico_habitaciones_id); 

                }else{
                     //this.url('reservas');
                     this.ocultar = false;
                    //  document.getElementById("miselect").disabled = true;
                }
            });
        },

        agregar(serv_id){

            const data = {
                'estado_historico_habitaciones_id' : serv_id,
                'cantidad': this.num,
                'precio': this.precio_unit,
                'precio_total': this.precio_total,
                'descripcion': this.descripcion
            }

            axios.post('api/agregar_servicio', data).then((res)=>{
                if (res.data.estado == 'success') {
                    this.$message({
                        showClose: true,
                        message: ''+res.data.mensaje,
                        type: 'success'
                        });
                }else{
                    this.$message({
                        showClose: true,
                        message: 'Oops, this is a error message.',
                        type: 'error'
                        });
                }
            });
        },

        formatPrice(value) {
                let val = (value/1).toFixed(0).replace('.', ',')
                return '$'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },

        traer_servicios(serv_hab_id){
            axios.get('api/listar_servicio/'+serv_hab_id).then((res)=>{
                this.lista = res.data.listar;
                // console.log(res.data)
                this.total_hospedaje = res.data.total
               
                    
                 
                
            });
        }
    }
}
</script>