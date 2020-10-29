 <template>
<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">casamario</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Categorías
                        <button type="button"  @click="abrirModal('categoria','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" id="opcion" name="opcion">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" id="texto" name="texto" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opcidddones</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="categoria in arrayCategoria" :key="categoria.id">
                                    <td>
                                        <button type="button" @click="abrirModal('categoria', 'actualizar',categoria)" class="btn btn-warning btn-sm" data-toggle="modal">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal">
                                          <i class="icon-trash"></i>
                                        </button>
                                        </td>

                                        <td v-text="categoria.nombre"></td>
                                        <td v-text="categoria.descripcion"></td>

                                        <td>
                                        <div v-if="categoria.condicion==1">
                                        <span class="badge badge-success">Activo</span>
                                        </div>

                                        <div v-else>
                                        <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#">Ant</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">4</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de categoría">
                                        <span class="help-block">(*) Ingrese el nombre de la categoría</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="Descripción...">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccionButton==1" class="btn btn-primary" @click="registrarCategoria()">Guardar</button>
                            <button type="button" v-if="tipoAccionButton==2" class="btn btn-primary">Actualizar</button>

                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            <!-- Inicio del modal Eliminar -->
            <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-danger" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Eliminar Categoría</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Estas seguro de eliminar la categoría?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-danger">Eliminar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Fin del modal Eliminar -->
        </main>
</template>

<script>
//axios nos ayuda hacer peticiones http desde el navegador
    export default {
        //dentro de la data colocamos las variables 
        data(){
          return {
            nombre : '',
            descripcion : '',
            //la data que regresa nuestro metodo listarCategoria se almacene en esta array
            arrayCategoria:[],
            modal : 0,
            //para saber que modal quiero mostrar, register o actualizar
            tituloModal : '',
            tipoAccionButton : 0
          }
        },
     //aqui estaran los metodos que me ayudaran hacer peticiones http e forma sencilla y convertir la respuesta en json
        methods: {
              
              listaCategoria(){
                  let me=this;
                  axios.get('/categoria/index').then(function (response) {
                      //todo lo que retorne esta funcion se almacene en este array
                        me.arrayCategoria= response.data;
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });

              },
          //Metodo registrar categoria
              registrarCategoria(){

                  let me=this;

                  axios.post('/categoria/registrar', {
                    'nombre':  this.nombre,
                    'descripcion': this.descripcion
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listaCategoria();
                })
                .catch(function (error) {
                    console.log(error);
                });

              },


              cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.descripcion='';

              },


//recibe tres paramatro el nombre del modelo "categoria",  accion "registrar o actualizar", el objeto "" 
              abrirModal(modelo, accion, data=[]){

                  switch(modelo){

                      case "categoria":
                     {
                         switch(accion){
                            
                             case 'registrar':
                            {
                                this.modal=1;
                                this.tituloModal='Registrar Categoria';
                                this.nombre='';
                                this.descripcion='';
                                this.tipoAccionButton=1;


                              break;
                             } 
                             
                             case 'actualizar':
                            {
                             break;
                             }   
                                 
                         } 
                      }
                  }

              }


        },
        mounted() {
       //hacemos referencia a nuestro metodo  listarCategoria
         this.listaCategoria();
        }
    }
</script>


<style>

.modal-content{
    width: 100% !important;
    position: absolute!important;
}
  .mostrar{
      display: list-item !important;
      opacity: 1 !important;
      position: absolute!important;
      background-color: #3c29297a;
  }
</style>
