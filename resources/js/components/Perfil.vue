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
                        <i class="fas fa-edit"></i> <a class="text-negrilla">Perfil de la empresa</a>
                      
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="row">

                                    <div class="col-sm-6"> 
                                    <img style="height: 160px; width: 260px" :src="'/img/company/' + companyobjeto.image_perfil" class="rounded-circle"/>
                                <button type="button"  @click="abrirModal('company','updateImage')" class="btn btn-outline-info btn-sm">
                                     <i class="icon-picture "></i>&nbsp;Editar
                                       </button>

                                    </div>
                                    

                                    <div class="col-sm-6"><h3><i class="icon-user text-negrilla">Razón social: <p v-text="companyobjeto.razon_social"></p></i></h3></div>
                                     </div>

                                    <div class="row">
                                        <div class="col-sm-3"><i class="icon-phone text-negrilla">Telefono: <p v-text="companyobjeto.telefono"></p></i></div>
                                        <div class="col-sm-3"><i class="icon-map text-negrilla" >Dirección:<p v-text="companyobjeto.direccion"></p></i></div>
                                        <div class="col-sm-3"><i class="icon-info text-negrilla">Impuestos: <p v-text="companyobjeto.impuesto"></p></i></div>
                                        <div class="col-sm-3"><i class="icon-info text-negrilla">Nit<p v-text="companyobjeto.nit"></p></i></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3"><i class="icon-info text-negrilla">Correo: <p v-text="companyobjeto.correo"></p></i></div>
                                        <div class="col-sm-3"><i class="icon-map text-negrilla">Codigo postal: <p v-text="companyobjeto.codigo_postal"></p></i></div>
                                        <div class="col-sm-3"><i class="icon-user text-negrilla">Propietario: <p v-text="companyobjeto.propietario"></p></i></div>
                                        <div class="col-sm-3"><i class="icon-info text-negrilla">Ciudad: <p v-text="companyobjeto.ciudad"></p></i></div>
                                    </div>



                            <!--    <div v-show="errorCompany==1" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMensajeCompanyArray" :key="error" v-text="error">
                                           
                                        </div>
                                    </div>
                                </div>
                                -->
                            </form>
                        

                                     <button type="button"  @click="abrirModal('company','actualizar')" class="btn btn-outline-success btn-sm">
                                     <i class="icon-pencil"></i>&nbsp;Actualizar
                                       </button>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>

            


            <!--Inicio del modal agregar/actualizar-->
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
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">



                                <div class="form-group row">
                                    <div class="col-sm-12">
                                    <label class="col-md-12 form-control-label" for="email-input">Razón social</label>
                                        <input type="email" v-model="company_razonsocial" class="form-control" placeholder="Razón social...">
                                    </div>

                                </div>

                                
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                    <label class="col-md-6 form-control-label" for="email-input">Telefono</label>
                                        <input type="email" v-model="company_telefono" class="form-control" placeholder="Telefono...">
                                    </div>

                                    <div class="col-sm-6">
                                     <label class="col-md-6 form-control-label" for="email-input">Direccion</label>
                                        <input type="email" v-model="company_direccion" class="form-control" placeholder="Dirección...">
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <div class="col-sm-6">
                                    <label class="col-md-6 form-control-label" for="email-input">Impuesto</label>
                                        <input type="email" v-model="company_impuesto" class="form-control" placeholder="Impuesto...">
                                    </div>

                                    <div class="col-sm-6">
                                     <label class="col-md-6 form-control-label" for="email-input">Nit</label>
                                        <input type="email" v-model="company_nit" class="form-control" placeholder="Nit...">
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <div class="col-sm-6">
                                    <label class="col-md-6 form-control-label" for="email-input">Correo</label>
                                        <input type="email" v-model="company_correo" class="form-control" placeholder="Descripción...">
                                    </div>

                                    <div class="col-sm-6">
                                     <label class="col-md-6 form-control-label" for="email-input">Cod postal</label>
                                        <input type="email" v-model="company_codpostal" class="form-control" placeholder="Codigo postal...">
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <div class="col-sm-6">
                                    <label class="col-md-6 form-control-label" for="email-input">Propietario</label>
                                        <input type="email" v-model="company_propietario" class="form-control" placeholder="Propietario de la empresa...">
                                    </div>

                                    <div class="col-sm-6">
                                     <label class="col-md-6 form-control-label" for="email-input">Ciudad</label>
                                        <input type="email" v-model="company_ciudad" class="form-control" placeholder="Ciudad...">
                                    </div>
                                </div>

                                <div v-show="errorCompany==1" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMensajeCompanyArray" :key="error" v-text="error">
                                           
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccionButton==2" class="btn btn-outline-primary" @click="updateProfileCompany()">Actualizar</button>

                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>





            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar':modalImage}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <form @submit="updateImageCompany" enctype="multipart/form-data">
                    
                            <strong>Image:</strong>
                            <input type="file" class="form-control" v-on:change="onImagePerfil">

                            <input type="hidden" v-model="id_perfil" >
    
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button class="btn btn-outline-info" >Actualizar</button>
                            </div>
                        </form>
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
            //la data que regresa nuestro metodo listarCategoria se almacene en esta array
            companyobjeto:'',
            modal : 0,
            //para saber que modal quiero mostrar, register o actualizar
            tituloModal : '',
            tipoAccionButton : 0,
            errorCompany : 0,
            errorMensajeCompanyArray : [],


            imagencompany:'',
            modalImage:0,
            id_perfil:0,

            company_razonsocial:'',
            company_telefono:'',
            company_direccion:'',
            company_impuesto:'',
            company_nit:'',
            company_correo:'',
            company_codpostal:'',
            company_propietario:'',
            company_ciudad:'',
            

           
          }
        },



        computed :{
           
        },



        methods: {
              
          objetoCompany(){
              
                 let me=this;
                  var url= '/company/index';
                  axios.get(url).then(function (response) {
                    var respuesta = response.data;
                     me.companyobjeto=response.data.Perfil;

                    me.id_perfil=me.companyobjeto.id;

                    me.company_razonsocial=me.companyobjeto.razon_social;
                    me.company_telefono=me.companyobjeto.telefono;
                    me.company_direccion=me.companyobjeto.direccion;
                    me.company_impuesto=me.companyobjeto.impuesto;
                    me.company_nit=me.companyobjeto.nit;
                    me.company_correo=me.companyobjeto.correo;
                    me.company_codpostal=me.companyobjeto.codigo_postal;
                    me.company_propietario=me.companyobjeto.propietario;
                    me.company_ciudad=me.companyobjeto.ciudad;
                    })


                    .catch(function (error) {
                        console.log(error);
                    });

              },
          

            validateCompany(){
                this.errorCompany=0;
                 this.errorMensajeCompanyArray=[];

                 if(!this.company_razonsocial) this.errorMensajeCompanyArray.push("Razon social no puede estar vacio");
                 if(!this.company_telefono) this.errorMensajeCompanyArray.push(" Telefono no puede estar vacio");
                 if(!this.company_direccion) this.errorMensajeCompanyArray.push("Dirección no puede estar vacio");
                 if(!this.company_impuesto) this.errorMensajeCompanyArray.push("Impuesto no puede estar vacio");
                 if(!this.company_nit) this.errorMensajeCompanyArray.push("Nit no puede estar vacio");
                 if(!this.company_correo) this.errorMensajeCompanyArray.push("Correo no puede estar vacio");
                 if(!this.company_codpostal) this.errorMensajeCompanyArray.push("El codigo Postal no puede estar vacio");
                 if(!this.company_propietario) this.errorMensajeCompanyArray.push("Propietario no puede estar vacio");
                 if(!this.company_ciudad) this.errorMensajeCompanyArray.push("Ciudad no puede estar vacio");

                 if(this.errorMensajeCompanyArray.length) this.errorCompany=1;
                 return this.errorCompany;
              },



            cerrarModal(){
                this.modal=0;
                this.modalImage=0;
                this.tituloModal='';
                this.tituloModal='';
                this.descripcion='';
                this.errorMensajeCompanyArray = [];
                this.errorCompany = 0;

              },

              updateProfileCompany()
              {
                  if(this.validateCompany()){
                      return ;
                  }
                   let me=this;
                  axios.post('/company/register', {
                    'id':  this.id_perfil,
                    'razon_social': this.company_razonsocial,
                    'telefono':  this.company_telefono,
                    'direccion':  this.company_direccion,
                    'impuesto':  this.company_impuesto,
                    'nit':  this.company_nit,
                    'correo':  this.company_correo,
                    'codigo_postal':  this.company_codpostal,
                    'propietario':  this.company_propietario,
                    'ciudad':  this.company_ciudad,
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.objetoCompany();

                     var respuesta=response.data;
                   if(response.data.status=='ok'){

                        Swal.fire(
                            'Exitoso?',
                            'La empresa guardada correctamente',
                            'success'
                            )
            }
                }) 
                .catch(function (error) {
                    console.log(error);
                });



              },


            abrirModal(modelo, accion, data=[]){
                  switch(modelo){
                      case "company":
                     {
                         switch(accion){
                            
                            
                             case 'actualizar':
                            {
                               // console.log(data);
                               this.modal=1;
                               this.tituloModal='Editar Empresa';
                               this.tipoAccionButton=2;
                               this.descripcion=data['descripcion'];
                             break;
                             }   

                               case 'updateImage':
                            {
                               // console.log(data);
                               this.modalImage=1;
                               this.tituloModal='Actulizar imagen de la Empresa';

                             break;
                             }   
                                 
                         } 
                      }
                  }

              },



                onImagePerfil(e){
            console.log(e.target.files[0]);

          this.imagencompany = e.target.files[0];
      },
      updateImageCompany(e) {

        let me=this;

          e.preventDefault();
          let currentObj = this;

          const config = {
              headers: { 'content-type': 'multipart/form-data' }
          }

          let formData = new FormData();
          formData.append('image', this.imagencompany);
          formData.append('id',this.id_perfil);

          axios.post('/company/updateImage', formData, config)
          .then(function (response) {

            var respuesta=response.data;
            if(response.data.status=='ok'){

              me.objetoCompany();
              me.cerrarModal();
              Swal.fire(
                'Exitoso?',
                'Imagen de la empresa guardada correctamente',
                'success'
                )
            }
              currentObj.success = response.data.success; 
          })
          .catch(function (error) {
              currentObj.output = error;
          });
      },






        },
        mounted() {
       //hacemos referencia a nuestro metodo  listarCategoria
      this.objetoCompany();     
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
