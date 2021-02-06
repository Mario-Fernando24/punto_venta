 <template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Perfil
                      
                    </div>
                    <div class="card-body">
                    

                        
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
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="Descripción...">
                                    </div>
                                </div>

                                <div v-show="errorCategoria==1" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMensajeCategoriaArray" :key="error" v-text="error">
                                           
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccionButton==2" class="btn btn-outline-primary" @click="actualizarCategoria()">Actualizar</button>

                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
     
        </main>
</template>

<script>
//axios nos ayuda hacer peticiones http desde el navegador
    export default {
        //dentro de la data colocamos las variables 
        data(){
          return {
            //cual es la categoria que quiero edit 
            categoria_id :0,
            nombre : '',
            descripcion : '',
            //la data que regresa nuestro metodo listarCategoria se almacene en esta array
            arrayCategoria:[],
            modal : 0,
            //para saber que modal quiero mostrar, register o actualizar
            tituloModal : '',
            tipoAccionButton : 0,
            errorCategoria : 0,
            errorMensajeCategoriaArray : [],
           
          }
        },



        computed :{
           
        },



     //aqui estaran los metodos. axios que me ayudaran hacer peticiones http e forma sencilla y convertir la respuesta en json
        methods: {
              
          listaCategoria(page, buscar, criterio){
              
                 let me=this;
                  var url= '/categoria/index?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    //todo lo que retorne esta funcion se almacene en este array
                    me.arrayCategoria = respuesta.categorias.data;
                    me.pagination = respuesta.pagination;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

              },
          

           actualizarCategoria(){

                  if(this.validarCategoria()){
                      return ;
                  }
                  let me=this;
                  axios.put('/categoria/actualizar', {
                    'nombre':  this.nombre,
                    'descripcion': this.descripcion,
                    'id' :this.categoria_id
                    
                })
                .then(function (response) {
                    me.cerrarModal();
                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listaCategoria(1,'','nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });

              },


            
            validarCategoria(){
                this.errorCategoria=0;
                 this.errorMensajeCategoriaArray=[];

                 if(!this.nombre) this.errorMensajeCategoriaArray.push("El nombre de la categoria no puede estar vacio");
                 if(this.errorMensajeCategoriaArray.length) this.errorCategoria=1;
                 return this.errorCategoria;
              },

            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.descripcion='';
                this.errorMensajeCategoriaArray = [];
                this.errorCategoria = 0;

              },


            abrirModal(modelo, accion, data=[]){
                  switch(modelo){
                      case "categoria":
                     {
                         switch(accion){
                            
                            
                             case 'actualizar':
                            {
                               // console.log(data);
                               this.modal=1;
                               this.tituloModal='Editar Categoria';
                               this.tipoAccionButton=2;
                               this.categoria_id=data['id'];
                               this.nombre=data['nombre'];
                               this.descripcion=data['descripcion'];
                             break;
                             }   
                                 
                         } 
                      }
                  }

              }
        },
        mounted() {
       //hacemos referencia a nuestro metodo  listarCategoria
      this.listaCategoria(1,this.buscar,this.criterio);     
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

  .div-error{
     display: flex;
     justify-content: center;
  }
  .text-error{
    color: red !important;
    font-weight: bold;
  }
</style>
