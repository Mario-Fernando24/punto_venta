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
                        <i class="fa fa-align-justify"></i> Caja
                        <button v-if="this.estadoCajausers.Cajaactual!='abierto'" type="button"  @click="abrirCaja('apertura','registrar')" class="btn btn-info">
                            <i class="icon-plus"></i>&nbsp;Apertura de caja
                        </button>


                        <button v-if="this.estadoCajausers.Cajaactual=='abierto'" type="button" class="btn btn-warning" @click="abrirCaja('apertura','actual')">
                            <i class="icon-doc"></i>&nbsp;Mostrar cuadre de caja 
                        </button>

                        <button v-if="this.estadoCajausers.Cajaactual=='abierto'" type="button" class="btn btn-danger" @click="abrirCaja('apertura','cierre')">
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
                                    <input type="text" v-model="buscar" @keyup.enter="listarCaja(1,buscar,criterio)"  class="form-control" placeholder="Buscar...">
                                    <button type="submit" @click="listarCaja(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Arqueo</th>
                                    <th>Responsable</th>
                                    <th>fecha inicial</th>
                                    <th>fecha cierre</th>
                                    <th>Estado</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="caja in arraCaja" :key="caja.id">
                                    <td>
                                       
                                        <button type="button" @click="downloadArqueoIdUsers(caja.idcaja,caja.id_vendedor)"  class="btn btn-warning btn-sm" >
                                         <i class="icon-cloud-download"></i> 
                                        </button>
                                        </td>

                                        <td v-text="caja.idcaja"></td>
                                        <td v-text="caja.apertura_vendedor.usuario"></td>
                                        <td v-text="caja.Fecha"></td>
                                        <td v-text="caja.updated_at"></td>



                                        <td>

                                        <div v-if="caja.Cajaactual=='cerrado'">
                                        <span class="badge badge-danger">Cerrado</span>
                                        </div>

                                        <div v-if="caja.Cajaactual=='abierto'">
                                        <span class="badge badge-success">Abierta</span>
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



            <!--inicio abrir del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div   class="modal-dialog modal-primary modal-lg" role="document">
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
                              <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                              <button type="button" v-if="tipoAccionButton==1" class="btn btn-outline-info" @click="apertura_de_caja()">Abrir caja</button>
                              <button type="button" v-if="tipoAccionButton==2" class="btn btn-outline-danger" @click="apertura_de_caja()">Cerrar caja</button>

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
            <!--end abrir caja-->





            <!--Inicio del modal para cerrar caja-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar':modalcerrar}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div   class="modal-dialog modal-primary modal-lg" role="document">
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
                                    <label class="col-md-12 form-control-label" for="text-input"><b>Obserwwvación Apertura de caja</b></label>
                                    <div class="col-md-12">
                                        <textarea class="col-md-12" v-model="observacion_apertura" type="text"></textarea>
                                    </div>
                                </div>





                        <div class="form-group row">
                           <div class="col-md-12">
                              <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                              <button type="button" v-if="tipoAccionButton==3" class="btn btn-outline-danger" @click="imprimir_cerrar_de_caja()">Cerrar caja</button>
                            <button type="button" class="btn btn-outline-warning" @click="imprimir_informe_de_caja()">Imprimir Informe</button>

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

            <!--cierre caja-->





            <!--modal caja actual init-->


            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar':modalactual}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
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

                        <div class="form-group col border">
                           <div class="table-responsive col-md-12">
                                 <table class="table table-bordered table-striped table-sm">
                                    
                                     <thead>
                                         <tr>
                                            <th>Fecha actual</th>
                                            <th v-text="currentDay"> </th>
                                            <th v-text="currentHour"></th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                    <tr>

                                         <tr>
                                            <th>Efectivo de ventas:</th>
                                            <td></td>
                                            <td v-text="Intl.NumberFormat().format(efectivo_ventas)"></td>
                                         </tr>
                                         <tr>
                                            <th>(+)Total de Ingresos</th>
                                            <td></td>
                                            <td v-text="Intl.NumberFormat().format(ingresoAbonocredito)"></td>
                                         </tr>

                                         <tr>
                                            <th>(-) Total de Egreso:</th>
                                            <td></td>
                                            <td v-text="Intl.NumberFormat().format(egreso_venta)"></td>
                                         </tr>


                                         <tr>
                                            <th><b>(+)</b>Base:</th>
                                            <td></td>
                                            <td v-text="Intl.NumberFormat().format(estadoCajausers.Cajainicial)"></td>
                                         </tr>



                                        <tr class="totalresultado" >
                                             <td></td>
                                             <td align="right"><strong>Efectivo en caja :</strong></td>
                                             <td class="text-error" v-text="Intl.NumberFormat().format(((efectivo_ventas+parseInt(estadoCajausers.Cajainicial))-egreso_venta)+ingresoAbonocredito)"></td>
                                         </tr><br>


                                         <tr>
                                             <td align="right"><strong>Forma de pago:</strong></td>
                                             <td></td>
                                             <td><strong>Valor</strong></td>
                                         </tr>


                                         <tr>
                                            <th>Efectivo:</th>
                                            <td></td>
                                            <td v-text="Intl.NumberFormat().format(efectivo_ventas)"></td>
                                         </tr>


                                         <tr>
                                            <th>Datafono 1:</th>
                                            <td></td>
                                            <td v-text="Intl.NumberFormat().format(datafono_Venta)"></td>
                                         </tr>

                                         <tr>
                                            <th>Transferencia:</th>
                                            <td>(nequi, bancolombia, daviplata otros)</td>
                                            <td v-text="Intl.NumberFormat().format(transferncia_Venta)"></td>
                                         </tr>

                                          <tr>
                                            <th>Credito:</th>
                                            <td></td>
                                            <td v-text="Intl.NumberFormat().format(credito_venta)"></td>
                                         </tr>


                                        <tr class="totalresultado" >
                                             <td></td>
                                             <td align="right"><strong>Total de venta :</strong></td>
                                             <td class="text-error" v-text="Intl.NumberFormat().format(efectivo_ventas+datafono_Venta+transferncia_Venta+credito_venta)"></td>
                                         </tr>


                                     </tbody>
                                 </table>
                           </div>

                           





                        <div class="form-group row">
                           <div class="col-md-12">
                              <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
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

            <!--end modal caja actual-->


     
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
            estadoCajausers:'',
            efectivo_ventas:0,
            transferncia_Venta:0,
            datafono_Venta:0,
            egreso_venta:0,
            credito_venta:0,
            ingresoAbonocredito:0,

            //cual es la categoria que quiero edit 
            categoria_id :0,
            nombre : '',
            descripcion : '',
            //la data que regresa nuestro metodo listarCategoria se almacene en esta array
            arraCaja:[],
            modal : 0,
            modalactual:0,
            modalcerrar:0,
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


        computed :{
           

             calcularTotalAperturaCaja : function(){
                var resultado=0.0;

                resultado=(this.moneyInitial.cienmil*100000)+(this.moneyInitial.cincuentamil*50000)+(this.moneyInitial.veintemil*20000)
                +(this.moneyInitial.diezmil*10000)+(this.moneyInitial.cincomil*5000)+(this.moneyInitial.dosmil*2000)+(this.moneyInitial.mil*1000)
                +(this.moneyInitial.quiniento*500)+(this.moneyInitial.dociento*200)+(this.moneyInitial.cien*100)+(this.moneyInitial.cincuenta*50);
                return resultado;
            },


        currentDay() {
            let curr = new Date();
            return `${curr.getDay()}/${
                curr.getMonth() + 1
            }/${curr.getFullYear()}`;
        },
        currentHour() {
            let curr = new Date();
            let hour = curr.getHours();
            let isPm = hour >= 12 ? true : false;
            hour = hour > 12 ? hour - 12 : hour;
            return `${hour < 10 ? "0" : ""}${hour}:${
                curr.getMinutes() < 10 ? "0" : ""
            }${curr.getMinutes()} ${isPm ? "pm" : "am"}`;
        },




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

      
          listarCaja(page, buscar, criterio){
              
                 let me=this;
                  var url= '/caja/index?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    //todo lo que retorne esta funcion se almacene en este array
                    me.arraCaja = respuesta.listaCaja.data;
                  //  console.log(respuesta.listaCaja.data);
                    me.pagination = respuesta.pagination;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

              },

              downloadArqueoIdUsers(idarque, idusers)
              {
                  console.log('id'+idarque);
                  console.log('idusers'+idusers);

                  let me=this;
                  var url= 'http://127.0.0.1:8000/caja/detalleinformeCajaImpresa?idcaja=' + idarque + '&idvendedor=' + idusers;
                    window.open(url);

              },


          //Metodo de cambiar pagina recibe un parametro de page "numero de la pagina que queremos mostrar"
                cambiarPagina(page, buscar, criterio){
                let me = this;
                //actualiza a la pagina actual
                me.pagination.current_page = page;
                //envia la peticion de listar esa pagina
                me.listarCaja(page, buscar, criterio);
            },
          
         

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
                    me.listarCajaAbierta();
                    me.vaciarVariables();
                    me.listarCaja(1,'',''); 

                    me.modal=0;
                    console.log('ok mario');
                }) 
                .catch(function (error) {
                    console.log(error);
                });

              },


              vaciarVariables(){
                   this.moneyInitial.cincuenta=0;
                   this.moneyInitial.cien=0;
                   this.moneyInitial.dociento=0;
                   this.moneyInitial.quiniento=0;
                   this.moneyInitial.mil=0;
                   this.moneyInitial.dosmil=0;
                   this.moneyInitial.cincomil=0;
                   this.moneyInitial.diezmil=0;
                   this.moneyInitial.veintemil=0;
                   this.moneyInitial.cincuentamil=0;
                   this.moneyInitial.cienmil=0;

              },
               
               listarCajaAbierta()
               {
                  let me=this;
                  axios.get('/caja/ShowCajaUser').then(function (response) {

                    var respuestaaa=response.data.cajaOpen;
                    me.estadoCajausers= respuestaaa;

                    me.efectivo_ventas=response.data.Efectivo_de_Ventas;
                    me.transferncia_Venta=response.data.transferencia_ventas;
                    me.datafono_Venta=response.data.datafono_Ventas;
                    me.egreso_venta=response.data.Egreso;
                    me.credito_venta=response.data.Credito;
                    me.ingresoAbonocredito=response.data.IngresoAbonoCredito;
                    

                    })
                    .catch(function (error) {
                        console.log(error);
                    });

               },



                cargarPdfCategoria(){
                    window.open('http://127.0.0.1:8000/categoria/ListarPdfCategoria','_blank');
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
                let me=this;
                me.modal=0;
                me.modalactual=0;
                me.modalcerrar=0;
                me.vaciarVariables();
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
                             case 'cierre':
                            {
                               // console.log(data);
                               this.modalcerrar=1;
                               this.tituloModal='Cierre de caja';
                               this.tipoAccionButton=3;
                             break;
                             }   


                              case 'actual':
                            {
                               // console.log(data);
                               this.modalactual=1;

                               this.tituloModal='Total efectivo General';
                             break;
                             }   
                                 
                         } 
                      }
                  }

              },

             
              imprimir_informe_de_caja()
              {

               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-info',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'informe del arqueo abierto!',
                text: "Desea descargar de forma automatica un informe detallado del arqueo",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                   this.cerrarModal();
                  var url= 'http://127.0.0.1:8000/caja/informeCaja';
                  window.open(url);

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

               
               imprimir_cerrar_de_caja()
              {



                  let me=this;
                  axios.get('caja/cerrarCaja').then(function (response) {
                    var respuesta=response.data;
                            me.cerrarModal();
                            me.listarCajaAbierta();
                            me.listarCaja(1,'',''); 


                        if(respuesta.status=='ok')
                        {   

                            const swalWithBootstrapButtons = Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-info',
                                    cancelButton: 'btn btn-danger'
                                },
                                buttonsStyling: false
                                })

                                swalWithBootstrapButtons.fire({
                                title: 'Caja cerrada!',
                                text: "se descargara de forma automatica un informe detallado del arqueo",
                                icon: 'info',
                                showCancelButton: true,
                                confirmButtonText: 'Aceptar',
                                cancelButtonText: 'Cancelar',
                                reverseButtons: true
                                }).then((result) => {
                                if (result.isConfirmed) {
                                //pasar al otro componente


                                var url= 'http://127.0.0.1:8000/caja/imprimircerrarCaja';
                                window.open(url);


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

                                        }
                                    })
                                    .catch(function (error) {
                                        console.log(error);
                                    });





              }
        },
        mounted() {
       //hacemos referencia a nuestro metodo  listarCategoria
      this.listarCaja(1,this.buscar,this.criterio); 
      this.listarCajaAbierta();    
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
