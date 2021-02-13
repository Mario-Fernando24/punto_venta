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
                        <i class="fa fa-align-justify"></i> Ajuste de inventario
                      
                        <button  type="button"  @click="abrirModalProductos('ajuste','entra')" class="btn btn-outline-success" >
                            <i class="icon-plus"></i>&nbsp;Entra 
                        </button>

                          <button @click="abrirModalProductos('ajuste','sale')" type="button"   class="btn btn-outline-danger">
                            <i class="icon-minus"></i>&nbsp;Sale
                        </button>
                        
                    </div>

                    <div class="card-body">





                                
                              <div class="form-group row">
                                    <div class="col-sm-4">
                                    <label class="col-md-4 form-control-label" for="email-input">Tipo de ajuste</label>
                                       <h4 v-text="tipo_ajuste"></h4>
                                    </div>

                                    
                                    <div class="col-sm-4">
                                      <label class="col-md-4 form-control-label" for="email-input">Fecha</label>    
                                            <p v-text="currentHour+'     '+currentDay"></p>  
                                    </div>



                                    <div class="col-md-4">
                                        <label>Impuesto %<span  class="validaridArticulo"   v-show="impuesto==0">*</span></label>
                                        <input type="text" class="form-control"  v-model="impuesto">
                                    </div>

                               </div>


                              <div class="form-group row">
                                    <div class="col-sm-12">
                                    <label class="col-md-12 form-control-label" for="email-input">Motivo</label>
                                        <input type="text" v-model="motivo" class="form-control" placeholder="Motivo...">
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
                                            <th>Existencia</th>
                                            <th v-if="tipoAccionButton==1">Entra</th>
                                            <th v-if="tipoAccionButton==2">Sale</th>
                                            <th>Quedan</th>
                                            <th>Subtotal</th>

                                         </tr>
                                     </thead>
                                     <tbody v-if="ArrayDetalleAjusteProductos.length">

                                         <tr v-for="(detalle,index) in ArrayDetalleAjusteProductos" :key="detalle.id">
                                            <th>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </th>
                                            <th v-text="detalle.articulo"></th>
                                            <th v-text="detalle.precio"></th>
                                            <th v-text="detalle.stock"></th>

                                            <td>
                                                <span v-if="tipoAccionButton==1" class="validaridArticulo"></span>
                                                <span class="validaridArticulo" v-if="tipoAccionButton==2" v-show="detalle.cantidad>detalle.stock">Stock {{ detalle.stock }}</span>
                                                <input v-model="detalle.cantidad" type="number"  class="form-control">
                                            </td>

                                            <td v-if="tipoAccionButton==1" v-text="(detalle.stock+parseInt(detalle.cantidad))"></td>
                                            <td v-if="tipoAccionButton==2" v-text="(detalle.stock-parseInt(detalle.cantidad))"></td>


                                            <td>
                                                {{ Intl.NumberFormat().format(parseInt(detalle.cantidad)*detalle.precio)  }}
                                            </td>


                                         </tr>





                                         <tr class="totalresultado">
                                             <td colspan="2" align="right"><strong></strong></td>
                                             <td colspan="4" align="right"><strong>Subtotal:</strong></td>
                                             <td colspan="2" >$ {{ Intl.NumberFormat().format((calculadorTotal-((calculadorTotal*impuesto)/100)))}}</td>
                                         </tr>


                                         <tr class="totalresultado" >
                                             <td colspan="2" align="right"><strong></strong></td>
                                             <td colspan="4" align="right"><strong>Impuesto:</strong></td>
                                             <td colspan="2" >$ {{ Intl.NumberFormat().format(((calculadorTotal*impuesto)/100))}}</td>
                                         </tr>

                                         <tr class="totalresultado" >
                                             <td colspan="2" align="right"><strong></strong></td>
                                             <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                             <td colspan="2" >$ {{ Intl.NumberFormat().format(( total=(calculadorTotal)))}}</td>
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

                        <div class="form-group row" v-if="ArrayDetalleAjusteProductos.length">
                           <div class="col-md-12">
                              <button type="button" v-if="tipoAccionButton==1" class="btn btn-outline-success" @click="AjusteInventarioEntra()">Entran al inventario</button>
                              <button type="button" v-if="tipoAccionButton==2" class="btn btn-outline-danger" @click="AjusteInventarioSale()">Salen del inventario</button>

                           </div>
                        </div>

                       </div>
                        
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>



             <!--modal entran producto en inventario-->

                <div class="modal fade"  tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div  v-bind:class="[activeClass, errorClass]" role="document">
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
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="codigo">Codigo</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarArticulo(buscar,criterio)"  class="form-control" placeholder="Buscar...">
                                    <button type="submit" @click="listarArticulo(buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
                                        <button type="button" @click="agregarDetallesModal(articulomodal)" v-bind:class="[activeClass, errorBotton]" data-toggle="modal">
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
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>


             <!-- final productos que entran-->
            







     
        </main>
</template>

