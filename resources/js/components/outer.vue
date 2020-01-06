
<template>	
	<div >
		<el-menu background-color="#2980B9" text-color="#fff" :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect">
		  <el-menu-item index="1">NeoRest</el-menu-item>
		  
		  <el-menu-item index="3" >Registro</el-menu-item>
		  <!-- <el-menu-item index="4"><a href="https://www.ele.me" target="_blank">Orders</a></el-menu-item> -->
		</el-menu>
	
	<div style="background:#E5E8E8; padding:7px;" >
		<el-container>
		  <el-aside width="200px" style="background-color: rgb(238, 241, 246)">
		    <el-collapse v-model="activeNames" @change="handleChange">
			  <el-collapse-item title="Consistency" name="1">
			    <div>Consistent with real life: in line with the process and logic of real life, and comply with languages and habits that the users are used to;</div>
			    <div>Consistent within interface: all elements should be consistent, such as: design style, icons and texts, position of elements, etc.</div>
			  </el-collapse-item>
			</el-collapse>
		  </el-aside>
		  
		  <el-container>
		    
			    <transition name>
			      <router-view></router-view>
			    </transition>
		  </el-container>
		</el-container>
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
</style>

<script>
  export default {
    data() {
      const item = {
        date: '2016-05-02',
        name: 'Tom',
        address: 'No. 189, Grove St, Los Angeles'
      };
      return {
        tableData: Array(20).fill(item)
      }
    }
  };
</script>

