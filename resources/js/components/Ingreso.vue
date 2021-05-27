<template>
<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Escritorio</a></li>
            </ol>

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

            <div class="container-fluid" v-if="validar_caja=='ok'">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>Ingreso
                            <button type="button" @click="mostrarDetalle()" class="btn btn-secondary btn-sm" data-toggle="modal">
                            <i class="icon-plus"></i>Nuevo
                             </button>


                    </div>
                    <!--Listado-->
                    <template v-if="listado==1">
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="num_comprobante">Num Comprobante</option>
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
                                                <th>#</th>
                                                <th>Usuario</th>
                                                <th>Proveedor</th>
                                                <th>Tipo comprobante</th>
                                                <th>Serie Comprobante</th>
                                                <th>Num Comprobante</th>
                                                <th>Fecha</th>
                                                <th>Total</th>
                                                <th>Impuesto</th>
                                                <th>Estado</th>
                                                <th>Opciones</th>




                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="ingreso in arrayIngreso" :key="ingreso.id">
                                                
                                                    <td v-text="ingreso.id"></td>
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

                                                    <button type="button" class="btn btn-success btn-sm" @click="VerDetalleIngreso(ingreso.id)">
                                                    <i class="icon-eye"></i>
                                                    </button> 


                                                    <button type="button" class="btn btn-info btn-sm" @click="descargaringreso(ingreso.id)">
                                                    <i class="icon-doc"></i>
                                                    </button>


                                                    <template v-if="ingreso.estado=='registrado'"> 
                                                    <button type="button"  class="btn btn-danger btn-sm" @click="anularIngreso(ingreso.id)">
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
                                    <label for="">Proveedor(*)</label>
                                    <v-select
                                        @search="selectProveedor"
                                        label="nombre"
                                        aria-label=""
                                        :options="arrayProveedor"
                                        placeholder="Buscar Proveedores..."
                                        @input="getDatosProveedor"                                        
                                    >
                                    </v-select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Impuesto %(*)</label>
                                    <input type="text" class="form-control"  v-model="impuesto">
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <label>Tipo Comprobante(*)</label>
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
                                        <label>Serie Comprobante</label>
                                        <input type="text" class="form-control"  v-model="serie_comprobante" placeholder="002-2">
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <label>Num Comprobante(*)</label>
                                        <input type="text" class="form-control"  v-model="num_comprobante" placeholder="002-2">
                                    </div>
                                </div>

                             <div class="col-md-12">
                                <div v-show="errorIngreso==1" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMensajeArrayIngreso" :key="error" v-text="error">
                                           
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
                                         <input type="" v-model="codigo" @keyup.enter="buscarArticuloCodigoBarra()"  placeholder="Ingrese el articulo">
                                         <button class="btn btn-primary" @click="abrirModal()">...</button>
                                         <input type="text" readonly class="form-control" v-model="articulo">
                                     </div>
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
                                     <label>Precio compra<span class="validaridArticulo" v-show="preciocompra==0">*</span></label><br>
                                     <input type="number" min="0" v-model="preciocompra" value="0" step="any"  placeholder="000.0">
                                 </div>                   
                              </div>

                              <div class="col-md-2">
                                 <div class="form-group">
                                     <label>Precio venta<span class="validaridArticulo" v-show="precio==0">*</span></label><br>
                                     <input type="number" min="0" v-model="precio" value="0" step="any"  placeholder="000.0">
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
                                            <th>Cantidad</th>
                                            <th>Precio compra</th>
                                            <th>Precio venta</th>
                                            <th>Subtotal</th>
                                            <th>Ganancia</th>
                                            <th>%</th>

                                         </tr>
                                     </thead>
                                     <tbody v-if="arrayDetalleIngreso.length">

                                         <tr v-for="(detalle,index) in arrayDetalleIngreso" :key="detalle.id">
                                            <th>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </th>

                                            <th v-text="detalle.articulo"></th>
                                            <td>
                                                <input v-model="detalle.cantidad" type="number" value="3" class="form-control">
                                            </td>

                                            <td>
                                                <input v-model="detalle.preciocompra" type="number" value="2" class="form-control">
                                            </td>


                                            <td>
                                                <input v-model="detalle.precio" type="number" value="2" class="form-control">
                                            </td>
                                            <td>
                                                {{ Intl.NumberFormat().format(detalle.preciocompra*detalle.cantidad)  }}
                                            </td>


                                            <!--ganancia-->

                                            <td>
                                                {{ Intl.NumberFormat().format((detalle.precio-detalle.preciocompra)*detalle.cantidad)  }}
                                            </td>

                                            <!--porcentaje-->
                                            <td v-if="(100-((detalle.preciocompra*100)/detalle.precio))<0" style="color:red; font-weight: 900;">
                                                {{ (100-((detalle.preciocompra*100)/detalle.precio)).toFixed(2)  }} <b>%</b>
                                            </td>
                                            <td v-else>
                                                {{ (100-((detalle.preciocompra*100)/detalle.precio)).toFixed(2)  }} <b>%</b>
                                            </td>
                                         </tr>



                                         <tr class="totalresultado" >
                                             <td colspan="6" align="right"><strong>Subtotal:</strong></td>
                                             <td colspan="2">$ {{ Intl.NumberFormat().format(subtotal=(total-totalImpuesto )) }}</td>
                                         </tr>


                                         <tr class="totalresultado" >
                                             <td colspan="6" align="right"><strong>Impuesto:</strong></td>
                                             <td colspan="2">$ {{ Intl.NumberFormat().format(totalImpuesto=((total*impuesto )/100)) }}</td>
                                         </tr>

                                         <tr class="totalresultado" >
                                             <td colspan="6" align="right"><strong>Total Neto:</strong></td>
                                             <td colspan="2" >$ {{ Intl.NumberFormat().format((total=calculadorTotal))}}</td>
                                         </tr>

                                         <tr class="totalresultado" >
                                             <td colspan="6" align="right"><strong>Total Ganancias:</strong></td>
                                             <td colspan="2" >$ {{ Intl.NumberFormat().format((calcularTotalGanancia))}}</td>
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
                           </div>


                        <div class="form-group row">
                           <div class="col-md-12">
                               <button type="button" @click="ocultarDetalle  ()" class="btn btn-secondary">Cerrar</button>
                              <button type="button" class="btn btn-primary" @click="registrarIngreso()">Registrar Compra</button>

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
                                    <p v-text="idingreso"></p>
                                </div>

                                <div class="col-md-3">
                                    <label class="negritatitle">Fecha Ingreso</label>
                                    <p v-text="fecha_hora"></p>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label class="negritatitle">Proveedor</label>
                                    <p v-text="proveedor"></p>
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
                                        <label class="negritatitle">Serie Comprobante</label>
                                        <p v-text="serie_comprobante"></p>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group"> 
                                        <label class="negritatitle">Num Comprobante</label>
                                        <p v-text="num_comprobante"></p>
                                    </div>
                                </div>



                                <div class="col-md-3" v-if="estadovaling=='anulado'">
                                    <div class="form-group validaridArticulo"> 
                                        <p v-text="'Compra anulada por:  '+nombreAnulaIngreso+' fecha '+fecha_ing_anulada"></p>
                                    </div>
                                </div>



                         </div>

                    <!--show article-->
                        <div class="form-group row border">
                           <div class="table-responsive col-md-12">
                                 <table class="table table-bordered table-striped table-sm">
                                    
                                     <thead>
                                         <tr>

                                            <th>Articulo</th>
                                            <th>Cantidad</th>
                                            <th>Precio compra</th>
                                            <th>Precio venta</th>
                                            <th>Subtotal</th>
                                            <th>Ganancia</th>
                                            <th>%</th>

                                         </tr>
                                     </thead>
                                    <tbody>

                                         <tr v-for="(detalles) in listarDetalleIngreso" :key="detalles.id">
                                          
                                            <th v-text="detalles.articulodetalle.nombre"></th>
                                            <th v-text="detalles.cantidad"></th>
                                            <th v-text="Intl.NumberFormat().format(detalles.preciocompra)"></th>
                                            <th v-text="Intl.NumberFormat().format(detalles.precio)"></th>
                                            <th v-text="Intl.NumberFormat().format((detalles.cantidad*detalles.preciocompra))"></th>
                                            <th v-text="Intl.NumberFormat().format(((detalles.precio-detalles.preciocompra)*detalles.cantidad))"></th>
                                            <th v-text="(100-((detalles.preciocompra*100)/detalles.precio)).toFixed(2)"></th>
                                            
                                         </tr>

                                         <tr class="totalresultado" >
                                             <td colspan="6" align="right"><strong>Subtotal:</strong></td>
                                             <td colspan="2">$ {{ Intl.NumberFormat().format((total ) - ((total*impuesto )/100)   ) }}</td>
                                         </tr>

                                         <tr class="totalresultado" >
                                             <td colspan="6" align="right"><strong>Impuesto:</strong></td>
                                             <td colspan="2">$ {{ Intl.NumberFormat().format(((total*impuesto )/100)) }}</td>
                                         </tr>

                                         <tr class="totalresultado" >
                                             <td colspan="6" align="right"><strong>Total Neto:</strong></td>
                                             <td colspan="2" >$ {{ Intl.NumberFormat().format((calculadorTotalDetalle))}}</td>
                                         </tr>

                                         <tr class="totalresultado" >
                                             <td colspan="6" align="right"><strong>Total Ganancias:</strong></td>
                                             <td colspan="2" >$ {{ Intl.NumberFormat().format((calcularTotalGananciaDetalle))}}</td>
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
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">








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
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccionButton==1" class="btn btn-outline-primary" @click="registrarIngreso()">Guardar</button>

                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
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
            //cual es la usuario que quiero edit 
            ingreso_id :0,
            idproveedor : 0,
            proveedor: '',
            
            tipo_comprobante: 'FACTURA',
            serie_comprobante : '',
            num_comprobante: '',
            telefono:'',
            impuesto: 18,
            totalgananciass: 0.0,
            total: 0.0,
            totalImpuesto:0.0,
            subtotal: 0.0,
            fecha_hora:'',
            idingreso:'',
            //variable para ver el listado
            listado: 1,
            //la data que regresa nuestro metodo listarIngreso se almacene en esta array
            arrayIngreso:[],
            arrayDetalleIngreso:[],
            arrayProveedor:[],
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
            criterioArticulo:'nombre',
            buscar  : '',
            buscarArt:'',
            arrayArticulo:[],
            ListararrayArticulo:[],
            listarDetalleIngreso:[],
            idarticulo:0,
            codigo:'',
            articulo:'',
            precio:0,
            preciocompra:0,
            cantidad:0,
             //validar caja open
             validar_caja:'',


            nombreAnulaIngreso:'',
            estadovaling:'',
            fecha_ing_anulada:'',

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
                for(var i=0; i<this.arrayDetalleIngreso.length; i++){
                  resultado+=this.arrayDetalleIngreso[i].preciocompra*this.arrayDetalleIngreso[i].cantidad;
                }
                return resultado;
            },
            calcularTotalGanancia : function(){
                var totalgan=0.0;
                var aux=0.0;
                for(var i=0; i<this.arrayDetalleIngreso.length; i++){
                  aux+=this.arrayDetalleIngreso[i].precio-this.arrayDetalleIngreso[i].preciocompra;
                  totalgan+=aux*this.arrayDetalleIngreso[i].cantidad;
                  aux=0.0;
                }
                return totalgan;
            },
            calculadorTotalDetalle : function(){
                var resultado=0.0;
                for(var i=0; i<this.listarDetalleIngreso.length; i++){
                  resultado+=this.listarDetalleIngreso[i].preciocompra*this.listarDetalleIngreso[i].cantidad;
                }
                return resultado;
            },
            calcularTotalGananciaDetalle : function(){
                var totalgan=0.0;
                var aux=0.0;
                for(var i=0; i<this.listarDetalleIngreso.length; i++){
                  aux+=this.listarDetalleIngreso[i].precio-this.listarDetalleIngreso[i].preciocompra;
                  totalgan+=aux*this.listarDetalleIngreso[i].cantidad;
                  aux=0.0;
                }
                return totalgan;
            },
        },
