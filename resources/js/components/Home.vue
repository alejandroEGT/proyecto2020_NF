<template>
  <div style="width:100%">
    <el-carousel indicator-position="outside" height="500px" :autoplay="false" >
      <el-carousel-item v-for="item in 3" :key="item">
        <br><br>
        <el-row type="flex" justify="center">
          <el-col :xs="24" :sm="24" :md="15" :lg="15" :xl="12">
              <div class="myDiv" >
              <center><label style="text-align:center; color:white; text-shadow: 2px 4px 3px rgba(0,0,0,0.3);">
              {{ 'Hospedate con nosotros' }}
              </label></center>
              <center>
                  <el-row >
                      <el-col :xs="24" :sm="24" :md="13" :lg="13" :xl="13">
                        <!-- <el-input v-model="text" placeholder="Busca tu hospedaje.."></el-input> -->
                        <el-date-picker
                          v-model="fecha"
                          type="daterange"
                          range-separator=" > "
                          start-placeholder="Desde"
                          end-placeholder="Hasta"
                          format="dd/MM/yyyy"
                          >
                        </el-date-picker>
                      </el-col>

                      <el-col :xs="24" :sm="24" :md="6" :lg="6" :xl="6">
                        <el-select  v-model="select" placeholder="Seleccione tipo">
                          <el-option
                            v-for="item in selects"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                          </el-option>
                        </el-select>
                      </el-col>

                      <el-col :xs="24" :sm="24" :md="4" :lg="4" :xl="4">
                        <el-button 
                            icon="el-icon-search" 
                            circle
                            @click="ir_a_disponibilidad"
                            >
                        </el-button>
                      </el-col>
                  </el-row>
              </center>
              <br>
              </div>  
          </el-col>  

        </el-row>
      </el-carousel-item>
    </el-carousel>

   
      <div id="">
        <el-row >
        <el-col :xs="24" :md="12" :lg="12" :xl="12">
          <div class="card">
           <h3 class="title"><i class="fas fa-address-card"></i> ¿Quienes somos?</h3>
            <div class="bar">
              <div class="emptybar"></div>
              <div class="filledbar"></div>
            </div>
            <div class="circle">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum, 
              fugit deserunt. Animi nam alias velit, saepe vel reiciendis error 
              voluptas molestiae nostrum in culpa dolorum magnam blanditiis, odio aperiam id!
            </div>
          </div>
        </el-col>
        <el-col :xs="24" :md="12" :lg="12" :xl="12">
         <div class="card">
          <h3 class="title">Card 1</h3>
          <div class="bar">
            <div class="emptybar"></div>
            <div class="filledbar"></div>
          </div>
          <div class="circle">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg">
            <circle class="stroke" cx="60" cy="60" r="50"/>
          </svg>
          </div>
        </div>
        </el-col>

      </el-row>
      </div>
    
  </div>
</template>


<script>
export default {
  data(){
    return{
     
      text:'',
      fecha:'',

      selects:[ {
                value: '0',
                label: 'Todo'
                },
                {
                value: '1',
                label: 'Individual'
                }, {
                value: '2',
                label: 'Matrimonial'
                }, {
                value: '3',
                label: 'Doble'
                }, {
                value: '4',
                label: 'Junior suite'
                }, {
                value: '5',
                label: 'Triple'
      }],
      select:''
    }
  },

  created(){

  },

  methods:{
    ir_a_disponibilidad(){
      if (this.fecha == '') {
          alert("Falta la fecha"); return false;
      }
       const data = {
          fecha :this.fecha,
          select : this.select
       }

       axios.post("api/traer_disponibilidad",data).then((res)=>{
            if (res.data.estado == "success") {
               this.url_params("disponibilidad",{ 
                 fecha_desde: res.data.fecha_desde, 
                 fecha_hasta: res.data.fecha_hasta,
                 tipo: res.data.categoria_id
              });
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


 .myDiv2 {
  /* position: relative;
  z-index: 1;
  height: 100%;
  width: 100%;
  color: #FFF;
  font-size: 100%; */
  background-image: linear-gradient(
                    to bottom,
                    rgba(140, 183, 247, 0.52),
                    rgba(190, 194, 245, 0.73)
                );
                background-attachment: fixed;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
  
  
}

/* .myDiv2::before {
    content: "";
    position: absolute;
    z-index: -1;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    opacity: .6;
} */


/* #outer {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
} */





.card {
  display: flex;
  height: 280px;
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



.el-col.el-col-24.el-col-xs-24.el-col-sm-24.el-col-md-10.el-col-lg-10.el-col-xl-10 {
    border-right: 1px #D7DBDD solid;
}

</style>