 <template>
<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>

            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">



                        <i class="fa fa-align-justify"></i> Articulos
                        <button type="button"  @click="abrirModal('articulo','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        <button type="button"  @click="cargarPdfInventario()" class="btn btn-outline-danger">
                            <i class="icon-doc"></i>&nbsp;Descargar pdf
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarArticulo(1,buscar,criterio)"  class="form-control" placeholder="Buscar...">
                                    <button type="submit" @click="listarArticulo(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Categoria</th>
                                    <th>Pre Venta</th>
                                    <th>Stock</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>     
                                    <th>Avatar</th>                                
                                    <th>Opciones</th>


                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                    
                                        <td v-text="articulo.codigo"></td>
                                        <td v-text="articulo.nombre"></td>
                                        <td v-text="articulo.categoria.nombre"></td>
                                        <td v-text="articulo.precio_venta"></td>


                                        <template v-if="articulo.stock<=5 && articulo.stock>0">
                                        <td><span class="badge bg-warning" v-text="articulo.stock"></span></td>
                                        </template>
                                        <template v-if="articulo.stock<=0">
                                        <td><span class="badge bg-danger" v-text="articulo.stock"></span></td>
                                        </template>



                                        <template v-if="articulo.stock>5">
                                        <td v-text="articulo.stock"></td>
                                        </template>


                                        <td v-text="articulo.descripcion"></td>

                                        <td>
                                        <div v-if="articulo.condicion==1">
                                        <span class="badge badge-success">Activo</span>
                                        </div>

                                        <div v-else>
                                        <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                    </td>

                                    <td v-if="articulo.avatar=='' || articulo.avatar==null || articulo.avatar=='no-image.png' || articulo.avatar=='' ">
                                        <img style="height: 60px; width: 80px"  src="img/no-image.png" class="rounded-circle">                
                                        </td>
                                        <td v-else>
                                        <img style="height: 60px; width: 80px"  :src="'/img/productos/' + articulo.avatar" class="rounded-circle">                
                                    </td>



                                    <td>
                                        <button type="button" @click="abrirModal('articulo', 'editarImagen',articulo)"    class="btn btn-outline-success btn-sm" data-toggle="modal">
                                          <i class="icon-picture"></i>
                                        </button> &nbsp;

                                        <button type="button" @click="abrirModal('articulo', 'actualizar',articulo)" class="btn btn-outline-warning btn-sm" data-toggle="modal">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="articulo.condicion==1"> 
                                        <button type="button"  class="btn btn-outline-danger btn-sm" @click="desactivarArticulo(articulo.id)">
                                          <i class="icon-trash"></i>
                                        </button>
                                        </template>
                                         <template v-else> 
                                        <button type="button"  class="btn btn-outline-success btn-sm" @click="activarArticulo(articulo.id)">
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
                                    <label class="col-md-3 form-control-label text-negrita" for="text-input">Categoria</label>
                                        <select class="form-control" v-model="idcategoria" >
                                            <option value="0">seleccione</option>
                                            <option v-for="categoria in  arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                        </select>
                                    </div>
                                
                               <div class="col-md-6">
                                    <label class="col-md-3 form-control-label text-negrita" for="text-input">Codigo</label>
                                     <span class="color" v-if="validarcode">El codigo de barra ya existe(*)</span>
                                        <input type="text" v-on:keyup="validateCodigoBarra()" v-model="codigo" class="form-control" placeholder="codigo de barra">
                                    <barcode :value="codigo" :options="{ format: 'EAN-13' }">
                                        Generando codigo de barra
                                    </barcode>
                                    </div>
                                </div>



        
                                <!--colocar max 15 caracter codigo de barra-->

                                <div class="form-group row">
                                  <div class="col-md-6">
                                    <label class="col-md-3 form-control-label text-negrita" for="text-input">Nombre</label>
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre...">
                                    </div>
                                
                                 <div class="col-md-6">
                                    <label class="col-md-3 form-control-label text-negrita" for="text-input">Precio de venta</label>
                                        <input type="number" disabled v-model="precio_venta" class="form-control" placeholder="Precio...">
                                    </div>
                                </div>

                                <div class="form-group row">
                                  <div class="col-md-6">
                                    <label class="col-md-3 form-control-label text-negrita" for="text-input">Stock</label>
                                        <input disabled type="number" v-model="stock" class="form-control" placeholder="Stock...">
                                    </div>


                                 <div class="col-md-6">
                                    <label class="col-md-3 form-control-label text-negrita" for="email-input">Descripción</label>
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="Descripción...">
                                    </div>
                                </div>

                                <div v-show="errorArticulo==1" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMensajeArticuloArray" :key="error" v-text="error">
                                           
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccionButton==1" class="btn btn-outline-primary" @click="registrarArticulo()">Guardar</button>
                            <button type="button" v-if="tipoAccionButton==2" class="btn btn-outline-primary" @click="actualizarArticulo()">Actualizar</button>

                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->   

            </div>









        <!--inicio modal editar imagen-->


              <div class="modal fade"  tabindex="-1" :class="{'mostrar':modalImagen}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg"  role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()"  aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>


                        <form  @submit="editarProductImagen" enctype="multipart/form-data">
                        
                        <div class="modal-body">
                            <div class="form-group row">
                                    <div class="col-md-12 ">
                                       <label class="col-md-12 form-control-label text-negrita " for="text-input">Imagen Articulo</label>
                                    <input type="file" class="form-control" accept="image/*"   v-on:change="onEditarImagen"/>
                                    <div class="descripcion">
                                        <br><b>Limite de 3 MB  imagen<br>
                                        Tipos permitidos: jpeg, png, jpg, svg; </b><br>
                                    </div>
                                    </div>
                            </div>
                        </div>   

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button   class="btn btn-outline-primary" >Actualizar</button>

                        </div>
                        </form>

                    </div>
                </div>

            </div> 

            <!--final modal editar imagen-->




     
        </main>
