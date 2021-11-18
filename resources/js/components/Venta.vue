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
                        <i class="fa fa-align-justify"></i>FACTURAS
                            <button type="button" @click="mostrarDetalle()" class="btn btn-secondary btn-sm" data-toggle="modal">
                            <i class="icon-plus"></i>Nuevo
                             </button>
                    </div>

                    <template v-if="validar_caja=='error'">

                        <div class="card-body">
                                    <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <tbody>
                                            <h1>Caja Cerrada</h1>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                    </template>



                    <!--Listado-->
                    <template v-if="listado==1 && validar_caja=='ok'" >
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="id">Id</option>
                                        <option value="fecha_hora">Fecha-Hora</option>
                                        </select>
                                        <input type="text" v-model="buscar"  @keyup.enter="listaVenta(1,buscar,criterio)"  class="form-control" placeholder="Buscar...">
                                        <button type="submit" @click="listaVenta(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Usuario</th>
                                                <th>Cliente</th>
                                                <th>Tipo comprobante</th>
                                                <th>Forma Pago</th>
                                                <th>Observación</th>
                                                <th>Fecha</th>
                                                <th>Total</th>
                                                <th>Impuesto</th>
                                                <th>Estado</th>
                                                <th colspan="3">Opciones</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="venta in arrayVenta" :key="venta.id">
                                                
                                                    <td v-text="venta.id"></td>
                                                    <td v-text="venta.usuario_hizola_venta.usuario"></td>
                                                    <td v-text="venta.cliente_persona.nombre"></td>
                                                    <td v-text="venta.tipo_comprobante"></td>
                                                    <td>
                                                      <span class="badge badge-info">Efectivo {{Intl.NumberFormat().format(venta.formaspago['efectivo'])}}</span>
                                                      <span class="badge badge-primary">Credito {{Intl.NumberFormat().format(venta.formaspago['credito'])}}</span>
                                                      <span class="badge badge-dark">Datafono {{Intl.NumberFormat().format(venta.formaspago['datafono'])}}</span>
                                                      <span class="badge badge-secondary">Transferencia {{Intl.NumberFormat().format(venta.formaspago['tranferencia'])}}</span>
                                                    </td>
                                                    <td v-text="venta.num_comprobante_pago_pago"></td>
                                                    <td v-text="venta.created_at"></td>
                                                    <td v-text="Intl.NumberFormat().format(venta.total)"></td>
                                                    <td v-text="venta.impuesto"></td>


                                                    <td>
                                                    <div v-if="venta.estado=='registrado'">
                                                    <span class="badge badge-success" v-text="venta.estado"></span>
                                                    </div>

                                                    <div v-else>
                                                    <span class="badge badge-danger">Anulado</span>
                                                    </div>
                                                    </td>


                                                    <td>
                                                    <button type="button" class="btn btn-success btn-sm" @click="verDetalleVenta(venta.id)">
                                                    <i class="icon-eye"></i>
                                                    </button>
                                                    
                                                    
                                                    <button type="button" class="btn btn-dark btn-sm" @click="showModalCopy(venta)" >
                                                    <i class="icon-doc"></i>
                                                    </button>


                                                    <button type="button" class="btn btn-info btn-sm" @click="descargarventa(venta.id)">
                                                    <i class="icon-doc"></i>
                                                    </button>


                                                    <template v-if="venta.estado=='registrado'"> 
                                                    <button type="button"  class="btn btn-danger btn-sm" @click="anularIngreso(venta.id)">
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
                    </template>
                    <!-- fin Listado-->

                    <!--compra Ingreso-->
                    <template v-else-if="listado==0">

                        <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-9">
                                    <div class="form-group">
                                    <label for="">Cliente<span  class="validaridArticulo"   v-show="arrayCliente==0">*</span></label>
                                    <v-select
                                        @search="selectCliente"
                                        label="nombre"
                                        aria-label=""
                                        :options="arrayCliente"
                                        placeholder="Buscar clientes..."
                                        @input="getDatosCliente"                                        
                                    >
                                    </v-select>
                                    </div>
                                </div>



                                <div class="col-md-3">
                                    <label>Impuesto %<span  class="validaridArticulo"   v-show="impuesto==0">*</span></label>
                                    <input type="text" class="form-control"  v-model="impuesto">
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <label>Tipo Comprobante <span  class="validaridArticulo"   v-show="tipo_comprobante==0">*</span></label>
                                            <select class="form-control" v-model="tipo_comprobante">
                                                <option value="0">Seleccione</option>
                                                <option value="FACTURA">Factura</option>
                                                <option value="BOLETA">Boleto</option>
                                                <option value="TICKET">Ticket</option>
                                            </select>
                                    </div>
                                </div>



                               <div class="col-md-4">
                                    <div class="form-group"> 
                                        <label><b>DISPONIBLE CABA</b><span  class="validaridArticulo"   v-show="forma_pago==0">*</span></label>
                                            <select class="form-control" v-model="caba">
                                                <option value="no">NO</option>
                                                <option value="si">SI</option>

                                            </select>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <label>Observación<span  class="validaridArticulo"   v-show="num_comprobante_pago==0">*</span></label>
                                        <input type="text" class="form-control"  v-model="num_comprobante_pago" placeholder="Observación">
                                    </div>
                                </div>



                                <div class="col-md-12">
                                    <div v-show="errorVenta==1" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMensajearrayVenta" :key="error" v-text="error">  
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>


                                <div class="form-group row border">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Articulo <span class="validaridArticulo" v-show="idarticulo==0">(*Seleccione)</span></label>
                                        <div class="form-inline">
                                            <input type="" v-model="codigo" @keyup.enter="BuscarArticuloBarraVenta()"  placeholder="Ingrese el articulo">
                                            <button class="btn btn-primary" @click="abrirModal()">+</button>
                                            <input type="text" readonly class="form-control" v-model="articulo">
                                        </div>
                                    </div>
                                </div>
                            

                                

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Precio<span class="validaridArticulo" v-show="precio==0">*</span></label><br>
                                        <input type="number" min="0" v-model="precio" value="0" step="any"  placeholder="000.0">
                                    </div>                   
                                </div>


                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Cantidad<span  class="validaridArticulo"   v-show="cantidad==0">*</span></label><br>
                                        <input type="number" min="0" value="0" step="any" v-model="cantidad"  placeholder="00">
                                    </div>                   
                                </div>


                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Descuento<span class="validaridArticulo" v-show="descuento<0">*</span></label><br>
                                        <input type="number" min="0" v-model="descuento" value="0" step="any"  placeholder="000.0">
                                    </div>                   
                                </div>
                                                       



                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                                    </div>                   
                                </div>
                                </div>

                         <!--show article-->
                          <div class="form-group row border">
                           <div class="table-responsive col-md-12">
                                 <table class="table table-bordered table-striped table-sm">
                                    
                                     <thead>
                                         <tr>

                                            <th>Opciones</th>
                                            <th>Articulo</th>
                                            <th>Precio venta</th>
                                            <th>Cantidad</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>

                                         </tr>
                                     </thead>
                                     <tbody v-if="arrayDetalleVenta.length">

                                         <tr v-for="(detalle,index) in arrayDetalleVenta" :key="detalle.id">
                                            <th>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </th>

                                            <th v-text="detalle.articulo"></th>


                                            <td>
                                                <input v-model="detalle.precio" type="number" class="form-control">
                                            </td>

                                            <td>
                                                <span class="validaridArticulo" v-show="detalle.cantidad>detalle.stock">Stock {{ detalle.stock }}</span>
                                                <input v-model="detalle.cantidad" type="number"  class="form-control">
                                            </td>

                                            <td>
                                            <span class="validaridArticulo" v-show="detalle.descuento>(detalle.cantidad*detalle.precio)">Descuento superior a subtotal </span>
                                                <input v-model="detalle.descuento" type="number"  class="form-control">
                                            </td>

                                            <td>
                                                {{ Intl.NumberFormat().format((detalle.cantidad*detalle.precio)-detalle.descuento)  }}
                                            </td>


                                         </tr>



                                         <tr class="totalresultado" >
                                             <td colspan="4" align="right"><strong>Subtotal:</strong></td>
                                             <td colspan="2" >$ {{ Intl.NumberFormat().format((total-impu))}}</td>
                                         </tr>


                                         <tr class="totalresultado" >
                                             <td colspan="4" align="right"><strong>Impuesto:</strong></td>
                                             <td colspan="2" >$ {{ Intl.NumberFormat().format((impu=(total*impuesto)/100))}}</td>
                                         </tr>

                                         <tr class="totalresultado" >
                                             <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                             <td colspan="2" >$ {{ Intl.NumberFormat().format((total=(this.calculadorTotal)))}}</td>
                                         </tr>

                
                                     </tbody>

                                 <tbody v-else>
                                   <tr>
                                       <th colspan="8">
                                         No hay articulos agregados
                                       </th>
                                   </tr>
                                 </tbody>

                                 
                                 </table>



                             <!--   <div class="col-md-4">
                                    <div class="form-group"> 
                                        <label><b>Tipo pago </b><span  class="validaridArticulo"   v-show="forma_pago==0">*</span></label>
                                            <select class="form-control" v-model="forma_pago">
                                                <option value="0">Seleccione</option>
                                                <option value="efectivo">EFECTIVO</option>
                                                <option value="datafono">DATAFONO</option>
                                                <option value="credito">CREDITO</option>
                                                <option value="transferencia">TRANSFERENCIA <b> (nequi, bancolombia, daviplata otros)</b></option>

                                            </select>
                                    </div>
                                </div>




                                <div class="col-md-4" v-if="forma_pago=='datafono' || forma_pago=='transferencia'">
                                    <div class="form-group"> 
                                        <label>Num Comprobante<span  class="validaridArticulo"   v-show="num_comprobante_pago==0">*</span></label>
                                        <input type="text" class="form-control"  v-model="num_comprobante_pago" placeholder="002-2, bancolombia, nequi etc">
                                    </div>
                                </div> -->


                           </div>





                        <div class="form-group row">
                           <div class="col-md-12">
                               <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                              <button type="button" class="btn btn-outline-primary" @click="modalFormaVenta()">Guardar factura</button>
                           </div>
                        </div>

                       </div>
                      </div>
                    
                    </template>

                    <!--fin Ingreso compra-->

                     <!-- mostrar los detalle de los ingreso-->
                     <template v-else-if="listado==2">
                        <div class="card-body">
                            <div class="form-group row border">

                                <div class="col-md-2">
                                    <label class="negritatitle">ID</label>
                                    <p v-text="idventa"></p>
                                </div>

                                <div class="col-md-3">
                                    <label class="negritatitle">Fecha Venta</label>
                                    <p v-text="fecha_hora"></p>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label class="negritatitle">Cliente</label>
                                    <p v-text="cliente"></p>
                                    </div>
                                </div>

                                

                                <div class="col-md-3">
                                    <label class="negritatitle">Impuesto %</label>
                                    <p v-text="impuesto"></p>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group"> 
                                        <label class="negritatitle">Tipo Comprobante</label>
                                          <p v-text="tipo_comprobante"></p>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group"> 
                                        <label class="negritatitle">Forma de pago</label>
                                            <span class="badge badge-info">Efectivo {{Intl.NumberFormat().format(arrayFormaPagoDetalle.efectivo)}} Credito {{Intl.NumberFormat().format(arrayFormaPagoDetalle.credito)}} </span>
                                            <span class="badge badge-secondary">Datafono {{Intl.NumberFormat().format(arrayFormaPagoDetalle.datafono)}} # {{ arrayFormaPagoDetalle.datafonoobservacion }}  --   Transferencia {{Intl.NumberFormat().format(arrayFormaPagoDetalle.tranferencia)}}  {{ arrayFormaPagoDetalle.tranferenciaobservacion }}</span>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group"> 
                                        <label class="negritatitle">Observación</label>
                                        <p v-text="num_comprobante_pago"></p>
                                    </div>
                                </div>


                                <div class="col-md-3" v-if="estadovali=='anulado'">
                                    <div class="form-group validaridArticulo"> 
                                        <p v-text="'venta anulada por:  '+nombreAnulaVenta+' fecha '+fecha_ven_anulada"></p>

                                        
                                    </div>
                                </div>

                                

                         </div>

                    <!--show article  -->
                        <div class="form-group row border">
                           <div class="table-responsive col-md-12">
                                 <table class="table table-bordered table-striped table-sm">
                                    
                                     <thead>
                                         <tr>

                                            <th>Articulo</th>
                                            <th>Cantidad</th>
                                            <th>Precio venta</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>

                                         </tr>
                                     </thead>
                                    <tbody>

                                         <tr v-for="(venta) in listadoDetalleVenta" :key="venta.id">
                                          
                                            <th v-text="venta.articulo__detalle__venta.nombre"></th>
                                            <th v-text="venta.cantidad"></th>
                                            <th v-text="Intl.NumberFormat().format(venta.precio)"></th>
                                            <th v-text="Intl.NumberFormat().format(venta.descuento)"></th>
                                            <th v-text="Intl.NumberFormat().format(((venta.precio-venta.descuento)*venta.cantidad))"></th>
                                            
                                         </tr>

                                         <tr class="totalresultado" >
                                             <td colspan="4" align="right"><strong>Subtotal:</strong></td>
                                             <td colspan="2">$ {{ Intl.NumberFormat().format((parseInt(totalDetalleM)) - ((parseInt(totalDetalleM)*impuesto )/100)   ) }}</td> 
                                         </tr>

                                         <tr class="totalresultado" >
                                             <td colspan="4" align="right"><strong>Impuesto:</strong></td>
                                              <td colspan="2">$ {{ Intl.NumberFormat().format(((parseInt(totalDetalleM)*impuesto )/100)) }}</td>
                                         </tr>

                                         <tr class="totalresultado" >
                                             <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                             <td colspan="2" >$  {{ parseInt(totalDetalleM) }}</td> 
                                         </tr>
                                         


                                     </tbody>
                                 </table>
                           </div>

                        <div class="form-group row">
                           <div class="col-md-12">
                               <button type="button" @click="ocultarDetalle  ()" class="btn btn-secondary">Cerrar</button>
                           </div>
                        </div>

                            </div>
                        </div>
                    </template>

                     <!-- final de los detalle de los ingresos-->

                    </div>
                   </div>
                <!-- Fin ejemplo de tabla Listado -->
            <!--Inicio del modal agregar/actualizar -->
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


                            <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioArticulo">
                                      <option value="nombre">Nombre</option>
                                      <option value="codigo">Codigo</option>
                                    </select>
                                    <input type="text" v-model="buscarArt " @keyup.enter="listarArticulo(buscarArt,criterioArticulo)"  class="form-control" placeholder="Buscar...">
                                    <button type="submit" @click="listarArticulo(buscarArt,criterioArticulo)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Categoria</th>
                                    <th>Pre Venta</th>
                                    <th>Stock</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="articulomodal in ListararrayArticulo" :key="articulomodal.id">
                                    <td>
                                        <button type="button" @click="agregarDetallesModal(articulomodal)" class="btn btn-success btn-sm" data-toggle="modal">
                                          <i class="icon-check"></i>
                                        </button> &nbsp;
                                        

                                        </td>
                                        <td v-text="articulomodal.codigo"></td>
                                        <td v-text="articulomodal.nombre"></td>
                                        <td v-text="articulomodal.categoria.nombre"></td>
                                        <td v-text="articulomodal.precio_venta"></td>
                                        <td v-text="articulomodal.stock"></td>

                                        <td>
                                        <div v-if="articulomodal.condicion==1">
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
                    

                    


                        </div>
                        <div class="modal-footer">
                            <img v-if="isLoaded==true" src="https://miro.medium.com/max/882/1*9EBHIOzhE1XfMYoKz1JcsQ.gif" alt="logo" width="220" height="110">
                            <div v-if="isLoaded==false">

                            <button type="button" v-if="isLoaded==false" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccionButton==1 && isLoaded==false"  class="btn btn-primary" @click="registrarVenta()">Guardar</button>
                          
                            </div>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>


             <!--Inicio del modal agregar/actualizar -->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar':modalPago}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg"  role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">PAGAR FACTURA</h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-bod">

                        <h4 class="centrado validaridArticulo">TOTAL $ {{ Intl.NumberFormat().format((total=(calculadorTotal)))}}</h4>

                       <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th scope="col">FORMA DE PAGO</th>
                                <th scope="col">POR PAGAR</th>
                                <th scope="col">DETALLE</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row">EFECTIVO</th>
                                <td ><input type="number" class="form-control" v-on:keyup="sincronada()"  v-model="formapagoventa.efectivo"></td>
                                </tr>

                                <tr>
                                <th scope="row">CREDITO</th>
                                <td ><input type="number" class="form-control" v-on:keyup="sincronada()" v-model="formapagoventa.credito"></td>
                                </tr>


                                <tr>              

                                <th scope="row">DATAFONO</th>
                                <td ><input type="number" class="form-control" v-on:keyup="sincronada()" v-model="formapagoventa.datafono"></td>
                                <td  v-if="formapagoventa.datafono>0"><input  type="text" v-model="formapagoventa.datafonoobservacion" class="form-control"  placeholder="# Bauche"></td>
                                </tr>


                                <tr>
                                <th scope="row">TRANSFERENCIA</th>
                                <td ><input type="number" class="form-control" v-on:keyup="sincronada()" v-model="formapagoventa.transferencia" ></td>
                                <td  v-if="formapagoventa.transferencia>0"><input type="text" v-model="formapagoventa.tranferenciaobservacion" class="form-control" placeholder="# nequi, bancolombia etc"></td>

                                </tr>



                            </tbody>
                        </table>


                        <div class="card">
                            <div class="card-header totalresultado">
                                Total
                            </div>
                            <div class="card-body">
                                <h5 class="card-title" v-text="Intl.NumberFormat().format(parseInt(this.formapagoventa.efectivo)+parseInt(this.formapagoventa.credito)+parseInt(this.formapagoventa.datafono)+parseInt(this.formapagoventa.transferencia))"></h5>
                                <template v-if="(parseInt(this.formapagoventa.efectivo)+parseInt(this.formapagoventa.credito)+parseInt(this.formapagoventa.datafono)+parseInt(this.formapagoventa.transferencia))>this.total">
                                <p class="card-text validaridArticulo">EL VALOR A FACTURAR ES MAYOR AL VALOR DE LA VENTA</p>
                                </template>
                                <template v-if="(parseInt(this.formapagoventa.efectivo)+parseInt(this.formapagoventa.credito)+parseInt(this.formapagoventa.datafono)+parseInt(this.formapagoventa.transferencia))<this.total">
                                <p class="card-text validaridArticulo">EL VALOR A FACTURAR ES MENOR AL VALOR DE LA VENTA</p>
                                </template>

                                <template v-if="(parseInt(this.formapagoventa.efectivo)+parseInt(this.formapagoventa.credito)+parseInt(this.formapagoventa.datafono)+parseInt(this.formapagoventa.transferencia))==this.total">
                                <p class="card-text totalresultado">GRABAR LA FACTURA</p>
                                </template>

                            </div>
                        </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-secondary">Cerrar</button>
                            <button  type="button" class="btn btn-primary" @click="registrarVenta()">Grabar</button>

                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--  final modal  -->


            



            <!--copia de ticker--->

            <div class="modal fade"  tabindex="-1" :class="{'mostrar':ticketcopy}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
              <div class="modal-dialog modal-primary"  role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                      </div>                
                      <div class="modal-bod">

                                  <div class="ticket">
                                      <img  src="data:image/png;base64,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" alt="Logotipo">
                                      <p v-text=" '# '+id_ticket  +'\n FACT: '+usuarioFacturador+ ' \nCLIENTE:  '+usuario_cliente+' \n '+copyfechatherma"></p>      

                                      <table>
                                          <thead>
                                              <tr>
                                                  <th class="cantidad">Cant</th>
                                                  <th class="producto">Produc</th>
                                                  <th class="precio">$$$</th>
                                              </tr>
                                          </thead>
                                          
                                          <tbody>
                                              <tr v-for="det in arrayDetalleVenta" :key="det.id">
                                                  <td class="cantidad" v-text="det.cantidad"></td>
                                                  <td class="producto" v-text="det.articulo.substring(0,6)"></td>
                                                  <td class="precio" v-text="parseInt(det.precio)"></td>
                                              </tr>
                                          </tbody>
                                      </table><br>

                                      <p class="centrado" v-text="'Total  $  '+Intl.NumberFormat().format((total)) +'\n '+tipo_comprobante+'   \nEfectivo: '+Intl.NumberFormat().format(this.formapagoventa.efectivo)+' \nCredito: '+Intl.NumberFormat().format(this.formapagoventa.credito)+' \nTransferencia: '+Intl.NumberFormat().format(this.formapagoventa.transferencia)+' \nDatafono: '+Intl.NumberFormat().format(this.formapagoventa.datafono)+'  '">
                                          <br>tenderpos.xyz</p>

                                          <FONT FACE="raro, courier" SIZE=1 COLOR="black">
                                          Obs: {{num_comprobante_pago}}</FONT><br>
                                         
                                          
                                          <FONT FACE="raro, courier" SIZE=1 COLOR="black">
                                          ¡Gracias por su compra!  Tenderpos 3008494255</FONT>
                                         
                                  </div>
                      </div>   


                      

                      <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                          <button class="btn btn-dark" @click="imprimir()" >Imprimir</button>
                      </div>

                  </div>
              </div>
              </div>



            <!---final de la copia del ticked------->



                    <!--inicio modal imprimir ticken-->

              <div class="modal fade"  tabindex="-1" :class="{'mostrar':ticket}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary"  role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        </div>                
                        <div class="modal-bod">

                                    <div class="ticket">
                                        <img src="data:image/png;base64,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" alt="Logotipo">
                                        <p v-text=" '# '+id_ticket  +'\n FACT: '+usuarioFacturador+ ' \nCLIENTE:  '+usuario_cliente+' \n '+currentDay+' '+ currentHour"></p>      
                                            
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="cantidad">Cant</th>
                                                    <th class="producto">Produc</th>
                                                    <th class="precio">$$$</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                <tr v-for="det in arrayDetalleVenta" :key="det.id">
                                                    <td class="cantidad" v-text="det.cantidad"></td>
                                                    <td class="producto" v-text="det.articulo.substring(0,6)"></td>
                                                    <td class="precio" v-text="parseInt(det.precio)"></td>
                                                </tr>
                                            </tbody>
                                        </table><br>

                                        <p class="centrado" v-text="'Total  $  '+Intl.NumberFormat().format((total)) +'\n '+tipo_comprobante+'   \nEfectivo: '+Intl.NumberFormat().format(this.formapagoventa.efectivo)+' \nCredito: '+Intl.NumberFormat().format(this.formapagoventa.credito)+' \nTransferencia: '+Intl.NumberFormat().format(this.formapagoventa.transferencia)+' \nDatafono: '+Intl.NumberFormat().format(this.formapagoventa.datafono)+'  '">
                                            <br>tenderpos.xyz</p>
                                         
                                            <FONT FACE="raro, courier" SIZE=1 COLOR="black">
                                            Obs: {{num_comprobante_pago}}</FONT><br>
                                           
                                            
                                            <FONT FACE="raro, courier" SIZE=1 COLOR="black">
                                            ¡Gracias por su compra!  Tenderpos 3008494255</FONT>
                                           
                                    </div>
                        </div>   


                        

                        <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button class="btn btn-dark" @click="imprimir()" >Imprimir</button>
                        </div>

                    </div>
                </div>

            </div> 

            <!--final modal imprimir ticken -->

        </main>
