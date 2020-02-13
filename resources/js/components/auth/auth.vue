
<template>	
		<div>
			<!-- <el-menu background-color="#3F51B5" text-color="#fff" :default-active="activeIndex" 
			 active-text-color="#ffd04b"
			class="el-menu-demo" mode="horizontal" >
			  <el-menu-item index="Index" @click="url('Index')">NeoRest Admin</el-menu-item>
			  
			  <el-menu-item index="miEntorno" @click="url('miEntorno')" >
				  Crear mi entorno
			  </el-menu-item>
			 
			</el-menu> -->

			<el-menu
        :default-active="activeIndex"
        class="el-menu-demo"
        mode="horizontal"
        background-color="#3F51B5"
        text-color="#fff"
        active-text-color="yellow"
      >
                    <el-menu-item index="" @click="logout" >
                        Salir
                    </el-menu-item>
                   <el-menu-item index="" @click="url_path('/index')" >
                       <i class="fas fa-user"></i> {{ user.nombre }}
                    </el-menu-item>
                    <el-menu-item index="niveles" @click="url_path('/hotel/niveles')">
                        <!-- <i class="el-icon-menu"></i> -->
                        <span>Niveles</span>
                    </el-menu-item>
                    <el-menu-item index="reservas" @click="url_path('/hotel/reservas')">
                        <!-- <i class="el-icon-document"></i> -->
                        <span>Reservas</span>
                    </el-menu-item>
                    <el-menu-item index="solicitud_reserva" @click="url_path('/solicitud_reserva')">
                        <!-- <i class="el-icon-document"></i> -->
                        <span>Solicitud de Reservas</span>
                    </el-menu-item>
                    <el-menu-item index="clientes" @click="url_path('/clientes')" >
                        <!-- <i class="el-icon-setting"></i> -->
                        <span>Clientes</span>
                    </el-menu-item>

                    <el-menu-item index="5">
                        <!-- <i class="el-icon-setting"></i> -->
                        <span>Productos</span>
                    </el-menu-item>

                    <el-menu-item index="6">
                        <!-- <i class="el-icon-setting"></i> -->
                        <span>Registro de ventas</span>
                    </el-menu-item>

        </el-menu>
		
			<div class="foto" style="padding:7px;">
  
				  <el-container class="kkck">
				    
					    <transition name>
					      <router-view :key="$route.fullPath"></router-view>
					    </transition>
				  </el-container>
			
			</div>
	</div>
</template>
<style>
  .el-header {
    background-color:#3F51B5;
    color:#fff;
    line-height: 60px;
  }
  
  .el-aside {
    color: #333;
  }

 button.el-button.el-button--primary{
    color: #FFF;
    background-color: #3F51B5;
    border-color: #3F51B5;
}


  
</style>

<script>
  export default {
    data() {
		
      const item = {
        date: '2016-05-02',
        name: 'Tom',
        address: 'No. 189, Grove St, Los Angeles',
        
      };
      return {
        tableData: Array(20).fill(item),
		activeIndex:this.$route.name,
		user: this.$auth.user()
      }
    },
    created(){
		 console.log('lol',this.$route.name),
		 console.log(this.$auth.user());
    },
    methods:{

      logout: function () {
        this.$confirm('Seguro que quieres salir ?', 'Confirmation', {
         }).then(() => {
              this.$auth.logout({
                  makeRequest: true,
                  redirect: '/'
              });
         });
      },
    	url(name){
    		this.$router.push({name:name}).catch(error => {
			  if (error.name != "NavigationDuplicated") {
			    throw error;
			  }
			});
		},
		url_path(name){
    		this.$router.push({path:name}).catch(error => {
			  if (error.name != "NavigationDuplicated") {
			    throw error;
			  }
			});
    	},
    	handleSelect(){
    		console.log("reload")
    	}
    }
  };
</script>

