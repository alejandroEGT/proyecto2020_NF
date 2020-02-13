<template>
 <div style="width:100%" class="myDiv2">
     <el-header style="background:#3F51B5; color:#fff" v-loading="loading" ><i class="fas fa-address-card"></i> Registro de clientes </el-header>
    <el-main>
        <el-card>
           <el-table stripe fit :data="tabla" size="mini" style="width: 100%">
                        <el-table-column label="Cliente" width="180">
                            <template slot-scope="scope">
                                <i class="fas fa-user"></i>
                                {{ scope.row.nombre }}
                            </template>
                        </el-table-column>

                        <el-table-column label="Tipo identificador" width="180">
                            <template slot-scope="scope">
                               <div v-if="scope.row.tipo_identificador == 1">
                                   {{ 'CDI' }}
                               </div>
                               <div v-if="scope.row.tipo_identificador == 2">
                                   {{ 'PASAPORTE' }}
                               </div>
                            </template>
                        </el-table-column>

                        <el-table-column label="Identificador" width="100">
                            <template slot-scope="scope">
                                {{ scope.row.identificador }}
                                
                            </template>
                        </el-table-column>

                        <el-table-column label="Contacto" width="180">
                            <template slot-scope="scope">
                                {{ scope.row.contacto }}
                                
                            </template>
                        </el-table-column>

                         <el-table-column label="Email" width="180">
                            <template slot-scope="scope">
                                {{ scope.row.email }}
                                
                            </template>
                        </el-table-column>

                        <el-table-column label="Direccion" width="180">
                            <template slot-scope="scope">
                                {{ scope.row.direccion }}
                                
                            </template>
                        </el-table-column>

                       
                    </el-table>
        </el-card>
    </el-main>
</div>
</template>

<script>
export default {
    data(){
        return{
            tabla:{}
        }
    },
    created(){
        this.listar_clientes();
    },

    methods:{
        listar_clientes(){
            axios.get("api/todos_clientes").then((res)=>{
                this.tabla = res.data;
            });
        }
    }
}
</script>