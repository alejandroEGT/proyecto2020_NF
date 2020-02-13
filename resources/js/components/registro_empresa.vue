<template>
	<div style="width:100%">
		<label></label>
		<el-row type="flex" justify="center">
		  <el-col  :xs="24" :sm="18" :md="18" :lg="18" :xl="18">

		  	
		  	<el-card class="box-card">
			  <div slot="header" >
			    <span> Registro de mi compañía (Hotel, Motel, etc)</span>
			    <el-button style="float: right; padding: 3px 0" type="text">Ayuda</el-button>
			  </div>
			  <div >
			 	  <el-form label-width="180px" class="demo-ruleForm">
					  <el-form-item label="Nombre compañia" prop="name">
					    <el-input v-model="nombre" ></el-input>
					  </el-form-item>

					  <el-form-item label="Razon social" prop="name">
					    <el-input v-model="razon_social" ></el-input>
					  </el-form-item>

					  <el-form-item label="Ubicación" prop="name">
					    <el-input v-model="ubicacion" ></el-input>
					  </el-form-item>

					  <br>

					  <el-form-item label="Nombre super usuario" prop="name">
					    <el-input v-model="usuario" ></el-input>
					  </el-form-item>
					   <el-form-item label="Correo Electrónico" prop="name">
					    <el-input v-model="email" ></el-input>
					  </el-form-item>
					
						<div style="text-align:center;">
							<el-button type="primary" @click="insertar" round>Guardar</el-button>
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
				nombre:'',
				razon_social:'',
				ubicacion:'',
				usuario:'',
				email:'',
			}
		},
		methods:{
			insertar(){
				const data={
					'nombre':this.nombre,
					'razon_social':this.razon_social,
					'ubicacion':this.ubicacion,
					'usuario':this.usuario,
					'email':this.email
				};

				axios.post('guardar_compania', data).then((res)=>{
					if(res.data.estado=='success'){
						this.nombre='';
						this.razon_social='';
						this.ubicacion='';
						this.usuario='';
						this.email='';

						this.$message({
						message: res.data.mensaje,
						type: 'success'
						});
					}
				});
			}
		}
	}
</script>

<style type="text/css">
	.el-card__header {
    background: #ABB2B9;
}
</style>