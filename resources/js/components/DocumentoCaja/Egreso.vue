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
                        <i class="fa fa-align-justify"></i> Egreso
                        <button v-if="validar_caja=='ok'" type="button"  @click="abrirModal('egreso','documento')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Documento de caja
                        </button>

                    </div>


                    <div class="card-body" v-if="validar_caja=='error'">
                        <div class="table-responsive">
                          <table class="table table-bordered table-striped table-sm">
                            <tbody>
                                <h1>Caja Cerrada</h1>
                            </tbody>
                        </table>
                        </div>
                    </div>


                    <div class="card-body" v-if="validar_caja=='ok'">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="tipo_egreso">Tipo Documento</option>
                                      <option value="valor_egreso">Valor</option>
                                      <option value="motivo_egreso">motivo Documento</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarEgreso(1,buscar,criterio)"  class="form-control" placeholder="Buscar...">
                                    <button type="submit" @click="listarEgreso(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tipo</th>
                                    <th>Valor</th>
                                    <th>Motivo</th>
                                    <th>Usuario</th>
                                    <th>Estado</th>
                                    <th>Opción</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="egreso in arraEgreso" :key="egreso.id">
                                    
                                        <td v-text="egreso.idegreso"></td>
                                        <td v-text="egreso.tipo_egreso"></td>
                                        <td v-text="egreso.valor_egreso"></td>
                                        <td v-text="egreso.motivo_egreso"></td>
                                        <td v-text="egreso.get_user.usuario"></td>



                                    <td>


                                        <div v-if="egreso.estado==1">
                                        <span class="badge badge-success">Activo</span>
                                        </div>

                                        <div v-else>
                                        <span class="badge badge-danger">Anulado</span>
                                        </div>
                                    </td>


                                    <td>
                                        
                                        <template v-if="egreso.estado"> 
                                        <button @click="AnularDocumentoDeCaja(egreso.idegreso, egreso.tipo_egreso)" type="button"  class="btn btn-outline-danger btn-sm" >
                                          <i class="icon-trash"></i>
                                        </button>


                                         <button type="button" @click="descargarEgreso(egreso.idegreso)" class="btn btn-outline-warning btn-sm" data-toggle="modal">
                                          <i class="icon-cloud-download"></i> 
                                        </button> &nbsp;

                                        </template>
                                         <template v-else> 
                                       
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
                <div class="modal-dialog modal-danger modal-lg" role="document">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo documento</label>
                                    <div class="col-md-9">
                                        <select v-model="tipo_egreso" class="form-control">
                                            <option value="nomina">Nomina</option>
                                            <option value="cortesia">Cortesia</option>
                                            <option value="gastoadmin">Gasto Administrativo</option>
                                        </select>
                                    </div>
                                </div>
                               
                               
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Valor</label>
                                    <div class="col-md-9">
                                        <input v-model="valor_egreso" type="number"  class="form-control" placeholder="Valor...">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Motivo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="motivo_egreso"  class="form-control" placeholder="Motivo...">
                                    </div>
                                </div>


                                <div v-show="errorEgreso==1" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMensajeEgresoArray" :key="error" v-text="error">
                                           
                                        </div>
                                    </div>
                                </div>

                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccionButton==1" class="btn btn-outline-primary" @click="registrarEgreso()">Grabar</button>

                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
     
        </main>
</template>

<script>
    export default {
        data(){
          return {
            categoria_id :0,
            nombre : '',
            descripcion : '',
            modal : 0,
            tituloModal : '',
            tipoAccionButton : 0,
            arraEgreso:[],


            tipo_egreso:'nomina',
            valor_egreso:'',
            motivo_egreso:'',
            validar_caja:'',
            errorEgreso : 0,
            errorMensajeEgresoArray : [],

            pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from'  : 0,
                'to' : 0,
            },

            offset : 3,
            criterio : 'tipo_egreso',
            buscar  : '',
          }
        },



        computed :{
           
            isActived : function(){
              return   this.pagination.current_page
            },
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



        methods: {
              
          listarEgreso(page, buscar, criterio){
                 let me=this;
                  var url= '/egreso/index?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arraEgreso = respuesta.GetEgreso.data;
                    me.pagination = respuesta.pagination;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
              },
          
                cambiarPagina(page, buscar, criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarEgreso(page, buscar, criterio);
            },

             validateOpenCaja(){

                  let me=this;
                  axios.get('egreso/ValidateOpenCaja').then(function (response) {
                    var respuesta=response.data;
                    me.validar_caja=respuesta.status;
                        if(respuesta.status=='error')
                        {   

                            me.ShowModalAperturaCaja();


                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            cerrarModal(){
                this.modal=0;
                this.tituloModal='';

              },


            ShowModalAperturaCaja(){
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-info',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'apertura de caja Cerrada!',
                text: "presione click en el modulo movimiento de caja",
                icon: 'info',
                showCancelButton: true,
               // confirmButtonText: 'Open Caja',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                 //pasar al otro componente
                } else if (
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


            abrirModal(modelo, accion, data=[]){
                  switch(modelo){
                      case "egreso":
                     {
                         switch(accion){
                            
                             case 'documento':
                            {
                                this.modal=1;
                                this.tituloModal='Documento de caja';
                                this.tipoAccionButton=1;
                              break;
                             }  
                                 
                         } 
                      }
                  }

              },


            registrarEgreso(){

                  if(this.validarEgreso()){
                      return ;
                  }
                  let me=this;
                  axios.post('/egreso/registerDocumentoCaja', {
                    'tipo_egreso':  this.tipo_egreso,
                    'valor_egreso': this.valor_egreso,
                    'motivo_egreso':this.motivo_egreso,
                })
                .then(function (response) {

                      var respuesta=response.data;
                        if(respuesta.status=='ok'){
                            me.listarEgreso(1,'','nombre');
                            me.cerrarModal();
                            Swal.fire(
                            'Exitoso?',
                            'Documento de caja Ingresado correctamente',
                            'success'
                            )
                    }
                }) 
                .catch(function (error) {
                    console.log(error);
                });

              },


              descargarEgreso(id){

                    window.open('/egreso/pdfEgreso/'+id+','+'_blank');
                },

            validarEgreso(){
                this.errorEgreso=0;
                 this.errorMensajeEgresoArray=[];

                 if(!this.tipo_egreso) this.errorMensajeEgresoArray.push("El campo tipo de egreso es obligatorio");
                 if(!this.valor_egreso) this.errorMensajeEgresoArray.push("El campo valor egreso es obligatorio");
                 if(!this.motivo_egreso) this.errorMensajeEgresoArray.push("El campo motivo egreso es obligatorio");
                 if(this.errorMensajeEgresoArray.length) this.errorEgreso=1;
                 return this.errorEgreso;
              },

               AnularDocumentoDeCaja(id,tipo){
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Estas seguro que desea anular esta '+tipo,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {

                  let me=this;
                axios.put('/egreso/AnularDocumentoCaja', {
                  'id' : id
               })
                .then(function (response) {

                    me.listarEgreso(1,'','nombre');

                    swalWithBootstrapButtons.fire(
                    'Anulado',
                    'El Documento ha sido Anulado correctamente',
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


        },
        mounted() {
      this.listarEgreso(1,this.buscar,this.criterio);    
      this.validateOpenCaja(); 
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
