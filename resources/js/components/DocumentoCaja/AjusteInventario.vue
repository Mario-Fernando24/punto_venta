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
                        <button type="button"   class="btn btn-outline-danger">
                            <i class="icon-minus"></i>&nbsp;Sale
                        </button>


                        <button  type="button"  class="btn btn-outline-success" >
                            <i class="icon-plus"></i>&nbsp;Entra 
                        </button>
                        
                    </div>


                    <div class="card-body">
                      
                        
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
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


            

           
          }
        },



        computed :{
           
        },



        methods: {
              









        },
        mounted() {
       //hacemos referencia a nuestro metodo  listarCategoria
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
