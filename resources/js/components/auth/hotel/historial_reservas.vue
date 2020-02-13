<template>
    <div style="width:100%" class="myDiv2">
    
        <el-header>Hotel / Reservas / Estado</el-header>
        <el-main>
            <el-tabs type="border-card" @tab-click="tabclick">
            <el-tab-pane>
                <span slot="label">
                    <i class="el-icon-date"></i> Estado actual</span>
                <div>
                    
                    
              
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
                                :disabled="ocultar==false? '' : disabled"
                                @change="cambiar_estado_reserva"
                                v-model="habitacion.estado" 
                                placeholder="Selecione">
                                    <el-option
                                    v-for="item in estados"
                                    :key="item.id"
                                    :label="item.label2"
                                    :value="item.id">
                                    </el-option>
                                </el-select>
                                 <el-button type="text" @click="modalboleta = true;traer_servicios(data.estado_historico_habitaciones_id)">Comprobante PDF</el-button>
                                <!-- <h1 v-if="habitacion.estado_id == 1" style="color:green; font-size:24px">{{ habitacion.estado }}</h1>
                                <h1 v-if="habitacion.estado_id == 2" style="color:orange; font-size:24px">{{ habitacion.estado }}</h1>
                                <h1 v-if="habitacion.estado_id == 3" style="color:red; font-size:24px">{{ habitacion.estado }}</h1> -->

                <!-- modal de la boleta o comprobante des ervicio -->
                <el-dialog
                    title="Comprobante de hospedaje"
                    :visible.sync="modalboleta"
                    width="80%"
                    >
                    <div id="invoice"  style="">  
                        <!-- <el-container> -->
                            <img style="text-align:center" height="50px" src="neofox-nav.png" alt=""><br>
                            <center><h2> Hotel Restovar</h2></center>
                            <center><small style="text-align:center">Pje rio Yakki - Los Angeles.</small>
                            <small style="text-align:center"><br>+56986523599</small></center>
                           
                            
                            <br>

                            <el-header>Datos de reserva y cliente</el-header>
                            <br>
                            <!-- <hr style="	border-top: 1px dashed #8c8b8b;"> -->
                            <label style="margin:10px"><b>Edificio:</b>{{habitacion.descripcion_nivel}}</label><br>
                            <label style="margin:10px"><b>Habitación:</b>{{'Nivel '+habitacion.nivel+', numero o nombre '+habitacion.descripcion}}</label><br>
                            <label style="margin:10px"><b>Categoría:</b>{{habitacion.categoria}}</label><br>
                            <label style="margin:10px"><b>Detalle:</b>{{habitacion.detalle}}</label>
                            <br><br>
                            <!-- <hr style="	border-top: 1px dashed #8c8b8b;"> -->
                            <label style="margin:10px" for=""><b>Cliente:</b> {{ data.nombre }}</label><br>
                            <label style="margin:10px" for=""><b>Identificador:</b> {{ data.identificador }}</label><br>
                            <label style="margin:10px" for=""><b>Tipo identificador:</b> {{ data.tipo_identificador }}</label><br>
                            <label style="margin:10px" for=""><b>Detalle de hospedaje: </b>{{ data.detalle }}</label>
                            <br><br>
                            <el-header>Venta directa</el-header>
                            <br>
                            <label style="margin:10px"><b>Codigo: </b>{{ (data.estado_historico_habitaciones_id,10) }}</label><br>
                            <label style="margin:10px" for=""><b>Precio de hospedaje: </b> {{ formatPrice(data.precio) }}</label><br>

                             <el-header v-if="true">otros servicios</el-header>
                                <!-- {{ lista }} -->
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
                        <!-- </el-container> -->

                        <el-header v-if="true">Total hospedaje</el-header>

                         <h2 style="margin:10px">{{ formatPrice(total_hospedaje + data.precio) }}</h2>

        
                    </div>
                    <el-button type="text" @click="generatePDF">Comprobante PDF</el-button>
    
  
                </el-dialog>
                <!-- FIN modal de la boleta o comprobante des ervicio -->     
                            </el-col>
                        </el-row>
                    </el-card>

                      <el-card v-if="ocultar" v-loading="loading" >
                            <h3 style="color:#3F51B5"><i class="fas fa-address-book"></i> Datos del cliente y reserva</h3>
                            <el-row :gutter="20">
                               
                            
                                <el-col :sm="24" :md="2">
                                    <!-- <el-button type="primary" icon="el-icon-edit" circle></el-button> -->
                                    
                                </el-col>
                            </el-row>
                            <br>
                            <label for=""><b>Nombre:</b> {{ data.nombre }}</label><br>
                            <label for=""><b>Identificador:</b> {{ data.identificador }}</label><br>
                            <label for=""><b>Tipo identificador:</b> {{ data.tipo_identificador }}</label><br>
                            <label for=""><b>Detalle de hospedaje:</b>
                                <el-input v-model="data.detalle" type="textarea" placeholder="Ingrese una pequeña descripción"></el-input>
                            </label>
                            <br>
                            <label for="">
                                <b>¿ el cliente ha cancelado o abonado ?</b><br>
                                <el-radio v-model="pago" label="si">Si</el-radio>
                                <el-radio v-model="pago" label="no">No</el-radio>
                            </label>
                             <br><label for=""><b>Precio</b>(El precio puede ser modificado):</label><br>
                             <el-input v-model="data.precio"></el-input>
                            <br><br>

                            <el-row :gutter="20">
                                <el-col :sm="12" :md="12">
                                    <label for=""><b>Fecha desde:</b><br></label>
                                    <!-- {{ data.fecha_desde }} -->
                                    <el-date-picker
                                        v-model="data.fecha_desde"
                                        
                                        format="dd/MM/yyyy"
                                        
                                        value-format="dd/MM/yyyy"
                                        placeholder="Fecha de inicio">
                                    </el-date-picker>

                                    <el-time-select
                                        v-model="data.hora_desde"
                                        :picker-options="{
                                            start: '08:30',
                                            step: '00:15',
                                            end: '18:30'
                                        }"
                                        placeholder="Hora de inicio">
                                        </el-time-select>
                                </el-col>

                                <el-col :sm="12" :md="12">
                                    <label for=""><b>Fecha hasta:</b><br></label>
                                    <el-date-picker
                                        v-model="data.fecha_hasta"
                                        format="dd/MM/yyyy"
                                        
                                        value-format="dd/MM/yyyy"
                                        type="date"
                                        placeholder="Fecha hasta">
                                    </el-date-picker>

                                    <el-time-select
                                        v-model="data.hora_hasta"
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

                            <div style="text-align:right;">
                                <el-button type="primary" @click="actualizar_reserva(get_cliente.id, estado_hab, pago, detalle, fecha, habitacion.precio)" round>Actualizar informacion</el-button>
                            </div>

                            
                        </el-card>
                     
                    <!-- {{ { id: 2,
                        descripcion_nivel: "Edificio principal",
                        nivel: "1",
                        descripcion: "01",
                        categoria: "Individual",
                        precio: 13000,
                        detalle: "cama individual + television",
                        estado: "Ocupada",
                        estado_id: 3} }} -->

                        <el-card v-if="ocultar">
                            <div>
                                <h3 style="color:#3F51B5"><i class="fas fa-user-times"></i> finalización</h3>

                                <el-form label-width="180px" class="demo-ruleForm">
                                     <el-form-item label="Fecha y hora de finalización" prop="name">
                                        <el-date-picker
                                            v-model="fin_fecha.fecha_fin"
                                            
                                            format="dd/MM/yyyy"
                                            
                                            
                                            placeholder="Fecha de inicio">
                                        </el-date-picker>           
                                            <el-time-select
                                            v-model="fin_fecha.hora_fin"
                                            :picker-options="{
                                                start: '08:30',
                                                step: '00:15',
                                                end: '18:30'
                                            }"
                                            placeholder="Hora de inicio">
                                            </el-time-select>
                                     </el-form-item>
                                    <el-form-item label="Tipo de finalización" prop="name">
                                       <el-select v-model="tipo_f_serv" placeholder="Select">
                                            <el-option
                                            v-for="item in tipo_fin_serv"
                                            :key="item.id"
                                            :label="item.tipo"
                                            :value="item.id">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>

                                     <el-form-item label="Detalle de finalización" prop="name">
                                         <el-input v-model="detalle" type="textarea">
                                         </el-input>
                                     </el-form-item>
                                </el-form>

                                 <div style="text-align:right;">
                                    <el-button type="primary" @click="finalizar_proceso(data.estado_historico_habitaciones_id)" round>Finalizar proceso</el-button>
                                </div>

                            </div>
                        </el-card>
                   
                </div>
            </el-tab-pane>

            <!-- EL HISTORIAL DE LA HABITACION -->
            <el-tab-pane >
                <span slot="label">
                    <i class="el-icon-date"></i> Historial de habitación</span>
                <div>
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
                                :disabled="ocultar==false? '' : disabled"
                                @change="cambiar_estado_reserva"
                                v-model="habitacion.estado" 
                                placeholder="Selecione">
                                    <el-option
                                    v-for="item in estados"
                                    :key="item.id"
                                    :label="item.label2"
                                    :value="item.id">
                                    </el-option>
                                </el-select>
                                <!-- <h1 v-if="habitacion.estado_id == 1" style="color:green; font-size:24px">{{ habitacion.estado }}</h1>
                                <h1 v-if="habitacion.estado_id == 2" style="color:orange; font-size:24px">{{ habitacion.estado }}</h1>
                                <h1 v-if="habitacion.estado_id == 3" style="color:red; font-size:24px">{{ habitacion.estado }}</h1> -->
                            </el-col>
                        </el-row>
                    </el-card>
                
                <el-card>
                     <h3 style="color:#3F51B5"><i class="fas fa-history"></i> Registro Historico Habitacioinal</h3>
                    <el-table  border
                        size="mini" :data="tableData" style="width: 100%">
                        <el-table-column label="Cliente" width="180" >
                            <template slot-scope="scope">
                                {{ scope.row.nombre }}
                            </template>
                        </el-table-column>

                        <el-table-column label="Horario" width="180">
                            <template slot-scope="scope">
                                {{ scope.row.fecha_desde+' - '+scope.row.hora_desde }}
                                <br>
                                hasta
                                <br>
                                {{ scope.row.fecha_hasta+' - '+scope.row.hora_hasta }}
                            </template>
                        </el-table-column>

                        <el-table-column label="Estado habitacion" width="140">
                            <template slot-scope="scope">
                                {{ scope.row.estado_habitaciones }}
                                
                            </template>
                        </el-table-column>

                        <el-table-column label="Servicio" width="180">
                            <template slot-scope="scope">
                                {{ scope.row.fin_servicio }}
                                
                            </template>
                        </el-table-column>

                         <el-table-column label="Detalle de servicio" width="180">
                            <template slot-scope="scope">
                                {{ scope.row.tipo }}
                                
                            </template>
                        </el-table-column>

                        <el-table-column label="Abono/Pago" width="50">
                            <template slot-scope="scope">
                                {{ scope.row.pagada }}
                                
                            </template>
                        </el-table-column>

                        <el-table-column label="Horario de finalizacion" width="180">
                            <template slot-scope="scope">
                                {{ scope.row.fecha_fin_servicio }} - {{ scope.row.hora_fin_servicio}}
                                
                            </template>
                        </el-table-column>


                        <el-table-column label="Detalle de finalizacion" width="280">
                            <template slot-scope="scope">
                                <blockquote class="guionesCss">{{ scope.row.detalle_fin_servicio  }}</blockquote> 
                            </template>
                        </el-table-column>


                        <el-table-column label="Boleta" width="180">
                            <template slot-scope="scope">
                                <el-button type="text" 
                                @click="scope.row.modal = true;
                                traer_servicios(scope.row.estado_historico_habitaciones_id)
                               // datos_reserva()
                               traer_cliente_boleta(scope.row.estado_historico_habitaciones_id)
                                ">PDF {{ scope.row.estado_historico_habitaciones_id }}</el-button> 


                                <!-- modal de la boleta o comprobante des ervicio -->
                                <el-dialog
                                    title="Comprobante de hospedaje"
                                    :visible.sync="scope.row.modal"
                                    width="80%"
                                    >
                                    <div id="invoice"  style="">  
                                        <!-- <el-container> -->
                                            <img style="text-align:center" height="50px" src="neofox-nav.png" alt=""><br>
                                            <center><h2> Hotel Restovar</h2></center>
                                            <center><small style="text-align:center">Pje rio Yakki - Los Angeles.</small>
                                            <small style="text-align:center"><br>+56986523599</small></center>
                                        
                                            
                                            <br>

                                            <el-header>Datos de reserva y cliente</el-header>
                                            <br>
                                            <!-- <hr style="	border-top: 1px dashed #8c8b8b;"> -->
                                            <label style="margin:10px"><b>Edificio:</b>{{habitacion.descripcion_nivel}}</label><br>
                                            <label style="margin:10px"><b>Habitación:</b>{{'Nivel '+habitacion.nivel+', numero o nombre '+habitacion.descripcion}}</label><br>
                                            <label style="margin:10px"><b>Categoría:</b>{{habitacion.categoria}}</label><br>
                                            <label style="margin:10px"><b>Detalle:</b>{{habitacion.detalle}}</label>
                                            <br><br>
                                            <!-- <hr style="	border-top: 1px dashed #8c8b8b;"> -->
                                            <label style="margin:10px" for=""><b>Cliente:</b> {{ data.nombre }}</label><br>
                                            <label style="margin:10px" for=""><b>Identificador:</b> {{ data.identificador }}</label><br>
                                            <label style="margin:10px" for=""><b>Tipo identificador:</b> {{ data.tipo_identificador }}</label><br>
                                            <label style="margin:10px" for=""><b>Detalle de hospedaje: </b>{{ data.detalle }}</label>
                                            <br><br>
                                            <el-header>Venta directa</el-header>
                                            <br>
                                            <label style="margin:10px"><b>Codigo: </b>{{ (data.estado_historico_habitaciones_id,10) }}</label><br>
                                            <label style="margin:10px" for=""><b>Precio de hospedaje: </b> {{ formatPrice(data.precio) }}</label><br>

                                            <el-header v-if="true">otros servicios</el-header>
                                                <!-- {{ lista }} -->
                                            <el-table
                                             border
                                             show-summary
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
                                        <!-- </el-container> -->

                                        <el-header v-if="true">Total hospedaje</el-header>

                                        <h2 style="margin:10px">{{ formatPrice(total_hospedaje + data.precio) }}</h2>

                        
                                    </div>
                                    <el-button type="text" @click="generatePDF">Comprobante PDF</el-button>
                    
                
                                </el-dialog>
                                <!-- FIN modal de la boleta o comprobante des ervicio -->    
                            
                            </template>
                        </el-table-column>


                         

                    </el-table>
                </el-card>
                </div>
            </el-tab-pane>
            
            </el-tabs>
        </el-main>
    </div>