</template>

<script>
//importo vselect
import "vue-select/dist/vue-select.css";
import vSelect from "vue-select";

    export default {
        //dentro de la data colocamos las variables 
        data(){
          return {

            modalPago:0,
            //cual es la usuario que quiero edit 
            ingreso_id :0,
            idcliente : 0,
            cliente: '',
            
            tipo_comprobante: 'FACTURA',
            forma_pago : 'efectivo',
            num_comprobante_pago: '',
            telefono:'',
            impuesto: 19,
            totalgananciass: 0.0,
            total: 0.0,
            totalImpuesto:0.0,
            subtotal: 0.0,
            fecha_hora:'',
            idventa:'',
            caba:'no',
            //variable para ver el listado
            listado: 1,
            //la data que regresa nuestro metodo listaVenta se almacene en esta array
            arrayVenta:[],
            arrayDetalleVenta:[],
            arrayCliente:[],
            modal : 0,
            //para saber que modal quiero mostrar, register o actualizar
            tituloModal : '',
            tipoAccionButton : 0,
            errorVenta : 0,
            errorMensajearrayVenta : [],
            isLoaded: false,


            formapagoventa:{
                efectivo:0,
                credito:0,
                datafono:0,
                transferencia:0,
                datafonoobservacion:'',
                tranferenciaobservacion:'',

            },
          arrayFormaPagoDetalle:[],
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
            criterio : 'id',
            criterioArticulo:'nombre',
            buscar  : '',
            buscarArt:'',
            arrayArticulo:[],
            ListararrayArticulo:[],
            listadoDetalleVenta:[],
            idarticulo:0,
            codigo:'',
            articulo:'',
            precio:0,
            stock: 0,
            cantidad: 0,
            descuento:0,
            impu:0,
            totalDetalleM:'',
            nombreAnulaVenta:'',
            estadovali:'',
            fecha_ven_anulada:'',

             //validar caja open
             validar_caja:'',
             ticket:0,
             id_ticket:0,
             usuarioFacturador:'',
             usuario_cliente:'',

             ticketcopy:0,
             vectorTicked:[],
             copyfechatherma:'',
             contadorval:0,
          }
        },
         components: {
            vSelect
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
            calculadorTotal : function(){
                var resultado=0.0;
                var aux=0.0;

                for(var i=0; i<this.arrayDetalleVenta.length; i++){
                  aux+=this.arrayDetalleVenta[i].precio*this.arrayDetalleVenta[i].cantidad;
                  resultado+=aux-this.arrayDetalleVenta[i].descuento;
                  aux=0.0;
                }

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

            
           


            calculadorTotalDetalle : function(){
                var resultado=0.0;
                for(var i=0; i<this.listadoDetalleVenta.length; i++){
                  resultado+=this.listadoDetalleVenta[i].descuento*this.listadoDetalleVenta[i].cantidad;
                }
                return resultado;
            },


            
        },
        //aqui estaran los metodos. axios que me ayudaran hacer peticiones http e forma sencilla y convertir la respuesta en json
        methods: {
              
               listaVenta(page, buscar, criterio){
                 let me=this;
                  var url= '/ventas/index?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    //todo lo que retorne esta funcion se almacene en este array
                    me.arrayVenta = respuesta.venta.data;
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
                me.listaVenta(page, buscar, criterio);
                 },


                selectCliente(search,loading){
               //  console.log(loading);                    
                let me=this;
                loading(true);
                var url= '/ventas/selectCliente?filtro='+search;
                axios.get(url).then(function (response) {
                    console.log(response.data);
                  let respuesta = response.data;
                    me.arrayCliente=respuesta.cliente;
                    loading(false)                    
    
                })
                .catch(function (error) {
                    console.log(error);
                });           
                 },
 
                getDatosCliente(val1){
                    console.log('mario fernando muñoz rivera');
                    console.log(val1);
                    console.log('mario fernando muñoz rivera');
                    let me = this;
                        me.loading = true;
                        me.idcliente = val1.id;
                        me.usuario_cliente=val1.nombre+'  '+val1.tipo_documento+'  '+val1.num_documento +' DIR: '+val1.direccion+' TEL: '+val1.telefono;
                  },


                listarArticulo(buscarArt, criterioArticulo){
                 let me=this;
                  var url= '/ventas/ListarArticuloVenta?buscar=' + buscarArt + '&criterio=' + criterioArticulo;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    console.log(respuesta);
                    //todo lo que retorne esta funcion se almacene en este array
                    me.ListararrayArticulo = respuesta.listarticulos.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                 },


              
                        
               BuscarArticuloBarraVenta(){
                let me=this;
                var url= '/ventas/buscarArticuloVentaBarra?filtro='+me.codigo;
                 axios.get(url).then(function (response) {
                     console.log(response.data);
                    let respuesta = response.data;
                    me.arrayArticulo=respuesta.buscarBarra;

                    
                    
                    //si existe elemento en el array
                    if(me.arrayArticulo.length>0){
                        me.idarticulo=me.arrayArticulo[0]['id'];
                        me.articulo=me.arrayArticulo[0]['nombre'];
                        me.precio=me.arrayArticulo[0]['precio_venta'];
                        me.cantidad=0;
                        me.stock=me.arrayArticulo[0]['stock'];


                    }
                    else{
                        me.articulo='No existe articulo';
                        me.idarticulo=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                }); 
                 },
                 
                 //agregar articulos al detalle  As0caiman*
                 agregarDetalle(){
                     let m;
                     if(this.idarticulo==0 || this.cantidad==0 || this.precio==0){}
                        
                        else{
  
                         //validar si el productos ya se encuentra en los detalles
                         if(this.encuentra(this.idarticulo)){
                             this.aux=0;
                          Swal.fire(
                            'Advertencia!',
                            'este articulo ya esta agregado!', 
                            'warning'
                            )
                         }else{

                             if(this.stock<this.cantidad){
                                 Swal.fire(
                            'Informacion!',
                            'La cantidad a vender es mayor a los productos que tiene en el inventario ! '+this.stock, 
                            'info'
                              )

                             }else{
     
                               //push para agregar valores al array
                                this.arrayDetalleVenta.push({
                                idarticulo:this.idarticulo,
                                articulo: this.articulo,
                                cantidad : this.cantidad,
                                precio: this.precio,
                                descuento:this.descuento,
                                stock:this.stock,

                                });
                                this.codigo='';
                                this.idarticulo=0;
                                this.articulo='';
                                this.cantidad=0;
                                this.precio=0;
                                this.descuento=0;
                                this.stock=0;
                            }


                         }
                      
                     }
                 },

                 agregarDetallesModal(data=[]){

                       if(this.encuentra(data['id'])){
                             this.aux=0;
                          Swal.fire(
                            'Advertencia!',
                            'este articulo ya esta agregado!', 
                            'warning'
                            )
                         }else{
                     //push para agregar valores al array
                        this.arrayDetalleVenta.push({
                        idarticulo:data['id'],
                        articulo: data['nombre'],
                        cantidad : 1,
                        stock:data['stock'],
                        precio: data['precio_venta'],
                        descuento:0,
                       });
                      }

                 },

                 encuentra(id){
                     let aux=0;
                     for(var i=0; i<this.arrayDetalleVenta.length; i++){
                         if(this.arrayDetalleVenta[i].idarticulo==id){
                             this.aux=true;
                         }
                     }
                     
                     return this.aux; 
                 },

                 eliminarDetalle(index){
                    this.arrayDetalleVenta.splice(index,1);
                 },

                 modalFormaVenta(){
                     if(this.total==0){
                         Swal.fire(
                            'Advertencia!',
                            'No tiene articulos agregado', 
                            'warning'
                            )
                         return ;
                     }
                     this.modalPago=1;
                     this.formapagoventa.efectivo=this.total;
                 },



                 sincronada: function(){
                     if(this.total==(parseInt(this.formapagoventa.efectivo)+parseInt(this.formapagoventa.credito)+parseInt(this.formapagoventa.datafono)+parseInt(this.formapagoventa.transferencia)))
                     {
                                 
                     }else{
                            
                      }
                 },




                registrarVenta(){
                    
                     if(this.total!=(parseInt(this.formapagoventa.efectivo)+parseInt(this.formapagoventa.credito)+parseInt(this.formapagoventa.datafono)+parseInt(this.formapagoventa.transferencia)))
                     {
                         Swal.fire(
                            'Advertencia!',
                            'EL VALOR A FACTURAR ES DIFERENTE', 
                            'warning'
                            )
                         return ;        
                     }

                        if(this.validarVenta()){
                            return ;
                        }



                        let me=this;


                        me.contadorval++;
                        if(me.contadorval>=2){

                            me.cerrarModal();
                            me.listado=1;  
                            Swal.fire(
                            'Correcto!',
                            'Venta realizada correctamente', 
                            'success'
                            ) 

                            me.listaVenta(1,'','num_comprobante_pago');

                            return ;
                        }

                        me.isLoaded = true;

                        axios.post('/ventas/registrar', {
                            'idcliente':  this.idcliente,
                            'tipo_comprobante': this.tipo_comprobante,
                            'forma_pago': this.forma_pago,
                            'num_comprobante_pago': this.num_comprobante_pago,
                            'impuesto': this.impuesto,
                            'total':this.total,
                            'caba':this.caba,
                            'data':this.arrayDetalleVenta,
                            'formapagoajusteventa':this.formapagoventa

                            
                        })
                        .then(function (response) {
                            me.isLoaded = false;
                            me.contadorval=0;
                            me.cerrarModal();
                            me.listado=1;                            
                            console.log(response.data.usuarioss);
                             me.id_ticket=response.data.id;
                             me.usuarioFacturador=response.data.usuarioss;
                            const swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                        confirmButton: 'btn btn-success',
                                        cancelButton: 'btn btn-danger'
                                    },
                                    buttonsStyling: false
                                    })

                                    swalWithBootstrapButtons.fire({
                                    title: 'Venta realizada correctamente',
                                    text: "¿ Que tipo de formato de factura desea imprimir ?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Normal',
                                    cancelButtonText: 'Ticket',
                                    reverseButtons: true
                                    }).then((result) => {
                                    if (result.isConfirmed) {
                                        
                                      
                                    window.open('/ventas/pdfVenta/'+response.data.id+','+'_blank');
                                    me.listado= 1;
                                    me.vaciarvariable();
                                     // //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                                     me.listaVenta(1,'','num_comprobante_pago');

                                    } else if (
                                        /* Read more about handling dismissals below */
                                        result.dismiss === Swal.DismissReason.cancel
                                    ) {
                                        me.cerrarModal();
                                        me.ticket=1;
                                        me.listado=1;
                                        // me.vaciarvariable();
                                        // //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                                       me.listaVenta(1,'','num_comprobante_pago');

                                    }
                                    })
                       
                        }) 
                        .catch(function (error) {
                            console.log(error);
                        });

                  },

                vaciarvariable(){
 
                        this.idcliente=0;
                        this.tipo_comprobante= 'FACTURA';
                        this.forma_pago = 'efectivo';
                        this.num_comprobante_pago= '';
                        this.impuesto='';
                        this.impuesto= 19;
                        this.total= 0.0;
                        this.idarticulo=0;
                        this.articulo='';
                        this.cantidad='';
                        this.precio='';
                        this.arrayDetalleVenta=[];
                        this.modalPago=0;


                 },
    
                //methods validar las usuario
                validarVenta(){

                    this.errorVenta=0;
                    this.errorMensajearrayVenta=[];
                    var art;
                    var cadena="";
 
                       //validar el stock 
                      this.arrayDetalleVenta.map(function(x){
                          if(x.cantidad>x.stock){
                              art=x.articulo+"  con stock insuficiente"
                              cadena+=art;

                          }
                      });

                      if(cadena.length>0){
                           this.errorMensajearrayVenta.push(cadena);
                      }



                //this.arrayDetalleVenta.push(cadena);
                    if(this.idcliente==0) this.errorMensajearrayVenta.push("Seleccione un Cliente ");
                   // if(!this.num_comprobante_pago) this.errorMensajearrayVenta.push("Seleccione numero de comprobante ");
                    if(!this.tipo_comprobante) this.errorMensajearrayVenta.push("Ingrese tipo de comprobante ");
                    if(this.arrayDetalleVenta.length<=0) this.errorMensajearrayVenta.push("Ingrese algun producto");

                    if(this.errorMensajearrayVenta.length) this.errorVenta=1;
                    return this.errorVenta;
                },
           
                mostrarDetalle(){
                    this.vaciarvariable();
                    this.listado=0;
                },

                ocultarDetalle(){
                    this.nombreAnulaVenta='';
                    this.estadovali='';
                    this.fecha_ven_anulada='';
                    this.listado=1;
                },

                verDetalleVenta(id){
                    this.listado=2;
                   // obtener los datos del objeto

                  let me=this;
                  var TemporalObj=[];
                  var url= '/ventas/getObjetoDetalleVenta?id=' +id;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    //todo lo que retorne esta funcion se almacene en este array
                    TemporalObj = respuesta.ObjetoDetalleVent;
                      console.log('==========champeta========');
                      console.log(TemporalObj[0]['total']);
                      console.log('==========champeta========');

                      console.log('==================');
                      console.log(TemporalObj[0]['formaspago']);
                      console.log('==================');
                    me.arrayFormaPagoDetalle=TemporalObj[0]['formaspago'];

                    me.cliente=TemporalObj[0]['cliente_persona']['nombre'];
                    me.impuesto=TemporalObj[0]['impuesto'];
                    me.tipo_comprobante=TemporalObj[0]['tipo_comprobante'];
                    me.forma_pago=TemporalObj[0]['forma_pago'];
                    me.num_comprobante_pago=TemporalObj[0]['num_comprobante_pago'];
                    me.total=TemporalObj[0]['total'];
                    me.totalDetalleM=TemporalObj[0]['total'];
                    me.fecha_hora=TemporalObj[0]['created_at'];
                    me.idventa=TemporalObj[0]['id'];
                    me.nombreAnulaVenta=TemporalObj[0]['usuario_anulo_venta']['usuario'];
                    me.estadovali=TemporalObj[0]['estado'];
                    me.fecha_ven_anulada=TemporalObj[0]['updated_at'];  

                    console.log('========mario fernando =================================');
                    console.log(TemporalObj[0]['formaspago']);
                    console.log('=============mario fernando ============================');



                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                   // obtener los datos del array


                  var urldetalle= '/ventas/getArrayDetalleVenta?id=' +id;
                  axios.get(urldetalle).then(function (response) {

                    console.log('mario '+response.data);
                    let respuesta = response.data;
                    me.listadoDetalleVenta=respuesta.ArrayDetalleVenta;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });


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
                        title: 'Estas seguro de Anular esta venta?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.isConfirmed) {
                            let me=this;
                        axios.put('/ventas/anularVenta', {
                            'id' : id
                        })
                        .then(function (response) {
                            //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                        me.listaVenta(1,'','num_comprobante_pago');
                            swalWithBootstrapButtons.fire(
                            'Anulado',
                            'La venta ha sido Anulado correctamente',
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

                descargarventa(id){
                    window.open('/ventas/pdfVenta/'+id+','+'_blank');
                },


                imprimir() {
                    this.ticket=0;
                     window.print();
                },
  //<p class="centrado" v-text="'Total  $  '+Intl.NumberFormat().format((total)) +'\n '+tipo_comprobante+'   \nEfectivo: '+Intl.NumberFormat().format(this.formapagoventa.efectivo)+' \nCredito: '+Intl.NumberFormat().format(this.formapagoventa.credito)+' \nTransferencia: '+Intl.NumberFormat().format(this.formapagoventa.transferencia)+' \nDatafono: '+Intl.NumberFormat().format(this.formapagoventa.datafono)+'  '">

                showModalCopy(venta){

                    let me=this;
                    me.arrayDetalleVenta=[];

                    console.log(venta);
                    this.vectorTicked.push(venta);
                    this.ticketcopy=1;
                    this.id_ticket=venta.id;
                    this.usuarioFacturador=venta.usuario_hizola_venta.usuario;
                    this.usuario_cliente=venta.cliente_persona.nombre+' '+venta.cliente_persona.tipo_documento+' '+venta.cliente_persona.num_documento +' DIR:'+ venta.cliente_persona.direccion+' TEL: '+venta.cliente_persona.telefono;
                    this.copyfechatherma=venta.created_at;
                    this.num_comprobante_pago=venta.num_comprobante_pago;
                    this.formapagoventa.efectivo=venta.formaspago.efectivo;
                    this.formapagoventa.credito=venta.formaspago.credito;
                    this.formapagoventa.transferencia=venta.formaspago.tranferencia;
                    this.formapagoventa.datafono=venta.formaspago.datafono;

                    venta.detalle_venta.map(function(x){
                        me.arrayDetalleVenta.push({
                            idarticulo:x.idarticulo,
                            articulo: x.articulo__detalle__venta.nombre,
                            cantidad : x.cantidad,
                            precio: x.precio,
                            descuento:x.descuento,
                            });
                        
                    });
              },



              //metodo para cerrar el modal
              cerrarModal(){
                },



                //metodo para cerrar el modal
                cerrarModal(){
                    this.ticket=0;
                    this.ticketcopy=0;
                    this.modal=0;
                    this.tituloModal='';
                    this.modalPago=0;
                },

                //recibe tres paramatro el nombre del modelo "usuario",  accion "registrar o actualizar", el objeto "" 
                abrirModal(){   
                this.arrayArticulo=[];    
                this.modal=1;
                this.tituloModal='Seleccione uno o varios Articulos';
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
       //hacemos referencia a nuestro metodo  listaVenta
      this.listaVenta(1,this.buscar,this.criterio);  
      this.validateOpenCaja();   
         }
    }
</script>


<style>


.modal-contentt{
    width: 100% !important;
    position: absolute!important;
}

.modal-content{
    
    width: 100% !important;
    position: absolute!important;
}


.modal-contentmarop{
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
  @media(min-width:600px){
      .btnagregar{
          margin-top: 2rem;
      }
  }
 .totalresultado{
      background-color:#CEECF5;
  }
  .validaridArticulo{
      color: red;
      font-weight: 600;
  }
  .negritatitle{
      font-weight: 500;
  }

* {
    font-size: 14px;
  font-family: Arial, Helvetica, sans-serif;
}

td,
th,
tr,
table {
    border-top: 1px solid black;
    border-collapse: collapse;
}

td.producto,
th.producto {
    width: 75px;
    max-width: 75px;
}

td.cantidad,
th.cantidad {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

td.precio,
th.precio {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

.centrado {
    text-align: initial;
    align-content: center;
}

.ticket {
    width: 155px;
    max-width: 155px;
}

img {
    max-width: inherit;
    width: inherit;
}


@media print {
    .oculto-impresion,
    .oculto-impresion * {
        display: none !important;
    }
}



</style>