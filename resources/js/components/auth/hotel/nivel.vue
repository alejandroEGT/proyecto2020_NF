<template>
<div style="width:100%" class="myDiv2">
     <el-header style="background:#3F51B5; color:#fff" v-loading="loading" >Hotel / Niveles / {{descripcion }} - {{nivel}} </el-header>
    <el-main>

        <el-card class="box-card">
			 
			  <div >
			 	  <el-form class="demo-ruleForm">
					  <el-row :gutter="24">
                          <el-col :md="12">
                              <el-form-item prop="name">
                                  <label for="">descripción</label>
                                    <el-input v-loading="loading" size="small" v-model="descripcion" ></el-input>
                                </el-form-item>

					  
                          </el-col>

                          <el-col :md="12">
                              <el-form-item prop="name">
                                  <label for="">Nivel o numero de piso</label>
                                <el-input v-loading="loading" size="small" v-model="nivel" ></el-input>
                            </el-form-item>
                          </el-col>
					  </el-row>

					  
					
						<!-- <div style="text-align:center;">
							<el-button type="primary" @click="insertar" round>Actualizar</el-button>
						</div> -->
					  
					</el-form>
				 
			  </div>
			  
			</el-card>
        
    </el-main>

     <el-main>
    

        <el-card class="box-card">
			 <h1><img height="30" src="bed.png" alt="">   Habitaciones</h1>
			  <div >
			 	  <el-form class="demo-ruleForm">
					  <el-row :gutter="24">
                          <el-col :md="24">
                              <el-form-item prop="name">
                                  <el-button @click="dialogVisible=true" type="primary" round>Añadir habitación</el-button>

                                  <el-dialog
                                    title="Nueva Habitación"
                                    :visible.sync="dialogVisible"
                                    width="50%"
                                    >
                                        <div>
                                        <el-form label-width="200px" class="demo-ruleForm">
                                            <el-form-item label="Nombre/numero de habitacion" prop="name">
                                                <el-input size="small" v-model="nombre" ></el-input>
                                            </el-form-item>

                                            <el-form-item label="Categoría" prop="name">
                                                <el-select v-model="categoria" placeholder="Categoría..">
                                                    <el-option
                                                    v-for="item in options"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </el-form-item>

                                             <el-form-item label="Detalle" prop="name">
                                                 <el-input size="small" v-model="detalle" type="textarea">
                                                 </el-input>
                                             </el-form-item>

                                             <el-form-item label="Precio" prop="name">
                                                 <el-input size="small" v-model="precio" type="numeric">
                                                 </el-input>
                                             </el-form-item>

                                            <br>

                                        </el-form>
                                    
                                        
                                            <br><br>
                                        </div>
                                        <el-button @click="dialogVisible = false">Cancelar</el-button>
                                        <el-button v-loading="loading" type="primary" @click="insertar_habitaciones">Ingresar</el-button>
                                    
                                    </el-dialog>


                                </el-form-item>
                          </el-col>

                         
					  </el-row>

					  
					
						<div style="text-align:center;">

                          <el-table v-loading="load_tabla"
                            :data="tableData"
                        
                            empty-text="No hay niveles"
                            >
                           

                            <el-table-column
                            label="Edificio"
                             width="170"

                            >
                            <template slot-scope="scope">
                                <!-- <i class="el-icon-time"></i> -->
                                <img height="20" width="25" src="hotel.png" alt="">
                                <span style="margin-left: 10px">{{ scope.row.descripcion_nivel }}</span>
                            </template>
                            </el-table-column>

                            <el-table-column
                            label="Nivel"
                             width="100"
                            >
                            <template slot-scope="scope">
                                <!-- <i class="el-icon-time"></i> -->
                                <img height="20" width="25" src="level.png" alt="">
                                <span style="margin-left: 10px">{{ scope.row.nivel }}</span>
                            </template>
                            </el-table-column>


                            <el-table-column
                            label="Habitación"
                            width="100"
                            >
                            <template slot-scope="scope">
                                <!-- <i class="el-icon-time"></i> -->
                                <img height="20" width="25" src="https://cdn0.iconfinder.com/data/icons/hotel-service-7/64/room-available-vacancy-hotel-accommodation-512.png" alt="">
                                <span style="margin-left: 10px">{{ scope.row.descripcion }}</span>
                            </template>
                            </el-table-column>

                             <el-table-column
                            label="Categoría"
                             width="105"
                            >
                            <template slot-scope="scope">
                                <!-- <i class="el-icon-time"></i> -->
                                <!-- <img height="30" width="35" src="https://cdn0.iconfinder.com/data/icons/hotel-service-7/64/room-available-vacancy-hotel-accommodation-512.png" alt=""> -->
                                <span style="margin-left: 10px">{{ scope.row.categoria }}</span>
                            </template>
                            </el-table-column>

                             <el-table-column
                            label="Precio"
                             width="105"
                            >
                            <template slot-scope="scope">
                                <!-- <i class="el-icon-time"></i> -->
                                <!-- <img height="30" width="35" src="https://cdn0.iconfinder.com/data/icons/hotel-service-7/64/room-available-vacancy-hotel-accommodation-512.png" alt=""> -->
                                <span style="margin-left: 10px">{{ scope.row.precio }}</span>
                            </template>
                            </el-table-column>

                             <el-table-column
                            label="Detalle"
                             width="290"
                            >
                            <template slot-scope="scope">
                                <!-- <i class="el-icon-time"></i> -->
                                <!-- <img height="30" width="35" src="https://cdn0.iconfinder.com/data/icons/hotel-service-7/64/room-available-vacancy-hotel-accommodation-512.png" alt=""> -->
                                <span style="margin-left: 10px">{{ scope.row.detalle }}</span>
                            </template>
                            </el-table-column>
                            
                            <el-table-column
                            label="Operaciones"  width="100">
                            <template slot-scope="scope">
                                <el-button
                                size="mini"
                                @click="handleEdit(scope.$index, scope.row)">Editar</el-button>
                                <!-- <el-button
                                size="mini"
                                type="danger"
                                @click="handleDelete(scope.$index, scope.row)">Eliminar</el-button> -->
                            </template>

                            </el-table-column>

                            <el-table-column
                            label="Operaciones"  width="100">
                                <template slot-scope="scope">
                                    <el-button
                                    v-if="scope.row.activo == 'N'"
                                    size="mini"
                                    type="danger"
                                    @click="active(scope.row.id, scope.row.activo)">NO</el-button>

                                    <el-button
                                    v-if="scope.row.activo == 'S'"
                                    size="mini"
                                    type="success"
                                    @click="active(scope.row.id, scope.row.activo)">SI</el-button>
                                    
                                </template>
                            </el-table-column>
                        </el-table>
							<!-- <el-button type="primary" @click="insertar" round>Actualizar</el-button> -->
						</div>
					  
					</el-form>
				 
			  </div>
			  
			</el-card>
     </el-main>
	</div>
