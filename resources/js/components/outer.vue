
<template>	
		<div style="width:100%;">
			<el-menu background-color="#3F51B5" text-color="#fff" :default-active="activeIndex" 
			 active-text-color="#ffd04b"
			class="el-menu-demo" mode="horizontal" >
			  <el-menu-item index="home" @click="url('home')">NeoRest</el-menu-item>
			  
			  <el-menu-item index="registro" @click="url('registro')" >Registro</el-menu-item>
			  <!-- <el-menu-item index="4"><a href="https://www.ele.me" target="_blank">Orders</a></el-menu-item> -->
			</el-menu>
		
			<div style="background:#E5E8E8; ">
  
				  <!-- <el-container> -->
				    
					    <transition name>
					      <router-view></router-view>
					    </transition>
				  <!-- </el-container> -->
			
			</div>
	</div>
</template>
<style>
	
  .el-header {
    background-color: #B3C0D1;
    color: #333;
    line-height: 60px;
  }
  
  .el-aside {
    color: #333;
  }

  ul.el-menu-demo.el-menu--horizontal.el-menu {
     background: #3F51B5;
	 /* background: #9d50bb;  */
	 background: -webkit-linear-gradient(to right, #3F51B5, #3a7bd5); /* Chrome 10-25, Safari 5.1-6 */
	 background: linear-gradient(to right, #3F51B5, #3a7bd5);
	}

	li.el-menu-item {
		background: radial-gradient(#3F51B5, transparent);
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
        activeIndex:this.$route.name
      }
    },
    created(){
    	// console.log(this.$route.name)
    },
    methods:{
    	url(ruta){
    		this.$router.push({name:ruta}).catch(error => {
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

