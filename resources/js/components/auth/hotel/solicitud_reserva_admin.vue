<template>
    <div style="width:100%;" class="myDiv2">
    
    <el-header> 
        <i class="fas fa-calendar-plus"></i> Solicitud de reservas
    </el-header>
    <el-main>
       <el-button v-show="false" id="btn_buscar" @click="buscar" icon="el-icon-search" circle></el-button>


        <el-table 
            size="mini"
            border
            :data="tableData"
           
            empty-text="No hay solicitudes de reserva"
            >
            <el-table-column width="90px"
              label="Id"
             >
              <template slot-scope="scope">
                <!-- <i class="el-icon-time"></i> -->
                <span style="margin-left: 10px">{{ scope.row.solicitud_id+'-'+scope.row.habitacion_id }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Descripción de habitación"
              width="230px"
             >
              <template slot-scope="scope">
                <!-- <i class="el-icon-time"></i> -->
                <img height="30" width="35" src="hotel.png" alt="">
                <span style="margin-left: 10px">
                    {{ scope.row.descripcion}}<br>
                    {{'Nivel '+scope.row.nivel+', '+scope.row.descripcion_habitacion+', '+scope.row.categoria }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Cliente solicitante"
               width="180px"
             >
              <template slot-scope="scope">
                <!-- <i class="el-icon-time"></i> -->
                 <i class="far fa-user"></i>
                <span style="margin-left: 10px">{{ scope.row.nombre }}</span>
              </template>
            </el-table-column>

            <el-table-column
              label="Identificador"
               width="190px"
             >
              <template slot-scope="scope">
               
                <span style="margin-left: 10px">{{ scope.row.tipo_identificador+', '+scope.row.identificar }}</span>
              </template>
            </el-table-column>

            <el-table-column
              label="Contacto"
               width="150px"
             >
              <template slot-scope="scope">
                <i class="fas fa-phone-alt"></i>
                <span style="margin-left: 10px">{{ scope.row.contacto }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Operaciones">
              <template slot-scope="scope">
                  
                 
                <!-- <el-button v-if="scope.row.cliente_existe == 'N'"
                  size="mini"
                  @click="handleEdit(scope.$index, scope.row)">Añadir cliente</el-button> -->
                <el-button
                  size="mini"
                  type="primary"
                  @click="scope.row.modal = true;reservar(scope.row.cliente_existe, scope.row.identificar, scope.row)">
                        Reservar</el-button>

                  <el-dialog


                    title="Registrar nuevo cliente"
                    :visible.sync="scope.row.modal"
                    width="90%"
                    >   
                        <div v-if="scope.row.cliente_existe == 'N'">
                    

                            <el-form label-width="150px" class="demo-ruleForm">
                        <el-form-item label="Nombre cliente" prop="name">
                            <el-input size="mini" v-model="nombre" ></el-input>
                        </el-form-item>

                        <el-form-item label="Tipo identificación" prop="name">
                            <el-select size="mini" v-model="tipo_identificador" placeholder="Seleccione..">
                                <el-option
                                    v-for="item in tipos"
                                    :key="item.id"
                                    :label="item.label"
                                    :value="item.id">
                                    </el-option>
                                </el-select>
                        </el-form-item>

                        <el-form-item label="identificador" prop="name">
                            <el-input size="mini" v-model="identificador2" ></el-input>
                        </el-form-item>

                        <br>

                        <el-form-item label="Contacto" prop="name">
                            <el-input size="mini" v-model="contacto" ></el-input>
                        </el-form-item>
                        <el-form-item label="Correo Electrónico" prop="name">
                            <el-input size="mini" v-model="email" ></el-input>
                        </el-form-item>
                        <el-form-item label="Dirección" prop="name">
                            <el-input size="mini" v-model="direccion" ></el-input>
                        </el-form-item>
                        
                            <!-- <div style="text-align:center;">
                                <el-button type="primary" @click="insertar" round>Guardar</el-button>
                            </div> -->
                        
                        </el-form>
                        
                        <span slot="footer" class="dialog-footer">
                            <!-- <el-button @click="dialog_cliente = false">Cancelar</el-button> -->
                            <el-button type="primary" @click="registrar_cliente">Registrar</el-button>
                        </span>

                        </div>
                         <el-card >
                            <h3>Datos de la habitación</h3>
                            <label for=""><b>Edificio:</b> {{ habitacion.descripcion_nivel }}, nivel {{ habitacion.nivel }}</label><br>
                            <label for=""><b>Numero / Nombre:</b> {{ habitacion.descripcion }}</label><br>
                            <label for=""><b>Categoría:</b> {{ habitacion.categoria }}</label><br>
                            <label for=""><b>Precio:</b> {{ habitacion.precio }}</label><br>
                            <label for=""><b>Detalle:</b> {{ habitacion.detalle }}</label><br>
                            <label for=""><b>Estado:</b> 
                                    <el-select size="mini" v-model="estado_hab" placeholder="Seleccione..">
                                        <el-option
                                            v-for="item in estados"
                                            :key="item.id"
                                            :label="item.label"
                                            :value="item.id">
                                        </el-option>
                                    </el-select>
                            </label><br> <br>
                            
                            <label for="">
                                <b>¿ el cliente ha cancelado ?</b><br>
                                <el-radio v-model="pago" label="si">Si</el-radio>
                                <el-radio v-model="pago" label="no">No</el-radio>
                            </label>
                            
                        </el-card>


                          <el-card>
                            <h3>Datos del cliente y reserva</h3>
                            <el-row :gutter="20">
                                <el-col :sm="24" :md="8">
                                    <el-input v-model="identificador"   prefix-icon="el-icon-search" placeholder="Buscar por Numero de rol o pasaporte"></el-input>
                                </el-col>
                                <el-col :sm="24" :md="2">
                                    <el-button id="btn_buscar" @click="buscar" icon="el-icon-search" circle></el-button>
                                </el-col>
                                <el-col :sm="24" :md="2">
                                    <!-- <el-button type="primary" icon="el-icon-edit" circle></el-button> -->
                                    <el-button @click="dialog_cliente = true;" icon="el-icon-edit" type="primary">Agregar nuevo cliente</el-button>
                                  
                                      
                                </el-col>
                            </el-row>
                            <br>
                            <label for=""><b>Nombre:</b> {{ get_cliente.nombre }}</label><br>
                            <label for=""><b>Identificador:</b> {{ get_cliente.identificador }}</label><br>
                            <label for=""><b>Tipo identificador:</b> {{ get_cliente.tipo }}</label><br>
                            <label for=""><b>Detalle de hospedaje:</b>
                                <el-input v-model="detalle" type="textarea" placeholder="Ingrese una pequeña descripción"></el-input>
                            </label>
                            <br>
                            <label for=""><b>Fecha y hora de hospedaje:</b><br>
                                
                            </label>

                            <el-row :gutter="20">
                                <el-col :sm="12" :md="12">
                                    <el-date-picker
                                        v-model="fecha.fdesde"
                                        type="date"
                                        format="dd/MM/yyyy"
                                        value-format="yyyy-MM-dd"
                                        placeholder="Fecha de inicio">
                                    </el-date-picker>

                                    <el-time-select
                                        v-model="fecha.hdesde"
                                        :picker-options="{
                                            start: '08:30',
                                            step: '00:15',
                                            end: '18:30'
                                        }"
                                        placeholder="Hora de inicio">
                                        </el-time-select>
                                </el-col>

                                <el-col :sm="12" :md="12">
                                    <el-date-picker
                                        v-model="fecha.fhasta"
                                        format="dd/MM/yyyy"
                                        value-format="yyyy-MM-dd"
                                        type="date"
                                        placeholder="Fecha hasta">
                                    </el-date-picker>

                                    <el-time-select
                                        v-model="fecha.hhasta"
                                        :picker-options="{
                                            start: '08:30',
                                            step: '00:15',
                                            end: '18:30'
                                        }"
                                        placeholder="Hora hasta">
                                        </el-time-select>
                                </el-col>
                            </el-row>
                            <br>

                            <div style="text-align:center;">
                                <el-button type="primary" @click="insertar_reserva(get_cliente.id, estado_hab, pago, detalle, fecha, scope.row.habitacion_id, scope.row.solicitud_id);(activo_modal==true)?
                                scope.row.modal=true:scope.row.modal=false" round>Guardar</el-button>
                            </div>

                            
                        </el-card>
                    </el-dialog>
              
              
              
              
              
              
              
                    <el-button v-if="scope.row.cliente_existe == 'N'" type="text"><i class="fas fa-user-plus"></i></el-button>
               </template>
            </el-table-column>
          </el-table>
    </el-main>
  </div>
</template>

<style>
     /* .myDiv2 {
  position: relative;
  z-index: 5;
  height: 100%;
  width: 100%;
  color: #FFF;
  font-size: 400%;
  
} */
</style>

<script>
export default {
    data(){
        return{
            tableData:[],
            identificador:'',
            get_cliente:{},
            detalle:'',
            fecha:'',
            nombre:'',
            tipo_identificador:'',
            tipos:{},
            identificador2:'',
            contacto:'',
            email:'',
            direccion:'',
            activo_modal:true,

             tipos:[
                {
                    id:'1',
                    label:'CDI'
                },
                {
                    id:'2',
                    label:'Pasaporte'
                }
            ],


            estados:[
                // {
                //     id:'1',
                //     label:'Disponible'
                // },
                {
                    id:'2',
                    label:'Reservar'
                },
                {
                    id:'3',
                    label:'Ocupar'
                }
            ],
            pago:'',
            fecha:{},
            habitacion:{},
            estado_hab:'',
            solicitud_id:'',
        }
    },
    mounted(){
        this.listar();
    },

    methods:{
         traer_habitacion(hab_id){
            axios.get("api/traer_hotel_habitacion/"+hab_id).then((res)=>{
                if (res.data.estado == "success") {
                    this.habitacion = res.data.response;
                    this.loading = false;
                }
                // this.loading = true;
            });
        },
        listar(){
            axios.get('api/hotel_lista_soliciutd_reserv').then((res)=>{
                this.tableData = res.data.response;
            });
        },
         buscar(){
            axios.get("api/traer_cliente_2/"+this.identificador+'/'+this.solicitud_id).then((res)=>{
                if (res.data.cliente.estado == 'success'){
                    this.get_cliente = res.data.cliente.response;
                }

                    this.fecha.fdesde = res.data.reserva.fecha_desde;
                    this.fecha.fhasta = res.data.reserva.fecha_hasta;
            });
        },
        reservar(cliente_existe, identificar, row){
            this.solicitud_id = row.solicitud_id;
            this.traer_habitacion(row.habitacion_id);
                        
                        if(cliente_existe == 'S'){
                            this.identificador=identificar;
                            console.log( document.getElementById('btn_buscar'));
                       
                            document.getElementById('btn_buscar').click();
                        }else{ 
                            this.identificador='';

                            this.get_cliente.nombre = '';
                            this.get_cliente.identificador = '';
                            this.get_cliente.tipo = '';


                            this.nombre = row.nombre
                            this.tipo_identificador = row.tipo_identificador_id
                            this.identificador2 = row.identificar
                            this.contacto = row.contacto
                            this.email = row.email
                            this.direccion = row.direccion


                        }
            
        },
         registrar_cliente(){
            axios.post("api/registrar_cliente",{
                nombre : this.nombre,
                tipo_identificador : this.tipo_identificador,
                identificador : this.identificador2,
                contacto : this.contacto,
                email : this.email,
                direccion: this.direccion
            }).then((res)=>{
                if(res.data.estado =='success'){
                    this.identificador = this.identificador2;

                    this.nombre = '';
                    this.tipo_identificador = '';
                    this.identificador2 = '';
                    this.contacto = '';
                    this.email = '';
                    this.direccion = '';

                    this.$message({
                    message: res.data.mensaje,
                    type: 'success'
                    });
                    
                     this.activo_modal = true;
                    // document.getElementById("btn_buscar").onClick = function(){
                    //     this.buscar();
                    // };

                    document.getElementById('btn_buscar').click()
                }else{
                    this.activo_modal = false;

                    this.$message({
                        showClose: true,
                        message: ''+res.data.mensaje,
                        type: 'error'
                        });
                }
            });
            
        },

        insertar_reserva(cliente_id, estado_hab, gpago, gdetalle, gfecha, habitacion_id, sr_id){

            const data = {
                cliente: cliente_id,
                estado: estado_hab,
                pago: gpago,
                detalle: gdetalle,
                fecha: gfecha,
                habitacion_id: habitacion_id,
                solicitud_reserva_id: sr_id
            };
            console.log(data);

            axios.post("api/insertar_reserva", data).then((res)=>{
                if(res.data.estado == "success"){
                    // this.cerrar = false;
                    // console.log("1: "+this.cerrar);
                    this.$message({
                    message: res.data.mensaje,
                    type: 'success'
                    });

                    this.listar();
                }

                if(res.data.estado == "failed"){
                    // this.cerrar = false;
                    // console.log("2: "+this.cerrar);
                    this.$message({
                    message: res.data.mensaje,
                    type: 'error'
                    });
                    var close = document.getElementsByClassName('el-dialog__headerbtn');
                    close.onclick = true;
                }
            });
        }
    }
}
</script>