</template>

<script>
//importamos vueBarcod
import VueBarcode from 'vue-barcode';

//axios nos ayuda hacer peticiones http desde el navegador
    export default {
        //dentro de la data colocamos las variables 
        data(){
          return {
          validarcodigoBarra:'',
            //cual es la categoria que quiero edit 
            articulo_id :0,
            idcategoria :0,
            nombre_categoria :'',
            codigo : '',
            nombre : '',
            precio_venta:1,
            stock:0,
            descripcion : '',
            actividades: [],
            //la data que regresa nuestro metodo listarCategoria se almacene en esta array
            arrayArticulo:[],

            modal : 0,
            //para saber que modal quiero mostrar, register o actualizar
            tituloModal : '',
                        validarcode : '',

            tipoAccionButton : 0,
            errorArticulo : 0,
            errorMensajeArticuloArray: [],
            pagination : {
                //numero total de registro
                'total' : 0,
                //Obtenga el número de página actual.
                'current_page' : 0,
                //El número de elementos que se mostrarán por página.
                'per_page' : 0,
              //  Obtenga el número de página de la última página disponible. (No disponible cuando se usa simplePaginate).
                'last_page' : 0,
                //desde la pagina
                'from'  : 0,
                //hasta pagina
                'to' : 0,
            },

            offset : 3,
            criterio : 'nombre',
            arrayCategoria:[],
            buscar  : '',
            modalImagen: 0,


          }
        },

         components: {
           'barcode': VueBarcode
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
            },

        },



     //aqui estaran los metodos. axios que me ayudaran hacer peticiones http e forma sencilla y convertir la respuesta en json
        methods: {
        validateCodigoBarra: function() {
      

                  let me=this;
                  let aux='';

                  axios.get('/articulo/validateCodeBarra?filtro='+this.codigo).then(function (response) {

                    var respuestaaa=response.data;
                    aux=respuestaaa.validate;
                    me.validarcode=aux;

                    
                    console.log(aux);


                    })
                    .catch(function (error) {
                        console.log(error);
                    });



        }

,
              
          listarArticulo(page, buscar, criterio){
                 let me=this;
                  var url= '/articulo/index?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    //todo lo que retorne esta funcion se almacene en este array
                    me.arrayArticulo = respuesta.articulos.data;
                    me.pagination = respuesta.pagination;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });

              },
                    

              //
              selectCategoria(){

                  let me=this;
                  axios.get('/categoria/mostrarCategoriaActivas').then(function (response) {

                    var respuestaaa=response.data;
                    me.arrayCategoria= respuestaaa.categorias.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

              } ,
          
          //Metodo de cambiar pagina recibe un parametro de page "numero de la pagina que queremos mostrar"
                cambiarPagina(page, buscar, criterio){
                let me = this;
                //actualiza a la pagina actual
                me.pagination.current_page = page;
                //envia la peticion de listar esa pagina
                me.listarArticulo(page, buscar, criterio);
            },


          //Metodo registrar categoria
          registrarArticulo(){

                  if(this.validarArticulo()){
                      return ;
                  }
                  let me=this;
                  axios.post('/articulo/registrar', {
                    'idcategoria':  this.idcategoria,
                    'nombre':  this.nombre,
                    'codigo': this.codigo,
                    'stock':  this.stock,
                    'precio_venta':  this.precio_venta,
                    'descripcion':  this.descripcion

                })
                .then(function (response) {
                    me.cerrarModal();
                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listarArticulo(1,'','nombre');
                }) 
                .catch(function (error) {
                    console.log(error);
                });

              },


             //Metodo actualizar categoria
           actualizarArticulo(){

                  if(this.validarArticulo()){
                      return ;
                  }
                  let me=this;
                  axios.put('/articulo/actualizar', {
                   'idcategoria':  this.idcategoria,
                    'nombre':  this.nombre,
                    'codigo' : this.codigo,
                    'stock':  this.stock,
                    'precio_venta':  this.precio_venta,
                    'descripcion':  this.descripcion,
                    'id' :this.articulo_id
                    
                })
                .then(function (response) {
                    me.cerrarModal();
                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listarArticulo(1,'','nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });

              },






                   //==================editar imagenes==========================//
        onEditarImagen(e){
            console.log(e.target.files[0]);
          this.editarProductImag = e.target.files[0];
        },
      editarProductImagen(e){
     
        let me=this;
          e.preventDefault();
          let currentObj = this;
          const config = {
              headers: { 'content-type': 'multipart/form-data' }
          }
          let formData = new FormData();
          formData.append('editarProductImagen', this.editarProductImag);
          formData.append('articulo_id', this.articulo_id);
          axios.post('/articulo/editarImagen', formData, config)
          .then(function (response) {
            if(response.data.status){
                me.editarProductImag='';
                    me.cerrarModal();
                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listarArticulo(1,'','nombre');
              Swal.fire(
                'Exitoso?',
                'Imagen editada correctamente',
                'success'
                )
            }
              currentObj.success = response.data.success; 
          })
          .catch(function (error) {
              currentObj.output = error;
          });
    },    






           //Metodo para desactivar la categoria
           desactivarArticulo(id){
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Estas seguro de desactivar este Articulo?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {

                     let me=this;
                  axios.put('/articulo/desactivar', {
                    'id' : id
                })
                .then(function (response) {

                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listarArticulo(1,'','nombre');

                    swalWithBootstrapButtons.fire(
                    'Desactivado',
                    'El articulo ha sido desactivado correctamente',
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
            activarArticulo(id){
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Estas seguro de activar este Articulo?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {

                     let me=this;
                  axios.put('/articulo/activar', {
                    'id' : id
                })
                .then(function (response) {
                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listarArticulo(1,'','nombre');

                    swalWithBootstrapButtons.fire(
                    'Activado',
                    'El Articulo ha sido Activada correctamente',
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

           cargarPdfInventario(){
              window.open('/articulo/ListarPdfInventario','_blank');
           },
           

              //methods validar las categoria
            validarArticulo(){
                 this.errorArticulo=0;
                 this.errorMensajeArticuloArray=[];
                 if(this.idcategoria==0) this.errorMensajeArticuloArray.push("* Seleccione alguna categoria");
                 if(!this.nombre) this.errorMensajeArticuloArray.push("* El nombre del articulo no puede estar vacio");
               //  if(!this.stock) this.errorMensajeArticuloArray.push("* El stock del producto debe ser un numero y no puede estar vacio");
                 if(!this.precio_venta) this.errorMensajeArticuloArray.push("* El precio del producto debe ser un numero  y no puede  estar vacio");
                 if(!this.descripcion) this.errorMensajeArticuloArray.push("* la descripcion del producto debe ser un numero  y no puede  estar vacio");
                 if(this.errorMensajeArticuloArray.length) this.errorArticulo=1;
                 return this.errorArticulo;
              },

           //metodo para cerrar el modal
            cerrarModal(){
                this.modalImagen=0;
                this.modal=0;
                this.tituloModal='';
                this.idcategoria =0;
                this.nombre_categoria ='';
                this.codigo = '';
                this.nombre='';
                this.precio_venta=1;
                this.stock=0;    
                this.descripcion='';
              //  this.errorMensajeArticuloArray = [];
                this.errorArticulo = 0;

              },

            //recibe tres paramatro el nombre del modelo "categoria",  accion "registrar o actualizar", el objeto "" 
            abrirModal(modelo, accion, data=[]){
                  switch(modelo){
                      case "articulo":
                     {
                         switch(accion){
                            
                             case 'registrar':
                            {               
                                this.modal=1;
                                this.tituloModal='Registrar Articulo';
                                this.idcategoria =0;
                                this.nombre_categoria ='';
                                this.codigo = '';
                                this.nombre='';
                                this.precio_venta=1;
                                this.stock=0;    
                                this.descripcion='';
                                this.tipoAccionButton=1;
                              break;
                             } 
                             case 'actualizar':
                            {
                               // console.log(data);
                               this.modal=1;
                               this.tituloModal='Editar Articulo';
                               this.tipoAccionButton=2;
                               this.articulo_id=data['id'];
                               this.idcategoria=data['idcategoria'];
                               this.codigo=data['codigo'];
                               this.nombre=data['nombre'];
                               this.stock=data['stock'];
                               this.precio_venta=data['precio_venta'];
                               this.descripcion=data['descripcion'];
                             break;
                             }   

                                case 'editarImagen':
                              {
                                                                  this.modalImagen=1;
                                this.tituloModal='Editar imagen';
                                this.tipoAccionButton=3;
                                this.articulo_id=data['id'];
                                console.log('editarImagen'+data['id']);

                                break;
                             }   

                                 
                         } 
                      }
                  }
                this.selectCategoria();

              }
        },
        mounted() {
       //hacemos referencia a nuestro metodo  listarCategoria
      this.listarArticulo(1,this.buscar,this.criterio);     
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
