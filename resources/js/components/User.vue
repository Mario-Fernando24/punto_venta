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
                        <i class="fa fa-align-justify"></i> Usuario
                        <button type="button"  @click="abrirModal('usuario','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="usuario">usuario</option>

                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarUsuario(1,buscar,criterio)"  class="form-control" placeholder="Buscar...">
                                    <button type="submit" @click="listarUsuario(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tip doc</th>
                                    <th>Numero</th>
                                    <th>Dirección</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th>usuario</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="usuario in arrayUsuario" :key="usuario.id">
                                   
                                        <td v-text="usuario.personas.nombre"></td>
                                        <td v-text="usuario.personas.tipo_documento"></td>
                                        <td v-text="usuario.personas.num_documento"></td>
                                        <td v-text="usuario.personas.direccion"></td>
                                        <td v-text="usuario.personas.telefono"></td>
                                        <td v-text="usuario.personas.email"></td>
                                        <td v-text="usuario.usuario"></td>
                                        <td v-text="usuario.rol.nombre"></td>

                                        <td>
                                        <div v-if="usuario.condicion==1">
                                        <span class="badge badge-success">Activo</span>
                                        </div>

                                        <div v-else>
                                        <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        </td>


                                         <td>
                                        <button type="button" @click="abrirModal('usuario', 'actualizar',usuario)" class="btn btn-outline-warning btn-sm" data-toggle="modal">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;


                                        <template v-if="usuario.condicion"> 
                                            <button type="button"  class="btn btn-outline-danger btn-sm" @click="desactivarUsuario(usuario.id)">
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>

                                        <template v-else> 
                                            <button type="button"  class="btn btn-outline-success btn-sm" @click="activarUsuario(usuario.id)">
                                            <i class="icon-check"></i>
                                            </button>
                                        </template>


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
                                    <label class="col-md-3 form-control-label text-negrita" for="text-input">Nombre</label>
                                        <span class="color" v-if="!nombre">*</span>
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre completo...">
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
                                        <span class="color" v-if="!num_documento">*</span>
                                        <input type="number" v-model="num_documento" class="form-control" placeholder="Numero de documento">
                                    </div>
                                

                                  <div class="col-md-6">
                                    <label class="col-md-3 form-control-label text-negrita" for="text-input">Direccion</label>
                                        <span class="color" v-if="!direccion">*</span>
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Dirección...">
                                    </div>
                                </div>


                                 <div class="form-group row">
                                  <div class="col-md-6">
                                    <label class="col-md-3 form-control-label text-negrita" for="text-input">Telefono</label>
                                         <span class="color" v-if="!telefono">*</span>
                                        <input type="text" v-model="telefono" class="form-control" placeholder="Telefono...">
                                    </div>


                                  <div class="col-md-6">        
                                    <label class="col-md-3 form-control-label text-negrita" for="text-input">Email</label>
                                        <span class="color" v-if="!email">*</span>
                                        <input type="text" v-model="email" class="form-control" placeholder="Email...">
                                    </div>
                                </div>


                                <div class="form-group row">
                                 <div class="col-md-6">     
                                    <label class="col-md-3 form-control-label text-negrita" for="text-input">Rol</label>
                                        <span class="color" v-if="!idRol">*</span>
                                        <select class="form-control" v-model="idRol">
                                            <option value="0">Seleccione un rol</option>
                                            <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id" v-text="rol.nombre"></option>
                                        </select>

                                    </div>
                            

                                  <div class="col-md-6">
                                    <label class="col-md-3 form-control-label text-negrita" for="text-input">usuario</label>
                                        <span class="color" v-if="!usuario">*</span>
                                        <input type="text" v-model="usuario" class="form-control" placeholder="usuario...">
                                    </div>
                                </div>


                                <div class="form-group row">
                                  <div class="col-md-12">    
                                    <label class="col-md-3 form-control-label text-negrita" for="text-input">Contraseña</label>
                 


                                        <span class="color" v-if="!password">*</span>

                                        
                                        <input :type="type" v-model="password" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" placeholder="Contraseña de acceso...">
                                       
                                       
                                         <a class="btn btn-success" @click="showPassword">{{ btnText }} <span :class="icono"></span></a>




                                    </div>
                                </div>


                                <div v-show="errorUsuario==1" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMensajeArrayUsuario" :key="error" v-text="error">
                                           
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>



                        <div class="modal-footer">
                            <img v-if="isLoaded==true" src="https://miro.medium.com/max/882/1*9EBHIOzhE1XfMYoKz1JcsQ.gif" alt="logo" width="220" height="110">
                            <div v-if="isLoaded==false">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccionButton==1 && isLoaded==false" class="btn btn-outline-primary"  @click="registrarUsuario()">Guardar</button>
                            <button type="button" v-if="tipoAccionButton==2 && isLoaded==false" class="btn btn-outline-primary" @click="actualizarUsuario()">Actualizar</button>
                            </div>

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
            usuario_id :0,
            nombre : '',
            tipo_documento: 'CC',
            num_documento: '',
            direccion: '',
            telefono:'',
            email: '',
            usuario: '',
            password:'',
            idRol:0,

            isLoaded: false,

            //la data que regresa nuestro metodo listarusuario se almacene en esta array
            arrayUsuario:[],
            arrayRol:[],
            modal : 0,
            //para saber que modal quiero mostrar, register o actualizar
            tituloModal : '',
            tipoAccionButton : 0,
            errorUsuario : 0,
            errorMensajeArrayUsuario : [],
            type: 'password',
            btnText: 'Mostrar',
            icono:'fa fa-eye',

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
            criterio : 'usuario',
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
              
          listarUsuario(page, buscar, criterio){
              this.selectRol();
                 let me=this;
                  var url= '/user/index?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    console.log(respuesta);
                    //todo lo que retorne esta funcion se almacene en este array
                    me.arrayUsuario = respuesta.user.data;
                    me.pagination = respuesta.pagination;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
              },

              selectRol(){

                 let me=this;
                  var url= '/rol/select_rol';
                  axios.get(url).then(function (response) {
                      console.log(response.data);
                    var respuesta = response.data;
                    //todo lo que retorne esta funcion se almacene en este array
                    me.arrayRol = respuesta.roles;
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
                me.listarUsuario(page, buscar, criterio);
            },


          //Metodo registrar usuario
          registrarUsuario(){

                  if(this.validarUsuario()){
                      return ;
                  }
                  let me=this;
                  me.isLoaded = true;

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
                    me.isLoaded = false;

                    me.cerrarModal();
                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listarUsuario(1,'','nombre');
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
                  me.isLoaded = true;

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
                    'id' :this.usuario_id,     
                })
                .then(function (response) {
                    me.isLoaded = false;

                    me.cerrarModal();
                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listarUsuario(1,'','nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });

              },

            //methods validar las usuario
            validarUsuario(){
                this.errorUsuario=0;
                 this.errorMensajeArrayUsuario=[];
                 if(!this.nombre) this.errorMensajeArrayUsuario.push("El nombre del usuario no puede estar vacio");
                 if(!this.password) this.errorMensajeArrayUsuario.push("la contraseña es obligatorio");
                 if(this.idRol==0) this.errorMensajeArrayUsuario.push("Seleccione un rol para el usuario");

                 if(this.errorMensajeArrayUsuario.length) this.errorUsuario=1;
                 return this.errorUsuario;
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
                this.usuario='';
                this.password='';
                this.idRol=0;
                this.errorMensajeArrayUsuario = [];
                this.errorUsuario = 0;
                this.isLoaded = false;
              },


                   showPassword() {
                    if(this.type === 'password') {
                        this.type = 'text';
                        this.btnText = 'Ocultar';
                         this.icono='fa fa-eye-slash ';


                    } else {
                        this.type = 'password';
                        this.btnText = 'Mostrar';
                        this.icono='fa fa-eye';
                    }
                   },


                       //Metodo para desactivar la categoria
           desactivarUsuario(id){
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
                    me.listarUsuario(1,'','nombre');

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


            //Metodo para activar la categoria
            activarUsuario(id){
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Estas seguro de activar este Usuario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {

                     let me=this;
                  axios.put('/user/activar', {
                    'id' : id
                })
                .then(function (response) {
                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listarUsuario(1,'','nombre');

                    swalWithBootstrapButtons.fire(
                    'Activado',
                    'Usuario ha sido Activada correctamente',
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
                      case "usuario":
                     {
                         switch(accion){
                            
                             case 'registrar':
                            {
                                this.modal=1;
                                this.tituloModal='Registrar Usuario ';
                                this.nombre='';
                                this.tipo_documento='CC';
                                this.num_documento='';
                                this.direccion='';
                                this.telefono='';
                                this.email='';
                                this.usuario='';
                                this.password='';
                                this.idRol=0;
                                this.password='';

                                this.tipoAccionButton=1;
                              break;
                             } 
                             case 'actualizar':
                            {
                                this.selectRol();
                               // console.log(data);
                               this.modal=1;
                               this.tituloModal='Editar Usuario';
                               this.tipoAccionButton=2;
                               this.usuario_id=data['id'];
                               this.nombre=data['personas']['nombre'];
                               this.tipo_documento=data['personas']['tipo_documento'];
                               this.num_documento=data['personas']['num_documento'];
                               this.direccion=data['personas']['direccion'];
                               this.telefono=data['personas']['telefono'];
                               this.email=data['personas']['email'];
                               this.usuario=data['usuario'];
                               this.password=data['password'];
                               this.idRol=data['idrol']; 

                             break;
                             }   
                                 
                         } 
                      }
                  }

              }
        },
        mounted() {
       //hacemos referencia a nuestro metodo  listarusuario
      this.listarUsuario(1,this.buscar,this.criterio);     
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
  .color{
      color:red;
  }
</style>
