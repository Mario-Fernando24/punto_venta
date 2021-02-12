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
                            <button type="button"  class="btn btn-primary" @click="registrarVenta()">Guardar</button>

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
            }

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
