<template>
	<div style="width:100%">
		<label></label>
		<el-row type="flex" justify="center">
		  <el-col  :xs="24" :sm="18" :md="18" :lg="18" :xl="18">

		  	
		  	<el-card class="box-card">
			  <div slot="header" >
			    <span> Log in</span>
			    <el-button style="float: right; padding: 3px 0" type="text">Ayuda</el-button>
			  </div>
			  <div >
			 	  <el-form label-width="180px" class="demo-ruleForm">
					 
					   <el-form-item label="Correo Electrónico" prop="name">
					    <el-input v-model="email" ></el-input>
					  </el-form-item>
                       <el-form-item label="Correo Electrónico" prop="name">
					    <el-input v-model="pass" type="password" ></el-input>
					  </el-form-item>
					
						<div style="text-align:center;">
							<el-button type="primary" @click="login" round>Entrar</el-button>
						</div>
					  
					</el-form>
				 
			  </div>
			  
			</el-card>


	
		</el-col>
		</el-row>
		
	</div>
</template>

<script type="text/javascript">
	export default{
		data(){
			return{
				pass:'',
				
				email:'',
			}
		},
		methods:{
			login() {
                var app = this;
                this.$auth.login({
                    params: {
                    email: app.email,
                    password: app.pass
                    },
                    success: function() {},
                    error: function() {},
                    rememberMe: true,
                    redirect: "/index",
                    fetchUser: true
                });
            },
		}
	}
</script>

<style type="text/css">
	.el-card__header {
    background: #ABB2B9;
}
</style>