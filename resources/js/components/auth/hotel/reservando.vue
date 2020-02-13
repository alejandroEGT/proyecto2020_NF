<template>
     <div style="width:100%" class="myDiv2">
    
    <el-header>Hotel / Reservas</el-header>
    <el-main>
      <el-card v-loading="loading" >
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

      <el-card v-loading="loading" >
          <h3>Datos del cliente y reserva</h3>
          <el-row :gutter="20">
              <el-col :sm="24" :md="8">
                   <el-input v-model="identificador" prefix-icon="el-icon-search" placeholder="Buscar por Numero de rol o pasaporte"></el-input>
              </el-col>
              <el-col :sm="24" :md="2">
                   <el-button id="btn_buscar" @click="buscar" icon="el-icon-search" circle></el-button>
              </el-col>
              <el-col :sm="24" :md="2">
                  <!-- <el-button type="primary" icon="el-icon-edit" circle></el-button> -->
                  <el-button @click="dialog_cliente = true;" icon="el-icon-edit" type="primary">Agregar nuevo cliente</el-button>
                  <el-dialog
                    title="Registrar nuevo cliente"
                    :visible.sync="dialog_cliente"
                    width="40%"
                    >
                    <div>
                        <!-- nombre
                        tipo_identificador
                        identificador
                        contacto
                        email
                        direccion -->


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
                    </div>
                    <span slot="footer" class="dialog-footer">
                        <el-button @click="dialog_cliente = false">Cancelar</el-button>
                        <el-button type="primary" @click="registrar_cliente">Registrar</el-button>
                    </span>
                    </el-dialog>
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
			<el-button type="primary" @click="insertar_reserva(get_cliente.id, estado_hab, pago, detalle, fecha)" round>Guardar</el-button>
		</div>

          
      </el-card>
    </el-main>
  </div>
</template>

<script>
export default {
    data(){
        return{
            dialog_cliente:false,
            loading:true,
            hab_id: this.$route.params.id,
            habitacion:{},
            identificador:'',

            //cliente
            nombre:'',
            tipo_identificador:'',
            identificador2:'',
            contacto:'',
            email:'',
            direccion:'',

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

            estado_hab:'',
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

            get_cliente:{},
            pago:'',
            fecha:{},
            detalle:''
            
        }
    },
    created(){
        this.traer_habitacion();
    },
    methods:{
        traer_habitacion(){
            axios.get("api/traer_hotel_habitacion/"+this.hab_id).then((res)=>{
                if (res.data.estado == "success") {
                    this.habitacion = res.data.response;
                    this.loading = false;
                }
                // this.loading = true;
            });
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
                    
                    this.dialog_cliente = false;
                    // document.getElementById("btn_buscar").onClick = function(){
                    //     this.buscar();
                    // };

                    document.getElementById('btn_buscar').click()
                }
            });
            
        },

        buscar(){
            axios.get("api/traer_cliente/"+this.identificador).then((res)=>{
                if (res.data.estado == 'success'){
                    this.get_cliente = res.data.response;
                }
            });
        },

        insertar_reserva(cliente_id, estado_hab, gpago, gdetalle, gfecha){

            const data = {
                cliente: cliente_id,
                estado: estado_hab,
                pago: gpago,
                detalle: gdetalle,
                fecha: gfecha,
                habitacion_id: this.hab_id
            };
            console.log(data);

            axios.post("api/insertar_reserva", data).then((res)=>{
                if(res.data.estado == "success"){
                    this.$message({
                    message: res.data.mensaje,
                    type: 'success'
                    });
                }

                if(res.data.estado == "failed"){
                    this.$message({
                    message: res.data.mensaje,
                    type: 'error'
                    });
                }
            });
        }
    }
}
</script>