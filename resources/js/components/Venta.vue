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
                        <i class="fa fa-align-justify"></i>Ventas
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
                                        <option value="id">Id</option>
                                        <option value="fecha_hora">Fecha-Hora</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listaVenta(1,buscar,criterio)"  class="form-control" placeholder="Buscar...">
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
                                                <th>Num Comprobante</th>
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
                                                    <td v-text="venta.forma_pago"></td>
                                                    <td v-text="venta.num_comprobante_pago_pago"></td>
                                                    <td v-text="venta.created_at"></td>
                                                    <td v-text="venta.total"></td>
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
                                                    </button> &nbsp;


                                                    <button type="button" class="btn btn-info btn-sm" @click="descargarventa(venta.id)">
                                                    <i class="icon-doc"></i>
                                                    </button> &nbsp;


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
                                        <label>Tipo Comprobante <span  class="validaridArticulo"   v-show="forma_pago==0">*</span></label>
                                            <select class="form-control" v-model="forma_pago">
                                                <option value="0">Seleccione</option>
                                                <option value="efectivo">EFECTIVO</option>
                                                <option value="datafono">DATAFONO</option>
                                                <option value="bancolombia">BANCOLOMBIA</option>
                                                <option value="nequi">NEQUI</option>

                                            </select>
                                    </div>
                                </div>



                                <div class="col-md-4" v-if="forma_pago=='datafono' || forma_pago=='bancolombia' || forma_pago=='nequi'">
                                    <div class="form-group"> 
                                        <label>Num Comprobante<span  class="validaridArticulo"   v-show="num_comprobante_pago==0">*</span></label>
                                        <input type="text" class="form-control"  v-model="num_comprobante_pago" placeholder="002-2">
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
                                             <td colspan="4" align="right"><strong>Totasl Neto:</strong></td>
                                             <td colspan="2" >$ {{ Intl.NumberFormat().format((total=(calculadorTotal)))}}</td>
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
                               <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                              <button type="button" class="btn btn-primary" @click="registrarVenta()">Guardar venta</button>
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
                                        <p v-text="forma_pago"></p>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group"> 
                                        <label class="negritatitle">Num Comprobante</label>
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
                                             <td colspan="2">$ {{ Intl.NumberFormat().format((total) - ((total*impuesto )/100)   ) }}</td> 
                                         </tr>

                                         <tr class="totalresultado" >
                                             <td colspan="4" align="right"><strong>Impuesto:</strong></td>
                                              <td colspan="2">$ {{ Intl.NumberFormat().format(((total*impuesto )/100)) }}</td>
                                         </tr>

                                         <tr class="totalresultado" >
                                             <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                             <td colspan="2" >$ {{ Intl.NumberFormat().format((total))}}</td> 
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
                            <button type="button" v-if="tipoAccionButton==1" class="btn btn-primary" @click="registrarVenta()">Guardar</button>

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
            idcliente : 0,
            cliente: '',
            
            tipo_comprobante: 'FACTURA',
            forma_pago : 'efectivo',
            num_comprobante_pago: '',
            telefono:'',
            impuesto: 18,
            totalgananciass: 0.0,
            total: 0.0,
            totalImpuesto:0.0,
            subtotal: 0.0,
            fecha_hora:'',
            idventa:'',
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
            nombreAnulaVenta:'',
            estadovali:'',
            fecha_ven_anulada:'',
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
                    let me = this;
                        me.loading = true;
                        me.idcliente = val1.id;
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

                 registrarVenta(){
                        if(this.validarVenta()){
                            return ;
                        }

                        let me=this;
                        axios.post('/ventas/registrar', {
                            'idcliente':  this.idcliente,
                            'tipo_comprobante': this.tipo_comprobante,
                            'forma_pago': this.forma_pago,
                            'num_comprobante_pago': this.num_comprobante_pago,
                            'impuesto': this.impuesto,
                            'total':this.total,
                            'data':this.arrayDetalleVenta,

                            
                            
                            
                        })
                        .then(function (response) {
                            console.log('entro a esta funcion');
                             window.open('http://127.0.0.1:8000/ventas/pdfVenta/'+response.data.id+','+'_blank');
                            me.listado= 1;
                            me.vaciarvariable();
                        //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                        me.listaVenta(1,'','num_comprobante_pago');
                        }) 
                        .catch(function (error) {
                            console.log(error);
                        });

                  },

                vaciarvariable(){

                        this.idcliente=0;
                        this.tipo_comprobante= 'FACTURA',
                        this.forma_pago = 'efectivo',
                        this.num_comprobante_pago= '',
                        this.impuesto='',
                        this.impuesto= 18,
                        this.total= 0.0,
                        this.idarticulo=0,
                        this.articulo='',
                        this.cantidad='',
                        this.precio='',
                        this.arrayDetalleVenta=[];


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
                      console.log(TemporalObj[0]['tipo_comprobante']);

                    me.cliente=TemporalObj[0]['cliente_persona']['nombre'];
                    me.impuesto=TemporalObj[0]['impuesto'];
                    me.tipo_comprobante=TemporalObj[0]['tipo_comprobante'];
                    me.forma_pago=TemporalObj[0]['forma_pago'];
                    me.num_comprobante_pago=TemporalObj[0]['num_comprobante_pago'];
                    me.total=TemporalObj[0]['total'];
                    me.fecha_hora=TemporalObj[0]['created_at'];
                    me.idventa=TemporalObj[0]['id'];
                    me.nombreAnulaVenta=TemporalObj[0]['usuario_anulo_venta']['usuario'];
                    me.estadovali=TemporalObj[0]['estado'];
                    me.fecha_ven_anulada=TemporalObj[0]['updated_at'];  



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
                    window.open('http://127.0.0.1:8000/ventas/pdfVenta/'+id+','+'_blank');

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
                }
        },
        mounted() {
       //hacemos referencia a nuestro metodo  listaVenta
      this.listaVenta(1,this.buscar,this.criterio);     
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
      font-weight: 600;
  }
  .negritatitle{
      font-weight: 500;
  }
</style>