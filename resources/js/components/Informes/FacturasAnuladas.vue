 <template>

<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Escritorio</a></li>
            </ol>
            <div class="container-fluid">

                


                <div class="card" v-if="condicion==1">
                   <div class="card-header">
                        <i class="fa fa-align-justify"></i> Ventas anuladas
                        <button type="button" @click="Open('facturas','ventas')"  class="btn btn-outline-danger">
                            <i class="icon-minus"></i>&nbsp;Ventas anuladas
                        </button>


                        <button  type="button" @click="Open('facturas','compras')" class="btn btn-outline-warning" >
                            <i class="icon-minus"></i>&nbsp;Compras anuladas 
                        </button>
                        
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="tipo_comprobante">Tipo comprobante</option>
                                      <option value="forma_pago">Forma de pago</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="VentasAnuladas(1,buscar,criterio)"  class="form-control" placeholder="Buscar...">
                                    <button type="submit" @click="VentasAnuladas(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
                                    <th>Total</th>
                                    <th>Anulo</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="ventaAnuladas in arrayVentaAnuladas" :key="ventaAnuladas.id">
                                    
                                        <td v-text="ventaAnuladas.id"></td>
                                        <td v-text="ventaAnuladas.usuario_hizola_venta.usuario"></td>
                                        <td v-text="ventaAnuladas.cliente_persona.nombre"></td>
                                        <td v-text="ventaAnuladas.tipo_comprobante"></td>
                                        <td v-text="ventaAnuladas.forma_pago"></td>
                                        <td v-text="ventaAnuladas.total"></td>
                                        <td v-text="ventaAnuladas.usuario_anulo_venta.usuario"></td>

                                        <td>
                                        <div>
                                        <span class="badge badge-danger" v-text="ventaAnuladas.estado"></span>
                                        </div>
                                        </td>
                                    <td v-text="ventaAnuladas.created_at"></td>

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



                <div class="card" v-else>
                     <div class="card-header">
                        <i class="fa fa-align-justify"></i> Compras anuladas
                        <button type="button" @click="Open('facturas','ventas')"  class="btn btn-outline-success">
                            <i class="icon-minus"></i>&nbsp;Ventas anuladas
                        </button>


                        <button  type="button" @click="Open('facturas','compras')" class="btn btn-outline-info" >
                            <i class="icon-minus"></i>&nbsp;Compras anuladas 
                        </button>
                        
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="tipo_comprobante">Tipo comprobante</option>
                                      <option value="forma_pago">Forma de pago</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="VentasAnuladas(1,buscar,criterio)"  class="form-control" placeholder="Buscar...">
                                    <button type="submit" @click="VentasAnuladas(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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

                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="ingreso in arrayComprasAnuladas" :key="ingreso.id">
                                    
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
                                        <div>
                                        <span class="badge badge-danger" v-text="ingreso.estado"></span>
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
       
     
        </main>
     
</template>

<script>
    export default {
        data(){
          return {
            modal : 0,
            tituloModal : '',
            tipoAccionButton : 0,

            condicion:1,

            arrayVentaAnuladas:[],
            arrayComprasAnuladas:[],
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
            criterio : 'tipo_comprobante',
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
              
           VentasAnuladas(page, buscar, criterio){
                 let me=this;
                  var url= '/anuladas/VentasAnuladas?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    //todo lo que retorne esta funcion se almacene en este array
                    me.arrayVentaAnuladas = respuesta.ventaAnuladas.data;
                    me.pagination = respuesta.pagination;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                 },


                 ComprasAnuladas(page, buscar, criterio){
                 let me=this;
                  var url= '/anuladas/ComprasAnuladas?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    //todo lo que retorne esta funcion se almacene en este array
                    me.arrayComprasAnuladas = respuesta.ingresoAnulados.data;
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
                me.VentasAnuladas(page, buscar, criterio);
                me.ComprasAnuladas(page, buscar, criterio);
                
            },

             Open(modelo, accion){
                  switch(modelo){
                      case "facturas":
                     {
                         switch(accion){
                            
                             case 'ventas':
                            {
                                this.condicion=1;
                                console.log('ventas anuladas');
                              break;
                             } 
                             case 'compras':
                            {

                                this.condicion=2;
                                console.log('compras anuladas');

                             break;
                             }   
                                 
                         } 
                      }
                  }

              }


         },
        mounted() {
      this.VentasAnuladas(1,this.buscar,this.criterio);   
      this.ComprasAnuladas(1,this.buscar,this.criterio);
  
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
