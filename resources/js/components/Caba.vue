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
                        <i class="fa fa-align-justify"></i>Pendientes Cabas
                       
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listaClienteCaba(1,buscar,criterio)"  class="form-control" placeholder="Buscar...">
                                    <button type="submit" @click="listaClienteCaba(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Telefono</th>
                                    <th>Direccion</th>
                                    <th>Fecha Entrega</th>
                                    <th>Vendedor</th>
                                    <th>Observación</th>
                                    <th>Estados</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="categoria in arrayBodega" :key="categoria.id">
                                    
                                        <td v-text="categoria.id"></td>
                                        <td v-text="categoria.cliente_persona.nombre"></td>
                                        <td v-text="categoria.cliente_persona.telefono"></td>
                                        <td v-text="categoria.cliente_persona.direccion"></td>
                                        <td v-text="categoria.created_at"></td>
                                        <td v-text="categoria.usuario_hizola_venta.usuario"></td>
                                        <td v-text="categoria.num_comprobante_pago"></td>

                                    <td>
                                        <div v-if="categoria.fechaentregacaba!=''">
                                        <span class="badge badge-danger">Pendiente</span>
                                        </div>

                                        <div v-else>
                                        <span class="badge badge-success">Entregada</span>
                                        </div>
                                    </td>


                                    <td>
                                      
                                        <template v-if="categoria.caba=='si'"> 
                                        <button type="button"  class="btn btn-outline-danger btn-sm" @click="entregarCaba(categoria.id)">
                                          <i class="icon-trash"></i>
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
            arrayBodega:[],
            modal : 0,
            //para saber que modal quiero mostrar, register o actualizar
            tituloModal : '',
            tipoAccionButton : 0,
            errorCategoria : 0,
            errorMensajeCategoriaArray : [],
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

            listaClienteCaba(page, buscar, criterio){
                 let me=this;
                  var url= '/bodega/index?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    //todo lo que retorne esta funcion se almacene en este array
                    me.arrayBodega = respuesta.venta.data;
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
                me.listaClienteCaba(page, buscar, criterio);
            },


          //Metodo registrar categoria
          registrarCategoria(){

                  if(this.validarCategoria()){
                      return ;
                  }
                  let me=this;
                  axios.post('/categoria/registrar', {
                    'nombre':  this.nombre,
                    'descripcion': this.descripcion
                })
                .then(function (response) {
                    me.cerrarModal();
                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listaClienteCaba(1,'','nombre');
                }) 
                .catch(function (error) {
                    console.log(error);
                });

              },


             //Metodo actualizar categoria
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
                    me.listaClienteCaba(1,'','nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });

              },
           //Metodo para desactivar la categoria
           entregarCaba(id){
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Estas seguro de devolver la caba?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {

                     let me=this;
                  axios.put('/bodega/devolucioncaba', {
                    'id' : id
                })
                .then(function (response) {

                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listaClienteCaba(1,'','nombre');

                    swalWithBootstrapButtons.fire(
                    'ENTREGADO',
                    'GUARDAR LA CABA EN BODEGA',
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
           cargarPdfCategoria(){
              window.open('/categoria/ListarPdfCategoria','_blank');
           },


            
           

              //methods validar las categoria
            validarCategoria(){
                this.errorCategoria=0;
                 this.errorMensajeCategoriaArray=[];

                 if(!this.nombre) this.errorMensajeCategoriaArray.push("El nombre de la categoria no puede estar vacio");
                 if(this.errorMensajeCategoriaArray.length) this.errorCategoria=1;
                 return this.errorCategoria;
              },


           //metodo para cerrar el modal
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.descripcion='';
                this.errorMensajeCategoriaArray = [];
                this.errorCategoria = 0;

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
      this.listaClienteCaba(1,this.buscar,this.criterio);     
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
  
</style>
