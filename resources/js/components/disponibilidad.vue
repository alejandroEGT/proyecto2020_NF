<template>
    <div class="div_page">
       
    <div style="width:100%">
        <br>
	<center style="color:white; font-size:21px">{{'Resultados de la busqueda'}}</center>
    <br>
        <el-row v-for="item in listar" :key="item.id"  type="flex" justify="center">
            <el-col  :xs="24" :sm="18" :md="18" :lg="18" :xl="18">
                <el-card>
                <el-row :gutter="10">
                    <el-col :xs="24" :sm="24" :md="6" :lg="6" :xl="6">
                        <img style="height:210px; width:100%" src="http://www.santuariohotel.com/wp-content/uploads/2019/01/GaleriaHabitacion1.jpg" alt="">
                    
                    </el-col>

                     <el-col :xs="24" :sm="24" :md="10" :lg="10" :xl="10">
                        <h2>{{item.descripcion_nivel}}</h2>
                        <el-tag type="warning" effect="dark">{{ item.categoria }}</el-tag>
                         <el-rate
                        v-model="value"
                        disabled
                        show-score
                        text-color="#ff9900"
                        score-template="{value} points">
                        </el-rate>
                        <h5>Nivel {{item.nivel}}, Nombre / numero de habitación {{item.descripcion}}</h5>
                        <h4>{{item.detalle}}</h4>
                        
                    </el-col>

                    <el-col :xs="24" :sm="24" :md="7" :lg="7" :xl="7">
                        <el-tag type="success" effect="plain">{{ item.estado }}</el-tag>
                        <h1 style="color:#28B463">{{formatPrice(item.precio)}}</h1>
                        <hr>
                         <el-button @click="item.activar = true" type="primary">Reservar</el-button>
                        <!-- modal -->
                         <el-dialog title="Shipping address" :visible.sync="item.activar">
                           <el-form label-width="190px" class="demo-ruleForm">
                            <el-form-item label="Su nombre completo" prop="name">
                              <el-input v-model="nombre" ></el-input>
                            </el-form-item>

                            <el-form-item label="Tipo de identificación" prop="tipo">
                              <el-select v-model="tipo" placeholder="Tipo de identificacion">
                              <el-option
                                v-for="item in tipos"
                                :key="item.id"
                                :label="item.label"
                                :value="item.id">
                              </el-option>
                            </el-select>
                            </el-form-item>

                            <el-form-item label="Rut/numero de pasaporte" prop="name">
                              <el-input v-model="identificador" ></el-input>
                            </el-form-item>

                            <el-form-item label="Contacto" prop="name">
                              <el-input v-model="contacto" ></el-input>
                            </el-form-item>

                            <br>

                            <el-form-item label="Email(Opcional)" prop="name">
                              <el-input v-model="email" ></el-input>
                            </el-form-item>
                            <el-form-item label="Detalle reserva(Opcional)" prop="name">
                              <el-input type="textarea" v-model="detalle" ></el-input>
                            </el-form-item>
                          
                            <div style="text-align:center;">
                              <el-button type="primary" @click="solicitar(item.id)" icon="far fa-save" round> Solicitar reserva</el-button>
                            </div>
                            
                          </el-form>
                        </el-dialog>
                    </el-col>
                </el-row>
                </el-card>
                <br>
            </el-col>
        </el-row>
        
		
	</div>
        
    </div>
</template>

<script>
export default {
    data(){
        return {
            dialogTableVisible: false,
            fecha_desde: this.$route.params.fecha_desde,
            fecha_hasta: this.$route.params.fecha_hasta,
            select: this.$route.params.tipo,

            listar:{},
            value: 3.7,
             tipo:'',
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
            identificador:'',
            nombre:'',
            contacto:'',
            email:'',
            detalle:''
        }
    },
    created(){
        this.ir_a_disponibilidad();
    },
    methods:{
       url_params(name, json){
    		this.$router.push({name:name, params:json}).catch(error => {
            if (error.name != "NavigationDuplicated") {
              throw error;
            }
          });
        },

        ir_a_disponibilidad(){
            const data = {
                fecha_desde :this.fecha_hasta,
                fecha_hasta: this.fecha_hasta,
                select : this.select
            }

            axios.post("api/traer_disponibilidad2",data).then((res)=>{
                    if (res.data.estado == "success") {
                    // this.url_params("disponibilidad",{ 
                    //     fecha_desde: res.data.fecha_desde, 
                    //     fecha_hasta: res.data.fecha_hasta,
                    //     tipo: res.data.categoria_id
                    // });
                    this.listar = res.data.response;
                    }
            });

        },

        formatPrice(value) {
                let val = (value/1).toFixed(0).replace('.', ',')
                return '$'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },

        solicitar(hab){
          const data = {
           'nombre': this.nombre,
           'tipo': this.tipo,
           'identificador': this.identificador,
           'contacto': this.contacto,
           'email': this.email,
           'detalle': this.detalle,
           'habitacion_id': hab,
           'fecha_desde': this.fecha_desde,
           'fecha_hasta': this.fecha_hasta
          };

          axios.post("api/solicitud_reserva", data).then((res)=>{
              if (res.data.estado == 'success') {
                this.$message({
                  message: ''+res.data.mensaje,
                  type: 'success'
                });

                this.nombre = '';
                this.tipo = '';
                this.identificador = '';
                this.contacto = '';
                this.email = '';
                this.detalle = '';
              }else{
                this.$message.error(''+res.data.mensaje);
              }
          });
        }
        
    }
}
</script>