//{{ Intl.NumberFormat().format((detalle.precio-detalle.preciocompra)*detalle.cantidad)  }}
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

               
                selectProveedor(search,loading){
               //  console.log(loading);                    
                let me=this;
                loading(true);
                var url= '/proveedor/selectProveedor?filtro='+search;
                axios.get(url).then(function (response) {
                    console.log(response.data);
                  let respuesta = response.data;
                    me.arrayProveedor=respuesta.proveedores;
                    loading(false)                    
    
                })
                .catch(function (error) {
                    console.log(error);
                });           
                 },
 
                getDatosProveedor(val1){
                    let me = this;
                        me.loading = true;
                        me.idproveedor = val1.id;
                    },
                listarArticulo(buscarArt, criterioArticulo){
                 let me=this;
                  var url= '/ingresos/ListarArticuloIngreso?buscar=' + buscarArt + '&criterio=' + criterioArticulo;
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
              
                buscarArticuloCodigoBarra(){
                let me=this;
                var url= '/articulo/buscarArticuloBarra?filtro='+me.codigo;
                 axios.get(url).then(function (response) {
                    console.log(response.data);
                    let respuesta = response.data;
                    me.arrayArticulo=respuesta.buscarBarra;
                    //si existe elemento en el array
                    if(me.arrayArticulo.length>0){
                        me.articulo=me.arrayArticulo[0]['nombre'];
                        me.idarticulo=me.arrayArticulo[0]['id'];
                    }else{
                        me.articulo='No existe articulo';
                        me.idarticulo=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                }); 
                 },
                 //agregar articulos al detalle 
                 agregarDetalle(){
                     let m;
                     if(this.idarticulo==0 || this.cantidad==0 || this.precio==0)
                        {}else{
                         //validar si el productos ya se encuentra en los detalles
                         if(this.encuentra(this.idarticulo)){
                             this.aux=0;
                          Swal.fire(
                            'Error!',
                            'este articulo ya esta agregado!', 
                            'error'
                            )
                         }else{
                     //push para agregar valores al array
                        this.arrayDetalleIngreso.push({
                        idarticulo:this.idarticulo,
                        articulo: this.articulo,
                        cantidad : this.cantidad,
                        precio: this.precio,
                        preciocompra:this.preciocompra,
                       });
                        this.codigo='';
                        this.idarticulo=0;
                        this.articulo='';
                        this.cantidad=0;
                        this.precio=0;
                        this.preciocompra=0;
                      }
                      
                     }
                 },
                 agregarDetallesModal(data=[]){
                       if(this.encuentra(data['id'])){
                             this.aux=0;
                          Swal.fire(
                            'Advertencia!',
                            'este articulo ya esta agregado!', 
                            'info'
                            )
                         }else{
                     //push para agregar valores al array
                        this.arrayDetalleIngreso.push({
                        idarticulo:data['id'],
                        articulo: data['nombre'],
                        cantidad : 1,
                        precio: 1,
                        preciocompra:1,
                       });
                      }
                 },
                 encuentra(id){
                     let aux=0;
                     for(var i=0; i<this.arrayDetalleIngreso.length; i++){
                         if(this.arrayDetalleIngreso[i].idarticulo==id){
                             this.aux=true;
                         }
                     }
                     
                     return this.aux; 
                 },
                 eliminarDetalle(index){
                    this.arrayDetalleIngreso.splice(index,1);
                 },
                //Metodo registrar usuario
                registrarIngreso(){
                        if(this.validarIngreso()){
                            return ;
                        }
                        let me=this;
                        axios.post('/ingresos/registrar', {
                            'idproveedor':  this.idproveedor,
                            'tipo_comprobante': this.tipo_comprobante,
                            'serie_comprobante': this.serie_comprobante,
                            'num_comprobante': this.num_comprobante,
                            'impuesto': this.impuesto,
                            'total':this.total,
                            'data':this.arrayDetalleIngreso,
                            
                            
                        })
                        .then(function (response) {
                            console.log('entro a esta funcion');
                            me.listado= 1;
                            me.vaciarvariable();
                        //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                        me.listarIngreso(1,'','num_comprobante');
                        }) 
                        .catch(function (error) {
                            console.log(error);
                        });
                    },
                vaciarvariable(){
                        this.idproveedor=0;
                        this.tipo_comprobante= 'FACTURA',
                        this.serie_comprobante = '',
                        this.num_comprobante= '',
                        this.impuesto='',
                        this.impuesto= 18,
                        this.total= 0.0,
                        this.idarticulo=0,
                        this.articulo='',
                        this.cantidad='',
                        this.precio='',
                        this.arrayDetalleIngreso=[];
                },
    
                //methods validar las usuario
                validarIngreso(){
                    this.errorIngreso=0;
                    this.errorMensajeArrayIngreso=[];
                    if(this.idproveedor==0) this.errorMensajeArrayIngreso.push("Seleccione un proveedor ");
                    if(!this.num_comprobante) this.errorMensajeArrayIngreso.push("Seleccione numero de comprobante ");
                    if(!this.tipo_comprobante) this.errorMensajeArrayIngreso.push("Ingrese tipo de comprobante ");
                    if(this.arrayDetalleIngreso.length<=0) this.errorMensajeArrayIngreso.push("Ingrese algun producto");
                    if(this.errorMensajeArrayIngreso.length) this.errorIngreso=1;
                    return this.errorIngreso;
                },
                
                descargaringreso(id)
                {
                    window.open('/ingresos/pdfIngreso/'+id+','+'_blank');

                },
           
              
                mostrarDetalle(){
                    this.vaciarvariable();
                    this.listado=0;
                },
                ocultarDetalle(){

                    this.nombreAnulaIngreso='';
                    this.estadovaling='';
                    this.fecha_ing_anulada='';
                    this.listado=1;
                },
                VerDetalleIngreso(id){
                    this.listado=2;
                   // obtener los datos del objeto
                  let me=this;
                  var TemporalObj=[];
                  var url= '/ingresos/getObjetoDetalleIngreso?id=' +id;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    //todo lo que retorne esta funcion se almacene en este array
                    TemporalObj = respuesta.ObjetoDetalleIngreso;
                    me.proveedor=TemporalObj[0]['proveedoress']['nombre'];
                    me.impuesto=TemporalObj[0]['impuesto'];
                    me.tipo_comprobante=TemporalObj[0]['tipo_comprobante'];
                    me.serie_comprobante=TemporalObj[0]['serie_comprobante'];
                    me.num_comprobante=TemporalObj[0]['num_comprobante'];
                    me.total=TemporalObj[0]['total'];
                    me.fecha_hora=TemporalObj[0]['created_at'];
                    me.idingreso=TemporalObj[0]['id'];


                    me.nombreAnulaIngreso=TemporalObj[0]['usuario_anulo_ingreso']['usuario'];
                    me.estadovaling=TemporalObj[0]['estado'];
                    me.fecha_ing_anulada=TemporalObj[0]['updated_at'];  


                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                   // obtener los datos del array
                  var urldetalle= '/ingresos/getArrayDetalleIngreso?id=' +id;
                  axios.get(urldetalle).then(function (response) {
                    console.log('mario '+response.data);
                    let respuesta = response.data;
                    me.listarDetalleIngreso=respuesta.ArrayDetalleIng;
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
                        title: 'Estas seguro de Anular este Ingreso?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.isConfirmed) {
                            let me=this;
                        axios.put('/ingresos/anularIngreso', {
                            'id' : id
                        })
                        .then(function (response) {
                            //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                        me.listarIngreso(1,'','num_comprobante');
                            swalWithBootstrapButtons.fire(
                            'Anulado',
                            'El Ingreso ha sido Anulado correctamente',
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
                //metodo para cerrar el modal
                cerrarModal(){
                    this.modal=0;
                    this.tituloModal='';
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
       //hacemos referencia a nuestro metodo  listarIngreso
      this.listarIngreso(1,this.buscar,this.criterio);  
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
      font-weight: 500;
  }
  .negritatitle{
      font-weight: 500;
  }
</style>