<script>
//axios nos ayuda hacer peticiones http desde el navegador
    export default {
        //dentro de la data colocamos las variables 
        data(){
          return {
            modal : 0,
            tituloModal : '',

            ListararrayArticulo:[],
            activeClass: 'active',
            errorClass: 'modal-dialog modal-danger modal-lg',
            errorBotton: 'btn btn-success btn-sm',
            tipoAccionButton : 0,


            ArrayDetalleAjusteProductos:[],
            idarticulo:0,
            articulo:'',
            cantidad: 0,
            stock: 0,
            precio:0,
            impuesto:18,
            tipo_ajuste:'no ha escogido',

            motivo:'',



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
            },
            calculadorTotal : function(){
                var resultado=0.0;
                var aux=0.0;

                for(var i=0; i<this.ArrayDetalleAjusteProductos.length; i++){
                  aux+=this.ArrayDetalleAjusteProductos[i].precio*this.ArrayDetalleAjusteProductos[i].cantidad;
                  resultado+=aux;
                  aux=0.0;
                }
                return resultado;
            },

        },
        methods: {
            abrirModalProductos(modelo, accion){
                  switch(modelo){
                      case "ajuste":
                     {
                         switch(accion){
                            
                             case 'entra':
                            {
                                this.modal=1;
                                this.tituloModal='Seleccione los producto que entran al inventario';
                                this.activeClass= 'active';
                                this.errorClass= 'modal-dialog modal-success modal-lg';
                                this.errorBotton= 'btn btn-success btn-sm';
                                this.tipoAccionButton=1;
                                this.tipo_ajuste='entra al inventario';

                              break;
                             } 
                             case 'sale':
                            {
                               // console.log(data);
                               this.modal=1;
                               this.tituloModal='Seleccione los producto que salen del inventario';
                               this.activeClass= 'active';
                               this.errorClass= 'modal-dialog modal-danger modal-lg';
                               this.errorBotton= 'btn btn-danger btn-sm';
                               this.tipoAccionButton=2;
                              this.tipo_ajuste='sale de inventario';


                             break;
                             }   
                                 
                         } 
                      }
                  }

              },


              listarArticulo(buscar, criterio){
                 let me=this;
                  var url= '/ventas/ListarArticuloVenta?buscar=' + buscar + '&criterio=' + criterio;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    console.log('ma');
                    //todo lo que retorne esta funcion se almacene en este array
                    me.ListararrayArticulo = respuesta.listarticulos.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

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
                        this.ArrayDetalleAjusteProductos.push({
                        idarticulo:data['id'],
                        articulo: data['nombre'],
                        cantidad : 1,
                        stock:data['stock'],
                        precio: data['precio_venta'],
                       });
                      }

                 },
                 
                 encuentra(id){
                     let aux=0;
                     for(var i=0; i<this.ArrayDetalleAjusteProductos.length; i++){
                         if(this.ArrayDetalleAjusteProductos[i].idarticulo==id){
                             this.aux=true;
                         }
                     }
                     
                     return this.aux; 
                 },
                 eliminarDetalle(index){
                    this.ArrayDetalleAjusteProductos.splice(index,1);
                 },

                cambiarPagina(page, buscar, criterio){
                    let me = this;
                    //actualiza a la pagina actual
                    me.pagination.current_page = page;
                    //envia la peticion de listar esa pagina
                    me.listarArticulo(page, buscar, criterio);
                },

                cerrarModal()
                {
                  this.modal=0;
                },

                vaciarVariables()
                {
                  this.tipoAccionButton = 0;
                  this.ArrayDetalleAjusteProductos=[];
                  this.idarticulo=0;
                  this.articulo='';
                  this.cantidad= 0;
                  this.stock= 0;
                  this.precio=0;
                  this.impuesto=18;
                  this.tipo_ajuste='no ha escogido';
                },

                AjusteInventarioSale()
                {
                    //  if(this.motivo){return ;}

                        let me=this;
                        axios.post('/inventario/ajusteInventarioSale', {
                            'motivo': this.motivo,
                            'impuesto': this.impuesto,
                            'total':this.total,
                            'data':this.ArrayDetalleAjusteProductos,
                        })
                        .then(function (response) {


                         var respuesta=response.data;
                        if(respuesta.status=='ok'){
                            me.vaciarVariables();

                            Swal.fire(
                            'Exitoso (-)',
                            'Ajuste de inventario  Descontado correctamenta',
                            'success'
                            )
                    }
                           //  window.open('http://127.0.0.1:8000/ventas/pdfVenta/'+response.data.id+','+'_blank');
                           //          me.listado= 1;
                           //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                           //    me.listaVenta(1,'','num_comprobante_pago');
                        }) 
                        .catch(function (error) {
                            console.log(error);
                        });

                },

                AjusteInventarioEntra(){
                    console.log('entra en la función');
                    //  if(this.motivo){return ;}

                        let me=this;
                        axios.post('/inventario/ajusteInventarioEntra', {
                            'motivo': this.motivo,
                            'impuesto': this.impuesto,
                            'total':this.total,
                            'data':this.ArrayDetalleAjusteProductos,
                        })
                        .then(function (response) {


                         var respuesta=response.data;
                        if(respuesta.status=='ok'){
                            me.vaciarVariables();

                            Swal.fire(
                            'Exitoso (+)?',
                            'Ajuste de inventario  Ingresado correctamenta',
                            'success'
                            )
                    }
                           //  window.open('http://127.0.0.1:8000/ventas/pdfVenta/'+response.data.id+','+'_blank');
                           //          me.listado= 1;
                           //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                           //    me.listaVenta(1,'','num_comprobante_pago');
                        }) 
                        .catch(function (error) {
                            console.log(error);
                        });

                  },

        },
        mounted() 
        {
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
  .text-negrilla{
    color: black !important;
    font-weight: bold;
  
  }
</style>
