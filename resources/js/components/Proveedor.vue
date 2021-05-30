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
                        <i class="fa fa-align-justify"></i> Proveedores
                        <button type="button"  @click="abrirModal('proveedor','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="contacto">contacto</option>
                                      <option value="telefono_contacto">Telefono</option>

                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarProveedor(1,buscar,criterio)"  class="form-control" placeholder="Buscar...">
                                    <button type="submit" @click="listarProveedor(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre - Razon social</th>
                                    <th>Tip doc</th>
                                    <th>Numero</th>
                                    <th>Dirección</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th>Contacto</th>
                                    <th>Telefono</th>
                                    <th>Opciones</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="proveedor in arrayProveedor" :key="proveedor.id">
                                     
                                        <td v-text="proveedor.id"></td>
                                        <td v-text="proveedor.persona.nombre"></td>
                                        <td v-text="proveedor.persona.tipo_documento"></td>
                                        <td v-text="proveedor.persona.num_documento"></td>
                                        <td v-text="proveedor.persona.direccion"></td>
                                        <td v-text="proveedor.persona.telefono"></td>
                                        <td v-text="proveedor.persona.email"></td>
                                        <td v-text="proveedor.contacto"></td>
                                        <td v-text="proveedor.telefono_contacto"></td>

                                     <td>
                                        <button type="button" @click="abrirModal('proveedor', 'actualizar',proveedor)" class="btn btn-outline-warning btn-sm" data-toggle="modal">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                    </td>    
                                       
                                </tr>
                                </tbody>
                        </table>
                        </div>
                        
                        <nav>

                                <ul class="pagination">
                                                                    <!--si la pagina actual > que 1-->

                                <li class="page-item" v-if="pagination.current_page > 1 ">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                                                <!--iteramos la propiedad computada-->

                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>

                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialo modal-primary modal-lg"  role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-bod">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                   <div class="col-md-6">  
                                       <label class="col-md-3 form-control-label text-negrita" for="text-input">Nombre - Razón social</label>
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre...">
                                    </div>
                                
                                   <div class="col-md-6">
                                       <label class="col-md-3 form-control-label text-negrita" for="text-input">Tipo documento</label>
                                        <select v-model="tipo_documento" class="form-control">
                                            <option value="CC">Cedula</option>
                                            <option value="TI">Tarjeta de Identida</option>
                                            <option value="PA">Pasaporte</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                  <div class="col-md-6">
                                    <label class="col-md-3 form-control-label text-negrita" for="text-input">Num documento</label>
                                        <input type="number" v-model="num_documento" class="form-control" placeholder="Numero de documento">
                                    </div>

                                  <div class="col-md-6">
                                    <label class="col-md-3 form-control-label text-negrita" for="text-input">Direccion</label>
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Dirección...">
                                    </div>
                                </div>


                                 <div class="form-group row">
                                   <div class="col-md-6">    
                                    <label class="col-md-3 form-control-label text-negrita" for="text-input">Telefono</label>
                                        <input type="text" v-model="telefono" class="form-control" placeholder="Telefono...">
                                    </div>

                                   <div class="col-md-6">
                                     <label class="col-md-3 form-control-label text-negrita" for="text-input">Email</label>
                                        <input type="text" v-model="email" class="form-control" placeholder="Email...">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-md-6">
                                       <label class="col-md-3 form-control-label text-negrita" for="text-input">Contacto</label>
                                        <input type="text" v-model="contacto" class="form-control" placeholder="contacto...">
                                    </div>
                                

                                   <div class="col-md-6">
                                        <label class="col-md-3 form-control-label text-negrita" for="text-input">Telefono de contacto</label>
                                        <input type="text" v-model="telefono_contacto" class="form-control" placeholder="Telefono de contacto...">
                                    </div>
                                </div>



                                <div v-show="errorProveedor==1" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMensajeProveedorArray" :key="error" v-text="error">
                                           
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccionButton==1" class="btn btn-outline-primary" @click="registrarProveedor()">Guardar</button>
                            <button type="button" v-if="tipoAccionButton==2" class="btn btn-outline-primary" @click="actualizarProveedor()">Actualizar</button>

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
            proveedor_id :0,
            nombre : '',
            tipo_documento: 'CC',
            num_documento: '',
            direccion: '',
            telefono:'',
            email: '',
            contacto: '',
            telefono_contacto:'',
            //la data que regresa nuestro metodo listarCategoria se almacene en esta array
            arrayProveedor:[],
            modal : 0,
            //para saber que modal quiero mostrar, register o actualizar
            tituloModal : '',
            tipoAccionButton : 0,
            errorProveedor : 0,
            errorMensajeProveedorArray : [],
            pagination : {
                //numero total de registro
                'total' : 0,
                //Obtenga el número de página actual.
                'current_page' : 0,
                //El número de elementos que se mostrarán por página.
                'per_page' : 0,
                //Obtenga el número de página de la última página disponible. (No disponible cuando se usa simplePaginate).
                'last_page' : 0,
                //desde la pagina
                'from'  : 0,
                //hasta pagina
                'to' : 0,
            },

            offset : 3,
            criterio : 'contacto',
            buscar  : '',
          }
        },

        //Propiedad computada declaramos unas funciones
        computed :{
            //calcular la pagina actual
            isActived : function(){
              return   this.pagination.current_page
            },
            //calcular el numero de paginas
            pagesNumber : function(){
                if(!this.pagination.to){
                    return [];
                }
                var from = this.pagination.current_page - this.offset; 
                if(from < 1){
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if(to >=  this.pagination.last_page){
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;  
            }
        },



     //aqui estaran los metodos. axios que me ayudaran hacer peticiones http e forma sencilla y convertir la respuesta en json
        methods: {
              
          listarProveedor(page, buscar, criterio){
              
                 let me=this;
                  var url= '/proveedor/index?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    //todo lo que retorne esta funcion se almacene en este array
                    me.arrayProveedor = respuesta.proveedor.data;
                    me.pagination = respuesta.pagination;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
              },
          
          //Metodo de cambiar pagina recibe un parametro de page "numero de la pagina que queremos mostrar"
                cambiarPagina(page, buscar, criterio){
                let me = this;
                //actualiza a la pagina actual
                me.pagination.current_page = page;
                //envia la peticion de listar esa pagina
                me.listarProveedor(page, buscar, criterio);
            },


          //Metodo registrar categoria
          registrarProveedor(){

                  if(this.validarArticulo()){
                      return ;
                  }
                  let me=this;
                  axios.post('/proveedor/registrar', {
                    'nombre':  this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento': this.num_documento,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'email':this.email,
                    'contacto':this.contacto,
                    'telefono_contacto':this.telefono_contacto, 
                })
                .then(function (response) {
                    me.cerrarModal();
                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listarProveedor(1,'','nombre');
                }) 
                .catch(function (error) {
                    console.log(error);
                });

              },


             //Metodo actualizar categoria
           actualizarProveedor(){

                  if(this.validarArticulo()){
                      return ;
                  }
                  let me=this;
                  axios.put('/proveedor/actualizar', {
                    'nombre':  this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento': this.num_documento,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'email': this.email,       
                    'contacto':this.contacto,
                    'telefono_contacto': this.telefono_contacto,
                    'id' :this.proveedor_id,     
                })
                .then(function (response) {
                    me.cerrarModal();
                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listarProveedor(1,'','nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });

              },

            //methods validar las categoria
            validarArticulo(){
                this.errorProveedor=0;
                 this.errorMensajeProveedorArray=[];
                 if(!this.nombre) this.errorMensajeProveedorArray.push("El nombre de la categoria no puede estar vacio");
                 if(!this.tipo_documento) this.errorMensajeProveedorArray.push("El documento es obligatorio");
                 if(!this.num_documento) this.errorMensajeProveedorArray.push("El numero de documento es obligatorio");
                 if(!this.direccion) this.errorMensajeProveedorArray.push("La dirección  es obligatorio");
                 if(!this.telefono) this.errorMensajeProveedorArray.push("El telefono  es obligatorio");
                 if(!this.email) this.errorMensajeProveedorArray.push("El email  es obligatorio");
                 if(!this.contacto) this.errorMensajeProveedorArray.push("El contacto  es obligatorio");
                 if(!this.telefono_contacto) this.errorMensajeProveedorArray.push("El telefono de contacto es obligatorio");

                 if(this.errorMensajeProveedorArray.length) this.errorProveedor=1;
                 return this.errorProveedor;
              },


           //metodo para cerrar el modal
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.tipo_documento='CC';
                this.num_documento='';
                this.direccion='';
                this.telefono='';
                this.email='';
                this.contacto='';
                this.telefono_contacto='';
                this.errorMensajeProveedorArray = [];
                this.errorProveedor = 0;

              },


              //recibe tres paramatro el nombre del modelo "categoria",  accion "registrar o actualizar", el objeto "" 
            abrirModal(modelo, accion, data=[]){
                  switch(modelo){
                      case "proveedor":
                     {
                         switch(accion){
                            
                             case 'registrar':
                            {
                                this.modal=1;
                                this.tituloModal='Registrar Proveedor';
                                this.nombre='';
                                this.num_documento='';
                                this.direccion='';
                                this.telefono='';
                                this.email='';
                                this.contacto='';
                                this.telefono_contacto='';
                                this.tipoAccionButton=1;
                              break;
                             } 
                             case 'actualizar':
                            {
                               // console.log(data);
                               this.modal=1;
                               this.tituloModal='Editar Proveedor';
                               this.tipoAccionButton=2;
                               this.proveedor_id=data['id'];
                               this.nombre=data['persona']['nombre'];
                               this.tipo_documento=data['persona']['tipo_documento'];
                               this.num_documento=data['persona']['num_documento'];
                               this.direccion=data['persona']['direccion'];
                               this.telefono=data['persona']['telefono'];
                               this.email=data['persona']['email'];
                               this.contacto=data['contacto'];
                               this.telefono_contacto=data['telefono_contacto'];

                             break;
                             }   
                                 
                         } 
                      }
                  }

              }
        },
        mounted() {
       //hacemos referencia a nuestro metodo  listarCategoria
      this.listarProveedor(1,this.buscar,this.criterio);     
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
   .text-negrita{
    color: black !important;
    font-weight: bold;
  }
  
  .moda{
    display: block !important; /* I added this to see the modal, you don't need this */
}
/* Important part */
.modal-dialo{
    overflow-y: initial !important
}
.modal-bod{
    height: 60vh;
    overflow-y: auto;
    margin: 10px 30px 10px 30px
}



</style>
