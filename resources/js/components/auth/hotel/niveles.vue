<template>
  <div style="width:100%" class="myDiv2">
    
    <el-header>Hotel / Niveles</el-header>
    <el-main>
        <el-button size="small" @click="dialogVisible=true" type="primary" icon="el-icon-edit">Registrar un nuevo nivel</el-button>
        <br><br>
        <el-dialog
          title="Nuevo Nivel"
          :visible.sync="dialogVisible"
          width="50%"
          >
            <div>
               <el-form label-width="180px" class="demo-ruleForm">
                  <el-form-item label="Nombre de edificio" prop="name">
                    <el-input v-model="descripcion" ></el-input>
                  </el-form-item>

                  <el-form-item label="Nivel" prop="name">
                    <el-input v-model="nivel" ></el-input>
                  </el-form-item>

                  <br>

               </el-form>
           
               
                <br><br>
            </div>
            <el-button @click="dialogVisible = false">Cancelar</el-button>
            <el-button v-loading="loading" type="primary" @click="ingresar_nivel">Ingresar</el-button>
          
        </el-dialog>


        <el-table v-loading="load_tabla"
            :data="tableData"
           
            empty-text="No hay niveles"
            >
            <el-table-column
              label="Id"
             >
              <template slot-scope="scope">
                <!-- <i class="el-icon-time"></i> -->
                <span style="margin-left: 10px">{{ scope.row.id }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Descripción"
             >
              <template slot-scope="scope">
                <!-- <i class="el-icon-time"></i> -->
                <img height="30" width="35" src="hotel.png" alt="">
                <span style="margin-left: 10px">{{ scope.row.descripcion }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Nivel"
             >
              <template slot-scope="scope">
                <!-- <i class="el-icon-time"></i> -->
                 <img height="30" width="35" src="level.png" alt="">
                <span style="margin-left: 10px">{{ scope.row.nivel }}</span>
              </template>
            </el-table-column>
            <el-table-column
              label="Operaciones">
              <template slot-scope="scope">
                <el-button
                  size="mini"
                  @click="handleEdit(scope.$index, scope.row)">Editar</el-button>
                <el-button
                  size="mini"
                  type="danger"
                  @click="handleDelete(scope.$index, scope.row)">Eliminar</el-button>
              </template>
            </el-table-column>
          </el-table>
    </el-main>
  </div>
</template>
<script>
export default {
  data(){
    return{
      dialogVisible:false,
      loading_btn:false,
      loading:false,
      load_tabla:false,
      descripcion:'',
      nivel:'',
      // hasta:'',

      tableData: []
    }
  },

  created(){
    this.listar_niveles();
  },

  methods:{
     handleEdit(index, row) {
          console.log(row.id);
          this.$router.push({name:'nivel', params:{ id: row.id }}).catch(error => {
            if (error.name != "NavigationDuplicated") {
              throw error;
            }
          });
      },
      handleDelete(index, row) {
        console.log(index, row);
      },
      ingresar_nivel(){
        this.loading = true;
        const data = {
          'descripcion':this.descripcion,
          'nivel':this.nivel,
          
        };
        axios.post('api/ingresar_nivel', data).then((res)=>{
            if(res.data.estado == "success"){

                this.descripcion = '';
                this.nivel = '';
                this.loading = false;
                this.$message({
                  message: res.data.mensaje,
                  type: 'success'
                  });
                  this.dialogVisible = false;
            }
          });
        
      },


      listar_niveles(){
        this.load_tabla= true;
        axios.get('api/listar_niveles').then((res)=>{
          if(res.data.estado=="success"){
             this.tableData = res.data.response;
             this.load_tabla = false;
          }
          this.load_tabla = false;

        });
      },
      
  }
}
</script>