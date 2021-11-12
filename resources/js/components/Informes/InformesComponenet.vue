<template>

   <h1>Mario Fernando Muñoz Rivera</h1>

</template>



<script>
    export default {
        data(){
          return {
             
            arrayVentaProducto:[],
            arrayDetalleProductoPorCliente:[],
            cantProd:0,
            idProducto:0,

            InformVentaActivaa:'',
            InformVentaAnuladaa:'',
            arrayVentaa:[],
                
          }
        },


        computed :{
           

        },

        methods: {

         ventaPorClienteFechas(){
            let me=this;
             var url= '/informe/ventaPorCliente';
               axios.get(url).then(function (response) {
                 var respuesta = response.data;

                 me.arrayVentaa = respuesta.arrayVenta.data;

               })
               .catch(function (error) {
                   console.log(error);
               });
         },

         ventaPorProducto(){
            let me=this;
             var url= '/informe/ventasPorProducto';
             axios.get(url).then(function (response) {
               var respuesta = response.data;
               me.arrayVentaProducto = respuesta.ventadetalle.data;
               me.idProducto=respuesta.idProducto;
               me.arrayVentaProducto.map(function(x){
                  x.detalle_venta.map(function(y){
                     if(y.id_articulo==me.idProducto){
                        me.arrayDetalleProductoPorCliente.push(y);
                        me.cantProd+=y.cantidad;
                     }
                  });
                });
               })
               .catch(function (error) {
                   console.log(error);
               });
            },
         },
        mounted() {
                this.ventaPorProducto();
                
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