<style>
  .el-carousel__item h3 {
    color: #475669;
    font-size: 18px;
    opacity: 0.75;
    line-height: 300px;
    margin: 0;
  }

  .el-carousel__item:nth-child(1n) {
    background:url(https://www.viajeselcorteingles.es/imagenes/tm/europa/espana/canarias-islas/lpa-gran-canaria/lpain-playa-del-ingles/t9b2zcnp/mdm-17lpain350-hd-parque-cristobal-gran-canaria-relax-swimmingpool-3.jpg);
    width:100%;
    height:100%;
    background-repeat:no-repeat;
    background-size:cover;
  }

  .el-carousel__item:nth-child(2n) {
    
    background:url(https://www.viajeselcorteingles.es/imagenes/tm/europa/espana/canarias-islas/lpa-gran-canaria/lpain-playa-del-ingles/t9b2zcnp/mdm-17lpain350-hd-parque-cristobal-gran-canaria-swimmingpool-night-view.jpg);
    width:100%;
    height:100%;
    background-repeat:no-repeat;
    background-size:cover;
  }

  .el-carousel__item:nth-child(3n) {
    background:url(https://www.viajeselcorteingles.es/imagenes/tm/europa/espana/canarias-islas/lpa-gran-canaria/lpain-playa-del-ingles/t9b2zcnp/mdm-17lpain350-hd-parque-cristobal-gran-canaria-activity-pool-2.jpg);
    width:100%;
    height:100%;
    background-repeat:no-repeat;
    background-size:cover;
  }






  .myDiv {
  position: relative;
  z-index: 5;
  height: 100%;
  width: 100%;
  color: #FFF;
  font-size: 400%;
  
}

.myDiv::before {
    content: "";
    position: absolute;
    z-index: -1;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: black;
    opacity: .7;
}

.el-card.micard.is-always-shadow {
    background: #4b6cb7;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #2E86C1, #4b6cb7);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #2E86C1, #4b6cb7); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    color:white;
}


/* #outer {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
} */





.card {
  display: flex;
  height: 20px;
  width: 100%;
  background:url(https://www.videvo.net/videvo_files/images/preview_170307_Particles_07_1080p.jpg);
  
    background-repeat:no-repeat;
    background-size:cover;
  /* border-radius: 5px; */
  box-shadow: -1rem 0 3rem #2E86C1;
/*   margin-left: -50px; */
  transition: 0.4s ease-out;
  position: relative;
  left: 0px;
}

.card:not(:first-child) {
    margin-left: -50px;
}

/* .card:hover {
  transform: translateY(-20px);
  transition: 0.4s ease-out;
} */

.card:hover ~ .card {
  position: relative;
  left: 50px;
  transition: 0.4s ease-out;
}

.title {
  color: white;
  font-size: 20px;
  /* font-weight: 300; */
  position: absolute;
  left: 20px;
  top: 15px;
}

.bar {
  
  position: absolute;
  top: 80px;
  
  height: 5px;
  width: 100%;
}

.emptybar {
  background-color:white;
  width: 100%;
  height: 100%;
}

.filledbar {
  position: absolute;
  top: 0px;
  z-index: 3;
  width: 0px;
  height: 100%;
  background: rgb(0,154,217);
  /* background: linear-gradient(90deg, rgba(0,154,217,1) 0%, rgba(217,147,0,1) 65%, rgba(255,186,0,1) 100%); */
  background: linear-gradient(90deg, yellow 0%, yellow 65%, yellow 100%);
  transition: 0.6s ease-out;
}

.card:hover .filledbar {
  width: 100%;
  transition: 0.4s ease-out;
}

.circle {
  background: linear-gradient(to right, #2E86C1, #4b6cb7);
  padding-top: 10px;
  width: 100%;
  height:100%;
  
  color:white;
  position: absolute;
  top: 90px;
  
}

.stroke {
  stroke: white;
  stroke-dasharray: 360;
  stroke-dashoffset: 360;
  transition: 0.6s ease-out;
}

svg {
  fill: red;
  stroke-width: 2px;
}

.card:hover .stroke {
  stroke-dashoffset: 100;
  transition: 0.6s ease-out;
}


