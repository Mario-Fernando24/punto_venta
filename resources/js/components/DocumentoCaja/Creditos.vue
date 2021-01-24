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
                        <i class="fa fa-align-justify"></i>Listado de creditos
                        
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
                                    <th>Id venta</th>
                                    <th>Cliente</th>
                                    <th>Deuda</th>
                                    <th>estado</th>
                                    <th>Abonar</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="credito in arraCredito" :key="credito.id">
                                    
                                        <td v-text="credito.idVenta"></td>
                                        <td v-text="credito.cliente_credito.nombre"></td>
                                        <td v-text="credito.deuda"></td>

                                        <td>
                                        <div v-if="credito.estado==0">
                                        <span class="badge badge-danger">Debe</span>
                                        </div>

                                        <div v-else>
                                        <span class="badge badge-success">Pagado</span>
                                        </div>
                                    </td>

                                    <td>
                                        <button type="button" @click="abrirModal('credito', 'abonar',credito)" class="btn btn-outline-success btn-sm" data-toggle="modal">
                                          <i class="icon-credit-card"></i> 
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
                <div class="modal-dialog modal-warning modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                






            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>Detalles del credito
                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Vendedor</th>
                                    <th>Abono</th>
                                    <th>Observación</th>
                                    <th>Fecha</th>


                                    <th>Estado</th> 
                                </tr>
                            </thead>
                            <tbody v-if="abono_credito.length==0">
                                    <tr class="totalresultado" >
                                        <td colspan="6" align="right"><strong>No tiene ningun Abono</strong></td>
                                    </tr>


                                  <tr class="totalresultado" >
                                             <td colspan="5" align="right"><strong>Credito :</strong></td>
                                             <td v-text="Intl.NumberFormat().format(deuda)"></td>
                                         </tr>


                                       <tr class="totalresultado" >
                                             <td colspan="5" align="right"><strong>Deuda actual :</strong></td>
                                             <td v-text="Intl.NumberFormat().format(deuda-acumabonodeuda)"></td>
                                         </tr>

                           </tbody>


                            <tbody v-else>
                                    <tr class="totalresultado" v-for="abonos in abono_credito" :key="abonos.id">
                                        <td v-text="abonos.id"></td>
                                        <td v-text="abonos.user_ingresado['usuario']"></td>
                                        <td class="text-error" v-text=" Intl.NumberFormat().format(abonos.montoAbonar)"></td>
                                        <td v-text="abonos.observacion"></td>
                                        <td v-text="abonos.created_at"></td>

                                        <td v-if="abonos.estado==1" class="badge badge-success">Abonado</td>

                                        </tr>

                                  
                                        <tr class="totalresultado" >
                                             <td colspan="5" align="right"><strong>Credito :</strong></td>
                                             <td v-text="Intl.NumberFormat().format(deuda)"></td>
                                         </tr>
                                           
                                        <tr class="totalresultado" >
                                             <td colspan="5" align="right"><strong>Total abonado :</strong></td>
                                             <td v-text="Intl.NumberFormat().format(acumabonodeuda)"></td>
                                         </tr>


                                        <tr class="totalresultado" >
                                             <td colspan="5" align="right"><strong>Deuda actual :</strong></td>
                                             <td v-text="Intl.NumberFormat().format(deuda-acumabonodeuda)"></td>
                                         </tr>

                           </tbody>

                        </table>
                        </div>

                       <div v-if="deuda!=acumabonodeuda">
                          <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Monto Abonar</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="montoAbonar"  class="form-control" placeholder="$ Valor abonar">
                                    </div>
                                    <p><strong class="text-error" v-if="montoAbonar>(deuda-acumabonodeuda)">Monto abonar es mayor a la deudad actual</strong></p>
                                    <p><strong class="text-success" v-if="montoAbonar==(deuda-acumabonodeuda)">Desea pagar todo el credito</strong></p>

                            </div>


                          <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Observación</label>
                                    <div class="col-md-9">
                                         <textarea v-model="observacionAbono" class="form-control col-md-12"  type="text"></textarea>
                                    </div>
                            </div>

                     </div>    


                            <div v-show="errorAbonarCredito==1" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorAbonoMensajeArray" :key="error" v-text="error">
                                           
                                        </div>
                                    </div>
                                </div>
                        
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccionButton==1" class="btn btn-outline-primary" @click="abonarCredito()">Guardar</button>

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
            arraCredito:[],
            credito_id:0,
            tipoAccionButton:0,
            tituloModal:'',
            modal:0,
           //array creditos 
            detalles_venta_credito:[],
            abono_credito:[],
            deuda:0,
            acumabonodeuda:0,
           //variables modal credito
            montoAbonar:0,
            observacionAbono:'ninguna',
            //validar caja open
             validar_caja:'',


            //validacion abonar credito

            errorAbonarCredito : 0,
            errorAbonoMensajeArray : [],

            pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from'  : 0,
                'to' : 0,
            },

            offset : 3,
            criterio : 'nombre',
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
              
          listaCategoria(page, buscar, criterio){
              
                 let me=this;
                  var url= '/credito/index?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arraCredito = respuesta.credito.data;
                    me.pagination = respuesta.pagination;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

              },
          
             cambiarPagina(page, buscar, criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listaCategoria(page, buscar, criterio);
            },


              abonarCredito(){

                  if(this.validarAbonoCredito()){
                      return ;
                  }
                  
                  let me=this;
                  var creditoPagado;
                   if(me.montoAbonar==(me.deuda-me.acumabonodeuda))
                    {
                      creditoPagado=1;
                    }
                    else{
                       creditoPagado=0;
                    }
                  axios.post('/credito/abonarCredito', {
                    'montoAbonar':  this.montoAbonar,
                    'observacionAbono': this.observacionAbono,
                    'credito_id': this.credito_id,
                    'estado':creditoPagado
                   
                })
                .then(function (response) {


                      var respuesta=response.data;
                        if(respuesta.status=='ok'){

                            me.cerrarModal();
                            me.listaCategoria(1,'','nombre');
                            Swal.fire(
                            'Exitoso?',
                            'Abono  Ingresado correctamenta',
                            'success'
                            )
                    }


                }) 
                .catch(function (error) {
                    console.log(error);
                });

              },

              validarAbonoCredito()
              {

                this.errorAbonarCredito=0;
                 this.errorAbonoMensajeArray=[];

                 if(!this.montoAbonar) this.errorAbonoMensajeArray.push("El monto Abonar no puede estar vacio");
                 if(this.montoAbonar>(this.deuda-this.acumabonodeuda)) this.errorAbonoMensajeArray.push("Monto abonar es mayor a la deudad actual");
                 if(this.errorAbonoMensajeArray.length) this.errorAbonarCredito=1;
                 return this.errorAbonarCredito;
              },

              vaciarVariable()
              {
                 this.detalles_venta_credito=[];
                 this.acumabonodeuda=0;
                 this.montoAbonar=0;
                 this.observacionAbono='ninguna';
                 this.errorAbonarCredito=0;
                 this.errorAbonoMensajeArray=[];
              },



               abrirModal(modelo, accion, data=[]){
                  switch(modelo){
                      case "credito":
                     {
                         switch(accion){
                            
                             case 'abonar':
                            {
                                console.log(data);
                                this.modal=1;
                               this.tituloModal='Abonar Credito';
                               this.tipoAccionButton=1;
                               this.credito_id=data['idCredito'];


                               this.detalles_venta_credito=data.detalles_venta_credito;
                               this.abono_credito=data.abono_credito;
                               //deuda actual0
                               this.deuda=data['deuda'];
                                
                                //suma array abonodeuda 
                                var aux;
                                var acumulador=0;
                                let me=this;
                                
                                this.abono_credito.map(function(x){
                                        
                                        aux=parseFloat(x.montoAbonar);
                                        acumulador=acumulador+aux;
                                        me.acumabonodeuda=acumulador;
                                    
                                });

                              break;
                             } 
                             }   
                                 
                         } 
                      }
                  },

             
            //metodo para cerrar el modal
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.vaciarVariable();

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


              


           

        },
        mounted() {
       //hacemos referencia a nuestro metodo  listarCategoria
      this.listaCategoria(1,this.buscar,this.criterio);     
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
  .text-success{
    color: green !important;
    font-weight: bold;
  }
</style>
