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
                        <i class="fa fa-align-justify"></i> Ingreso
                            <button type="button" @click="abrirModal('ingreso', 'registrar',ingreso)" class="btn btn-secondary btn-sm" data-toggle="modal">
                            <i class="icon-plus"></i>Nuevo
                             </button>


                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="num_comprobante">Num-Comprobante</option>
                                      <option value="tipo_comprobante">Tipo Comprobante</option>
                                      <option value="fecha_hora">Fecha-Hora</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarIngreso(1,buscar,criterio)"  class="form-control" placeholder="Buscar...">
                                    <button type="submit" @click="listarIngreso(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                      
                         <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Usuario</th>
                                            <th>Proveedor</th>
                                            <th>Tipo comprobante</th>
                                            <th>Serie Comprobante</th>
                                            <th>Num Comprobante</th>
                                            <th>Fecha</th>
                                            <th>Total</th>
                                            <th>Impuesto</th>
                                            <th>Estado</th>



                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="ingreso in arrayIngreso" :key="ingreso.id">
                                            <td >
                                                <button type="button" @click="abrirModal('ingreso', 'actualizar',ingreso)" class="btn btn-success btn-sm" data-toggle="modal">
                                                <i class="icon-eye"></i>
                                                </button> &nbsp;


                                                <template v-if="ingreso.estado=='registrado'"> 
                                                <button type="button"  class="btn btn-danger btn-sm" @click="anularIngreso(ingreso.id)">
                                                <i class="icon-trash"></i>
                                                </button>
                                                </template>
                                            </td>

                                                <td v-text="ingreso.persona.nombre"></td>
                                                <td v-text="ingreso.proveedoress.nombre"></td>
                                                <td v-text="ingreso.tipo_comprobante"></td>
                                                <td v-text="ingreso.serie_comprobante"></td>
                                                <td v-text="ingreso.num_comprobante"></td>
                                                <td v-text="ingreso.fecha_hora"></td>
                                                <td v-text="ingreso.total"></td>
                                                <td v-text="ingreso.impuesto"></td>


                                                <td>
                                                <div v-if="ingreso.estado=='registrado'">
                                                <span class="badge badge-success" v-text="ingreso.estado"></span>
                                                </div>

                                                <div v-else>
                                                <span class="badge badge-danger">Anulado</span>
                                                </div>
                                                </td>

                                                
                                                <td>  
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
            <!--Inicio del modal agregar/actualizar -->
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
                                        <span class="color" >Requerido(*)</span>
                                        <input type="text"  class="form-control" placeholder="Nombre...">
                                    </div>
                                </div>


                                <div v-show="errorIngreso==1" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMensajeArrayIngreso" :key="error" v-text="error">
                                           
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccionButton==1" class="btn btn-primary" @click="registrarUsuario()">Guardar</button>
                            <button type="button" v-if="tipoAccionButton==2" class="btn btn-primary" @click="actualizarUsuario()">Actualizar</button>

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
            //cual es la usuario que quiero edit 
            ingreso_id :0,
            idproveedor : 0,
            tipo_comprobante: 'Boleto',
            serie_comprobante : '',
            num_comprobante: '',
            telefono:'',
            impuesto: 0.18,
            total: 0.0,
            fecha_hora:'',

            //la data que regresa nuestro metodo listarIngreso se almacene en esta array
            arrayIngreso:[],
            arrayDetalleIngreso:[],


            modal : 0,
            //para saber que modal quiero mostrar, register o actualizar
            tituloModal : '',
            tipoAccionButton : 0,
            errorIngreso : 0,
            errorMensajeArrayIngreso : [],
          

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
            criterio : 'num_comprobante',
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
              
          listarIngreso(page, buscar, criterio){
                 let me=this;
                  var url= '/ingresos/index?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    //todo lo que retorne esta funcion se almacene en este array
                    me.arrayIngreso = respuesta.ingreso.data;
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
                me.listarIngreso(page, buscar, criterio);
            },


          //Metodo registrar usuario
          registrarUsuario(){

                  if(this.validarUsuario()){
                      return ;
                  }
                  let me=this;
                  axios.post('/user/registrar', {
                    'nombre':  this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento': this.num_documento,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'email':this.email,
                    'usuario':this.usuario,
                    'password':this.password, 
                    'idRol':this.idRol,

                })
                .then(function (response) {
                    me.cerrarModal();
                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listarIngreso(1,'','nombre');
                }) 
                .catch(function (error) {
                    console.log(error);
                });

              },


             //Metodo actualizar usuario
           actualizarUsuario(){

                  if(this.validarUsuario()){
                      return ;
                  }
                  let me=this;
                  axios.put('/user/actualizar', {
                    'nombre':  this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento': this.num_documento,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'email': this.email,       
                    'usuario':this.usuario,
                    'password': this.password,
                    'idRol':this.idRol,
                    'id' :this.ingreso_id,     
                })
                .then(function (response) {
                    me.cerrarModal();
                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listarIngreso(1,'','nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });

              },

            //methods validar las usuario
            validarUsuario(){
                this.errorIngreso=0;
                 this.errorMensajeArrayIngreso=[];
                 if(!this.nombre) this.errorMensajeArrayIngreso.push("El nombre del usuario no puede estar vacio");
                 if(!this.password) this.errorMensajeArrayIngreso.push("la contraseña es obligatorio");
                 if(this.idRol==0) this.errorMensajeArrayIngreso.push("Seleccione un rol para el usuario");

                 if(this.errorMensajeArrayIngreso.length) this.errorIngreso=1;
                 return this.errorIngreso;
              },


           //metodo para cerrar el modal
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.errorMensajeArrayIngreso = [];
                this.errorIngreso = 0;

              },


            //Metodo para desactivar la categoria
           anularIngreso(id){
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Estas seguro de desactivar esta Usuario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {

                     let me=this;
                  axios.put('/user/desactivar', {
                    'id' : id
                })
                .then(function (response) {

                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listarIngreso(1,'','nombre');

                    swalWithBootstrapButtons.fire(
                    'Desactivado',
                    'Usuario ha sido desactivado correctamente',
                    'success'
                    )
                })
                .catch(function (error) {
                    console.log(error);
                });

                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                    'Cancelado',
                    '',
                    'error'
                    )
                }
                })
           },


              //recibe tres paramatro el nombre del modelo "usuario",  accion "registrar o actualizar", el objeto "" 
            abrirModal(modelo, accion, data=[]){
                  switch(modelo){
                      case "ingreso":
                     {
                         switch(accion){
                            
                             case 'registrar':
                            {
                                this.modal=1;
                                this.tituloModal='Registrar Compra';
                                this.tipoAccionButton=1;
                              break;
                             } 
                             case 'actualizar':
                            {
                                                                console.log('actualizar');

                               this.modal=1;
                               this.tituloModal='Editar Compra';
                               this.tipoAccionButton=2;

                             break;
                             }   
                                 
                         } 
                      }
                  }

              }
        },
        mounted() {
       //hacemos referencia a nuestro metodo  listarIngreso
      this.listarIngreso(1,this.buscar,this.criterio);     
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

  .color{
      color:red;
  }
</style>
