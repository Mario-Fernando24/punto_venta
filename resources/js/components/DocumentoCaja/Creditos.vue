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
                                        <span class="badge badge-success">Pago</span>
                                        </div>
                                    </td>

                                    <td>
                                        <button type="button" @click="abrirModal('credito', 'abonar',credito)" class="btn btn-outline-danger btn-sm" data-toggle="modal">
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
            
     
        </main>
</template>

<script>
//axios nos ayuda hacer peticiones http desde el navegador
    export default {
        //dentro de la data colocamos las variables 
        data(){
          return {
            arraCredito:[],
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
                    me.listaCategoria(1,'','nombre');
                }) 
                .catch(function (error) {
                    console.log(error);
                });

              },



               abrirModal(modelo, accion, data=[]){
                  switch(modelo){
                      case "credito":
                     {
                         switch(accion){
                            
                             case 'abonar':
                            {
                                console.log('sss');
                              break;
                             } 
                             }   
                                 
                         } 
                      }
                  },


              


           

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