</template>

<script>
export default {
    data(){
        return{
            id: this.$route.params.id,
            dialogVisible:false,

            descripcion:'',
            nivel:'',

            nombre:'',
            categoria:'',
            detalle:'',
            precio:'',

            loading_btn:false,
            loading:false,

            options: [{
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
            
            tableData: [],
        }
    },
    created(){
        this.traer_nivel();
        this.listar_hab();
    },
    methods:{
        traer_nivel(){
            this.loading = true;
            axios.get("api/traer_nivel/"+this.id).then((res)=>{
                    this.descripcion = res.data.response.descripcion;
                    this.nivel = res.data.response.nivel;

                    this.loading = false;
            });
        },

        insertar_habitaciones(){

            const data = {
                'nivel': this.id,
                'nombre': this.nombre,
                'categoria': this.categoria,
                'detalle': this.detalle,
                'precio': this.precio
            };

            axios.post("api/insertar_habitacion", data).then((res)=>{
                if(res.data.estado=='success'){
						this.nombre='';
						this.categoria='';
						this.detalle='';
						this.precio='';

						this.$message({
						message: res.data.mensaje,
						type: 'success'
                        });
                        
                        this.listar_hab();
					}
            });
        },

        listar_hab(){
            this.load_tabla= true;
            axios.get('api/listar_habitaciones/'+this.id).then((res)=>{
            if(res.data.estado=="success"){
                this.tableData = res.data.response;
                this.load_tabla = false;
            }
            this.load_tabla = false;

            });
        },

        active(hab_id,estado){
            axios.get('api/active_habitacion/'+hab_id+'/'+estado).then((res)=>{
                if(res.data.estado=="success"){
                    this.listar_hab();
                }
                

            });
        }
    }
}
</script>

<style >
/* dialog de element */
    .el-dialog__header {
        background:#3F51B5;
        color:#fff;
    }

    span.el-dialog__title {
        color: #fff;
    }
    i.el-dialog__close.el-icon.el-icon-close {
        color: #fff;
    }
</style>