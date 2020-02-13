<template>
<div style="width:100%">
		<label></label>
		<el-row type="flex" justify="center">
		  <el-col  :xs="24" :sm="18" :md="18" :lg="18" :xl="18">
        <el-card class="box-card">
                   
                    <div >
                        <el-form label-width="180px" class="demo-ruleForm">
                        
                            
                                <div style="text-align:center;">
                                    <h1>¿ De que trata su negocio ?</h1>

                                    <el-row :gutter="24">
                                        <el-col :md="8">
                                            <el-card :body-style="{ padding: '0px' }">
                                            <img style="width:210px; height:200px" src="http://www.galahotel.cl/img/css/slider_home/01.jpg" class="image">
                                            <div style="padding: 14px;">
                                                <span><strong>Hotel</strong></span>
                                                <div class="bottom clearfix">
                                                <!-- <time class="time">{{ currentDate }}</time> -->
                                                <el-button @click="url('hotel')" type="primary" round class="button">Ir</el-button>
                                                </div>
                                            </div>
                                            </el-card>

                                        </el-col>

                                         <el-col :md="8">
                                             <el-card :body-style="{ padding: '0px' }">
                                                 <img style="width:210px; height:200px" src="http://www.buscadordemoteles.cl/plugimg/img/logos/85.fco22.c45efe.jpg" alt="">
                                                <!-- <img style="width:210px; height:200px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRADnKVp7lXYMDiJ8_0JFv3gSConjPNZ59LVdLZ5RvqpWdoSvkd&s" class="image"> -->
                                                <div style="padding: 14px;">
                                                    <span><strong>Motel</strong></span>
                                                    <div class="bottom clearfix">
                                                    <!-- <time class="time">{{ currentDate }}</time> -->
                                                    <el-button type="primary" round class="button">Ir</el-button>
                                                    </div>
                                                </div>
                                                </el-card>

                                        </el-col>

                                         <el-col :md="8">
                                             <el-card :body-style="{ padding: '0px' }">
                                                <img style="width:210px; height:200px" src="https://www.hostaldonjuan.cl/wp-content/uploads/2019/07/Entorno-Hostal-y-Caban%CC%83as-Don-Juan-Villarrica-3.jpg" class="image">
                                                <div style="padding: 14px;">
                                                    <span><strong>Hostal</strong></span>
                                                    <div class="bottom clearfix">
                                                    <!-- <time class="time">{{ currentDate }}</time> -->
                                                    <el-button type="primary" round class="button">Ir</el-button>
                                                    </div>
                                                </div>
                                                </el-card>
                                        </el-col>
                                    </el-row>
                                </div>
                            
                            </el-form>
                        
                    </div>
                    
        </el-card>
		  </el-col>
		</el-row>
</div>
</template>

<script>
export default {
    data(){
        return{

        }
    },
    methods:{
        url(ruta){
    		this.$router.push({path:ruta}).catch(error => {
			  if (error.name != "NavigationDuplicated") {
			    throw error;
			  }
			});
    	},
    }
}
</script>