</template>



<script>
export default {
    data(){
        return{
            modalboleta:false,
            disabled:false,
            ocultar:true,
            loading:false,
            hab_load:true,
            hab_id: this.$route.params.id,
            habitacion:{},
            get_cliente:{
                nombre:'',
                identificador:'',
                tipo:'',
            },
            fecha:{},
            detalle:'',
            data:{}, 
            pago:'',
            fin_fecha:{},

            tipo_f_serv:'',
            tipo_fin_serv:{},
             estados:[
                // {
                //     id:'1',
                //     label:'Disponible'
                // },

                //
                {
                    id:'2',
                    label:'Reservar',
                    label2:'Reservada'
                },
                {
                    id:'3',
                    label:'Ocupar',
                    label2:'Ocupada'
                }
            ],
            tableData:[],

            lista:[],

            total_hospedaje:0,
        }
    },

    created(){
        this.traer_habitacion();
        this.datos_reserva();
        this.get_tipo_fin_servicios();

        
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
                    this.pago = res.data.response.pagada

                }else{
                     //this.url('reservas');
                     this.ocultar = false;
                    //  document.getElementById("miselect").disabled = true;
                }
            });
        },

        traer_cliente_boleta(id){
            
            axios.get("api/traer_cliente_boleta/"+id).then((res)=>{
                if(res.data.estado == "success"){
                    this.data = res.data.response[0];
                    // console.log(this.data)
                    // this.pago = res.data.response.pagada

                }else{
                     //this.url('reservas');
                     this.ocultar = false;
                    //  document.getElementById("miselect").disabled = true;
                }
            });
        },

        get_tipo_fin_servicios(){
            
            axios.get("api/traer_tipo_fin_servicio").then((res)=>{
                if(res.data.estado == "success"){
                    
                    this.tipo_fin_serv = res.data.response;

                }
            });
        },

        cambiar_estado_reserva(){
            const data = {
                habitacion_id : this.hab_id,
                habitacion_estado : this.habitacion.estado

            }
            axios.post("api/hotel_cambiar_estado_habitacion", data).then((res)=>{
                if (res.data.estado == 'success'){
                    this.$message({
                        showClose: true,
                        message: ''+res.data.mensaje,
                        type: ''+res.data.estado
                    });
                }else{
                    this.$message({
                        showClose: true,
                        message: ''+res.data.mensaje,
                        type: ''+res.data.estado
                    });
                }
            });
        },
        finalizar_proceso(est_hist_habitacion){

            const data = {
                habitacion_id: this.hab_id,
                est_hist_habitacion_id: est_hist_habitacion,
                fin_fecha: this.fin_fecha,
                tipo_f_serv: this.tipo_f_serv,
                detalle: this.detalle,


            };

             axios.post("api/hotel_finalizar_proceso_habitacion", data).then((res)=>{
                  if (res.data.estado == 'success'){
                    this.$message({
                        showClose: true,
                        message: 'Proceso finalizado con exito',
                        type: 'success'
                    });

                    this.url('reservas');
                }else{
                    this.$message({
                        showClose: true,
                        message: 'Error al finalizar proceso',
                        type: 'failed'
                    });
                }
             });
        },
        tabclick(tab, event){
            if(tab.index == 0){
                this.datos_reserva();
            }
            if(tab.index == 1){// si cae en el historial
                this.lista_historica();
            }
        },

        lista_historica(){
            axios.get("api/hotel_historial_habitacion/"+this.hab_id).then((res)=>{
                
                this.tableData = res.data;
                // console.log(this.tableData)
            });
        },
        formatPrice(value) {
                let val = (value/1).toFixed(0).replace('.', ',')
                return '$'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },

        actualizar_reserva(){

            const data = {
                detalle: this.detalle,
                pago: this.pago,
                fecha_desde: this.data.fecha_desde,
                fecha_hasta: this.data.fecha_hasta,
                hora_desde: this.data.hora_desde,
                hora_hasta: this.data.hora_hasta,
                detalle: this.data.detalle,
                habitacion_id: this.data.nivel_habitacion_id,
                cliente_id: this.data.cliente_id,
                precio: this.data.precio,
                estado_historico_habitaciones_id: this.data.estado_historico_habitaciones_id

            };

            axios.post('api/hotel_actualizar_reserva', data).then((res)=>{
                if (res.data.estado == 'success') {
                    this.$message({
                    message: res.data.mensaje,
                    type: 'success'
                    });
                }else{
                    this.$message({
                    message: res.data.mensaje,
                    type: 'error'
                    });
                }
            }).catch((error) => {
                this.$message({
                    message: 'Proceso denegado',
                    type: 'error'
                    });
            });
        },

        zfill(number, width) {
            var numberOutput = Math.abs(number); /* Valor absoluto del número */
            var length = number.toString().length; /* Largo del número */ 
            var zero = "0"; /* String de cero */  
            
            if (width <= length) {
                if (number < 0) {
                    return ("-" + numberOutput.toString()); 
                } else {
                    return numberOutput.toString(); 
                }
            } else {
                if (number < 0) {
                    return ("-" + (zero.repeat(width - length)) + numberOutput.toString()); 
                } else {
                    return ((zero.repeat(width - length)) + numberOutput.toString()); 
                }
            }
        },
        

        url(ruta){
    		this.$router.push({name:ruta}).catch(error => {
			  if (error.name != "NavigationDuplicated") {
			    throw error;
			  }
			});
        },
        
        generatePDF() {
            // Choose the element that our invoice is rendered in.
            const element = document.getElementById("invoice");
            // Choose the element and save the PDF for our user.
            html2pdf()
            .set({ html2canvas: { scale: 4 } })
            .from(element)
            .save();
        },

        traer_servicios(estado_hab_id){
            axios.get('api/listar_servicio/'+estado_hab_id).then((res)=>{
                this.lista = res.data.listar;
                // console.log(res.data)
                this.total_hospedaje = res.data.total
               
                    
                 
                
            });
        }

      
    }
}
</script>

<style>
    p.test {
    white-space:nowrap; 
    width:12em; 
    overflow:hidden;
    text-overflow: ellipsis;
    /*otras hornamentales*/
    }
    p.test:hover {
    text-overflow:inherit;
    overflow:visible;
    width: auto;
    cursor: pointer;
    }


    blockquote.guionesCss{
        -moz-hyphens:auto;
        -ms-hyphens:auto;
        -webkit-hyphens:auto;
        -o-hyphens:auto;
        hyphens:auto;
        word-wrap:break-word;
    }


</style>