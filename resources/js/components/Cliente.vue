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
                        <i class="fa fa-align-justify"></i> Cliente
                        <button type="button"  @click="abrirModal('persona','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="num_documento">Num documento</option>
                                      <option value="telefono">Telefono</option>
                                      <option value="email">Email</option>

                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio)"  class="form-control" placeholder="Buscar...">
                                    <button type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>

                         <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Tip doc</th>
                                    <th>Numero</th>
                                    <th>Dirección</th>
                                    <th>Telefono</th>
                                    <th>Email</th>
                                    <th>Opciones</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="persona in arrayPersona" :key="persona.id">
                                        <td v-text="persona.id"></td>
                                        <td v-text="persona.nombre"></td>
                                        <td v-text="persona.tipo_documento"></td>
                                        <td v-text="persona.num_documento"></td>
                                        <td v-text="persona.direccion"></td>
                                        <td v-text="persona.telefono"></td>
                                        <td v-text="persona.email"></td>
                                        

                                    <td>
                                        <button type="button" @click="abrirModal('persona', 'actualizar',persona)" class="btn btn-outline-warning btn-sm" data-toggle="modal">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="persona.latitud!=null">
                                        <button  type="button" @click="openMap(persona)" class="btn btn-outline-danger btn-sm" data-toggle="modal">
                                          <i class="icon-map"></i>
                                        </button> &nbsp;
                                        </template>
                                        <template v-else>
                                        <button  type="button"  class="btn btn-outline-success btn-sm" data-toggle="modal">
                                          <i class="icon-map"></i>
                                        </button> &nbsp;
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
                <div class="modal-dialo modal-primary modal-lg"  role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-bod">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                       <label class="col-md-3 form-control-label text-negrita" for="text-input">Nombre</label>
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre...">
                                    </div>
                                
                                    <div class="col-md-6">                                       
                                        <label class="col-md-3 form-control-label text-negrita" for="text-input">Tipo documento</label>
                                        <select v-model="tipo_documento" class="form-control">
                                            <option value="CC">Cedula</option>
                                            <option value="TI">Tarjeta de identida</option>
                                            <option value="PA">Pasaporte</option>
                                        </select>
                                    </div>
                                </div>


                                 <div class="form-group row">
                                    <div class="col-md-4">
                                        <label class="col-md-3 form-control-label text-negrita" for="text-input">documento</label>
                                        <input type="number" v-model="num_documento" class="form-control" placeholder="Numero de documento">
                                    </div>

                                    <div class="col-md-4">   
                                       <label class="col-md-3 form-control-label text-negrita" for="text-input">Direccion</label>
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Dirección...">
                                    </div>


                                    <div class="col-md-4">   
                                       <label class="col-md-3 form-control-label text-negrita" for="text-input">Nacimiento</label>
                                        <input type="date" v-model="nacimiento" class="form-control" placeholder="Dirección...">
                                    </div>

                                </div>


                                 <div class="form-group row">
                                    <div class="col-md-6">  
                                       <label class="col-md-3 form-control-label text-negrita" for="text-input">Telefono</label>
                                        <input type="text" v-model="telefono" class="form-control" placeholder="Telefono...">
                                    </div>
                                
                                    <div class="col-md-6"> 
                                      <label class="col-md-3 form-control-label text-negrita" for="text-input">Email</label>
                                        <input type="text" v-model="email" class="form-control" placeholder="Email...">
                                    </div>
                                </div>




                                             <div class="form-group row">
                                                <div class="col-md-12">

                                                      <GmapMap
                                                        :center="center"
                                                        :zoom="16"
                                                        map-style-id="roadmap"
                                                        :options="mapOptions"
                                                        style="width: 170vmin; height: 50vmin"
                                                        ref="mapRef"
                                                        @click="handleMapClick"
                                                    >
                                                        <GmapMarker
                                                        :position="marker.position"
                                                        :clickable="true"
                                                        :draggable="true"
                                                        @drag="handleMarkerDrag"
                                                        @click="panToMarker"
                                                        />
                                                    </GmapMap>
                                                    <!-- <button class="btn btn-outline-danger btn-sm" @click="geolocate">Buscar mi ubicacion</button> -->

                                                    <!-- <p>Selected Position: {{ marker.position }}</p> -->
                                                </div>   
                                             </div>



                                <div v-show="errorPersona==1" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMensajePersonaArray" :key="error" v-text="error">
                                           
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccionButton==1" class="btn btn-outline-primary" @click="registrarCliente()">Guardar</button>
                            <button type="button" v-if="tipoAccionButton==2" class="btn btn-outline-primary" @click="actualizarArticulo()">Actualizar</button>

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



        marker: { position: { lat: 10, lng: 10 } },
        center: { lat: 10, lng: 10 },

        mapOptions: {
        disableDefaultUI: true,
        },
            //cual es la categoria que quiero edit 
            persona_id :0,
            nombre : '',
            tipo_documento: 'CC',
            num_documento: '',
            direccion: '',
            telefono:'',
            email: '',
            nacimiento:'',
            //la data que regresa nuestro metodo listarCategoria se almacene en esta array
            arrayPersona:[],
            modal : 0,
            //para saber que modal quiero mostrar, register o actualizar
            tituloModal : '',
            tipoAccionButton : 0,
            errorPersona : 0,
            errorMensajePersonaArray : [],
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
            }

        },



     //aqui estaran los metodos. axios que me ayudaran hacer peticiones http e forma sencilla y convertir la respuesta en json
        methods: {


                            //detects location from browser
                    geolocate() {
                    navigator.geolocation.getCurrentPosition((position) => {
                        this.marker.position = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                        };

                        this.panToMarker();
                    });
                    },

                    //sets the position of marker when dragged
                    handleMarkerDrag(e) {
                    this.marker.position = { lat: e.latLng.lat(), lng: e.latLng.lng() };
                    },

                    //Moves the map view port to marker
                    panToMarker() {
                    this.$refs.mapRef.panTo(this.marker.position);
                    this.$refs.mapRef.setZoom(18);
                    },

                    //Moves the marker to click position on the map
                    handleMapClick(e) {
                    this.marker.position = { lat: e.latLng.lat(), lng: e.latLng.lng() };
                    console.log(e);
                    },




              
          listarPersona(page, buscar, criterio){
              
                 let me=this;
                  var url= '/cliente/index?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    //todo lo que retorne esta funcion se almacene en este array
                    me.arrayPersona = respuesta.persona.data;
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
                me.listarPersona(page, buscar, criterio);
            },


          //Metodo registrar categoria
          registrarCliente(){

                  if(this.validarArticulo()){
                      return ;
                  }
                  let me=this;
                  axios.post('/cliente/registrar', {
                    'nombre':  this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento': this.num_documento,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'email':this.email,
                    'latitud': this.marker.position.lat,  
                    'longitud': this.marker.position.lng,  
                    'fechaNacimiento': this.nacimiento, 

                })
                .then(function (response) {
                    me.cerrarModal();
                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listarPersona(1,'','nombre');

                           Swal.fire(
                            'Cliente agregado correctamente',
                            'TENDERPOS',
                            'success'
                            )
                }) 
                .catch(function (error) {
                    console.log(error);
                });

              },


             //Metodo actualizar categoria
           actualizarArticulo(){

                  if(this.validarArticulo()){
                      return ;
                  }
                  let me=this;
                  axios.put('/cliente/actualizar', {
                    'nombre':  this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento': this.num_documento,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'email': this.email,
                    'fechaNacimiento': this.nacimiento,
                    'id' :this.persona_id    
                        
                })
                .then(function (response) {
                    me.cerrarModal();
                    //le mandamos 3 parametro 1: la primera pagina, '':buscar vacio, nombre: criterio
                    me.listarPersona(1,'','nombre');


                    Swal.fire(
                            'Cliente editado correctamente',
                            'TENDERPOS',
                            'success'
                            )

                })
                .catch(function (error) {
                    console.log(error);
                });

              },

            //methods validar las categoria
            validarArticulo(){
                this.errorPersona=0;
                 this.errorMensajePersonaArray=[];

                 if(!this.nombre) this.errorMensajePersonaArray.push("El nombre de la categoria no puede estar vacio");
                 if(!this.tipo_documento) this.errorMensajePersonaArray.push("El documento es obligatorio");
                 if(!this.num_documento) this.errorMensajePersonaArray.push("El numero de documento es obligatorio");
                 if(!this.direccion) this.errorMensajePersonaArray.push("La dirección  es obligatorio");
                 if(!this.telefono) this.errorMensajePersonaArray.push("El telefono  es obligatorio");
                 if(!this.email) this.errorMensajePersonaArray.push("El email  es obligatorio");

                 if(this.errorMensajePersonaArray.length) this.errorPersona=1;
                 return this.errorPersona;
              },


           //metodo para cerrar el modal
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.tipo_documento='CC';
                this.num_documento='';
                this.direccion='';
                this.telefono='';
                this.email='';

                this.errorMensajePersonaArray = [];
                this.errorPersona = 0;

              },

              openMap(data)
              {
                 window.open('https://www.google.com/maps/search/?api=1&query='+data.latitud+','+data.longitud);
              },


              //recibe tres paramatro el nombre del modelo "categoria",  accion "registrar o actualizar", el objeto "" 
            abrirModal(modelo, accion, data=[]){
                  switch(modelo){
                      case "persona":
                     {
                         switch(accion){
                            
                             case 'registrar':
                            {
                                this.modal=1;
                                this.tituloModal='Registrar Cliente';
                                this.nombre='';
                                this.descripcion='';
                                this.tipoAccionButton=1;
                              break;
                             } 
                             case 'actualizar':
                            {
                               // console.log(data);
                               this.modal=1;
                               this.tituloModal='Editar Cliente';
                               this.tipoAccionButton=2;
                               this.persona_id=data['id'];
                               this.nombre=data['nombre'];
                               this.tipo_documento=data['tipo_documento'];
                               this.num_documento=data['num_documento'];
                               this.direccion=data['direccion'];
                               this.telefono=data['telefono'];
                               this.email=data['email'];
                               this.nacimiento=data['fechaNacimiento'];

                             break;
                             }   
                                 
                         } 
                      }
                  }

              }
        },
        mounted() {
       //hacemos referencia a nuestro metodo  listarCategoria
      this.listarPersona(1,this.buscar,this.criterio); 
      this.geolocate();
    
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


</style>


