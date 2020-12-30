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
                        <i class="fa fa-align-justify"></i> Cajas
                        <button type="button"  @click="abrirCaja('apertura','registrar')" class="btn btn-info">
                            <i class="icon-plus"></i>&nbsp;Apertura de caja
                        </button>

                        <button type="button" class="btn btn-warning">
                            <i class="icon-doc"></i>&nbsp;Cierre de caja
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
                                    <input type="text" v-model="buscar" @keyup.enter="listaCategoria(1,buscar,criterio)"  class="form-control" placeholder="Buscar...">
                                    <button type="submit" @click="listaCategoria(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="categoria in arrayCategoria" :key="categoria.id">
                                    <td>
                                        <button type="button" @click="abrirCaja('categoria', 'actualizar',categoria)" class="btn btn-outline-warning btn-sm" data-toggle="modal">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        
                                        <template v-if="categoria.condicion"> 
                                        <button type="button"  class="btn btn-outline-danger btn-sm" @click="desactivarCategoria(categoria.id)">
                                          <i class="icon-trash"></i>
                                        </button>
                                        </template>
                                         <template v-else> 
                                        <button type="button"  class="btn btn-outline-success btn-sm" @click="activarCategoria(categoria.id)">
                                          <i class="icon-check"></i>
                                        </button>
                                        </template>

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

                        <div class="form-group col border">
                           <div class="table-responsive col-md-12">
                                 <table class="table table-bordered table-striped table-sm">
                                    
                                     <thead>
                                         <tr>

                                            <th>Denominación</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                    <tr>

                                         <tr>
                                            <th>$ 100.000</th>
                                            <td>
                                                <div class="col-md-8">
                                                    <input min="0" type="number" v-model="moneyInitial.cienmil"  class="form-control" placeholder="cien mil">
                                               </div>
                                            </td>
                                            <td v-text="Intl.NumberFormat().format(moneyInitial.cienmil*100000)"></td>
                                         </tr>


                                         <tr>
                                            <th>$ 50.000</th>
                                            <td>
                                                <div class="col-md-8">
                                                    <input type="number" min="0" v-model="moneyInitial.cincuentamil" class="form-control" placeholder="cincuenta mil">
                                               </div>

                                            </td>

                                            <td v-text="Intl.NumberFormat().format(moneyInitial.cincuentamil*50000)"></td>
                                         </tr>


                                         <tr>
                                            <th>$ 20.000</th>
                                            <td>

                                                <div class="col-md-8">
                                                    <input type="number" min="0" v-model="moneyInitial.veintemil" class="form-control" placeholder="veinte mil">
                                               </div>

                                            </td>
                                            <td v-text="Intl.NumberFormat().format(moneyInitial.veintemil*20000)"></td>
                                         </tr>



                                         <tr>
                                            <th>$ 10.000</th>
                                            <td>

                                                <div class="col-md-8">
                                                    <input type="number" min="0" v-model="moneyInitial.diezmil" class="form-control" placeholder="diez mil">
                                               </div>

                                            </td>
                                            <td v-text="Intl.NumberFormat().format(moneyInitial.diezmil*10000)"></td>
                                         </tr>



                                         <tr>
                                            <th>$ 5.000</th>
                                            <td>

                                                <div class="col-md-8">
                                                    <input type="number" min="0" v-model="moneyInitial.cincomil" class="form-control" placeholder="cinco mil">
                                               </div>

                                            </td>
                                            <td v-text=" Intl.NumberFormat().format(moneyInitial.cincomil*5000)"></td>
                                         </tr>



                                         <tr>
                                            <th>$ 2.000</th>
                                            <td>

                                                <div class="col-md-8">
                                                    <input type="number" min="0" v-model="moneyInitial.dosmil" class="form-control" placeholder="dos mil">
                                               </div>

                                            </td>
                                            <td v-text=" Intl.NumberFormat().format(moneyInitial.dosmil*2000)"></td>
                                         </tr>



                                         <tr>
                                            <th>$ 1.000</th>
                                            <td>

                                                <div class="col-md-8">
                                                    <input type="number" min="0" v-model="moneyInitial.mil" class="form-control" placeholder="mil">
                                               </div>

                                            </td>
                                            <td v-text=" Intl.NumberFormat().format(moneyInitial.mil*1000)"></td>
                                         </tr>


                                         <tr>
                                            <th>$ 500</th>
                                            <td>

                                                <div class="col-md-8">
                                                    <input type="number" min="0" v-model="moneyInitial.quiniento" class="form-control" placeholder="quinientos">
                                               </div>

                                            </td>
                                            <td v-text=" Intl.NumberFormat().format(moneyInitial.quiniento*500)"></td>
                                         </tr>

                                         <tr>
                                            <th>$ 200</th>
                                            <td>

                                                <div class="col-md-8">
                                                    <input type="number" min="0" v-model="moneyInitial.dociento" class="form-control" placeholder="docientos">
                                               </div>

                                            </td>
                                            <td v-text=" Intl.NumberFormat().format(moneyInitial.dociento*200)"></td>
                                         </tr>

                                          <tr>
                                            <th>$ 100</th>
                                            <td>

                                                <div class="col-md-8">
                                                    <input type="number" min="0" v-model="moneyInitial.cien" class="form-control" placeholder="cien">
                                               </div>

                                            </td>
                                            <td v-text=" Intl.NumberFormat().format(moneyInitial.cien*100)"></td>
                                         </tr>

                                         <tr>
                                            <th>$ 50</th>
                                            <td>

                                                <div class="col-md-8">
                                                    <input type="number" min="0" v-model="moneyInitial.cincuenta" class="form-control" placeholder="ciencienta">
                                               </div>
                                               
                                            </td>
                                            <td v-text=" Intl.NumberFormat().format(moneyInitial.cincuenta*50)"></td>
                                         </tr>


                                        <tr class="totalresultado" >
                                             <td></td>
                                             <td align="right"><strong>Dinero total :</strong></td>
                                             <td class="text-error" v-text="Intl.NumberFormat().format(calcularTotalAperturaCaja)"></td>
                                         </tr>



                
                                     </tbody>
                                 </table>
                           </div>

                           

                             <div class="form-group row">
                                    <label class="col-md-12 form-control-label" for="text-input"><b>Observación Apertura de caja</b></label>
                                    <div class="col-md-12">
                                        <textarea class="col-md-12" v-model="observacion_apertura" type="text"></textarea>
                                    </div>
                                </div>





                        <div class="form-group row">
                           <div class="col-md-12">
                               <button type="button"  class="btn btn-secondary">Cerrar</button>
                              <button type="button" class="btn btn-outline-primary" @click="apertura_de_caja()">Grabar</button>
                           </div>
                        </div>

                       </div>
                             
                            
                                
                            </form>
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

       moneyInitial: {
       cincuenta: 0 ,
       cien: 0 ,
       dociento: 0 ,
       quiniento: 0 ,
       mil: 0 ,
       dosmil: 0 ,
       cincomil: 0 ,
       diezmil: 0 ,
       veintemil: 0 ,
       cincuentamil: 0 ,
       cienmil: 0 
        },
      observacion_apertura:'sin ninguna novedad',  


        




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
            },

             calcularTotalAperturaCaja : function(){
                var resultado=0.0;

                resultado=(this.moneyInitial.cienmil*100000)+(this.moneyInitial.cincuentamil*50000)+(this.moneyInitial.veintemil*20000)
                +(this.moneyInitial.diezmil*10000)+(this.moneyInitial.cincomil*5000)+(this.moneyInitial.dosmil*2000)+(this.moneyInitial.mil*1000)
                +(this.moneyInitial.quiniento*500)+(this.moneyInitial.dociento*200)+(this.moneyInitial.cien*100)+(this.moneyInitial.cincuenta*50);
                return resultado;
            },

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
          
          //Metodo de cambiar pagina recibe un parametro de page "numero de la pagina que queremos mostrar"
                cambiarPagina(page, buscar, criterio){
                let me = this;
                //actualiza a la pagina actual
                me.pagination.current_page = page;
                //envia la peticion de listar esa pagina
                me.listaCategoria(page, buscar, criterio);
            },


          //Metodo registrar categoria
          apertura_de_caja(){

                 console.log(this.calcularTotalAperturaCaja);
                 console.log(this.observacion_apertura);
                 console.log(this.moneyInitial);

                  let me=this;
                  axios.post('/caja/aperturaCaja', {
                    'Cajainicial':  this.calcularTotalAperturaCaja,
                    'obs_apertura':  this.observacion_apertura,
                    'dinero_inicial': this.moneyInitial,
                })
                .then(function (response) {
                    console.log('ok mario');
               //     me.cerrarModal();
                //    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
               //     me.listaCategoria(1,'','nombre');
                }) 
                .catch(function (error) {
                    console.log(error);
                });

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
                    me.listaCategoria(1,'','nombre');
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
                    me.listaCategoria(1,'','nombre');
                })
                .catch(function (error) {
                    console.log(error);
                });

              },
           //Metodo para desactivar la categoria
           desactivarCategoria(id){
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Estas seguro de desactivar esta categoria?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {

                     let me=this;
                  axios.put('/categoria/desactivar', {
                    'id' : id
                })
                .then(function (response) {

                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listaCategoria(1,'','nombre');

                    swalWithBootstrapButtons.fire(
                    'Desactivado',
                    'La categoria ha sido desactivado correctamente',
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
              window.open('http://127.0.0.1:8000/categoria/ListarPdfCategoria','_blank');
           },


            //Metodo para activar la categoria
            activarCategoria(id){
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Estas seguro de activar esta categoria?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {

                     let me=this;
                  axios.put('/categoria/activar', {
                    'id' : id
                })
                .then(function (response) {
                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listaCategoria(1,'','nombre');

                    swalWithBootstrapButtons.fire(
                    'Activado',
                    'La categoria ha sido Activada correctamente',
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
            abrirCaja(modelo, accion, data=[]){
                  switch(modelo){
                      case "apertura":
                     {
                         switch(accion){
                            
                             case 'registrar':
                            {
                                this.modal=1;
                                this.tituloModal='Apertura de caja';
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
