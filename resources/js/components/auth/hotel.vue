<template>
    <div style="width:100%">
     
    <br>
        <el-container>
		    
					<transition name>
					    <router-view :key="$route.fullPath"></router-view>
					</transition>

           
        </el-container>

         
    </div>
</template>


<script>
export default {
    data(){
        return{
            Active:this.$route.name,
        }
    },
    created(){
        console.log("lol22", this.$route.name)
    },
    methods:{
        url(ruta){
            
    		this.$router.push({path:ruta}).catch(error => {
                console.log('hotel',error)
			  if (error.name != "NavigationDuplicated") {
			    throw error;
			  }
			});
    	},
    }

}
</script>