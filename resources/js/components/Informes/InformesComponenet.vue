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
            <i class="fa fa-align-justify"></i> Informes
            <button type="button" @click="itemm('informe','1')"   class="btn btn-secondary">
                <i class="icon-chart"></i>&nbsp;Venta x cliente, producto
            </button>

            <button type="button" @click="itemm('informe','2')"   class="btn btn-info">
            <i class="icon-chart"></i>&nbsp;Venta x rango de fechas
            </button>



            <button type="button" @click="itemm('informe','3')"   class="btn btn-dark">
            <i class="icon-eye"></i>&nbsp;Venta x producto & fecha
            </button>


        </div>

        <div class="card-body">

       <template v-if="itempage==1">


       <div class="card-header">
          <h4><b>Ventas por producto, cliente</b></h4>
           <div class="card-header">
           
           <div class="form-group row">
             <div class="col-md-4">
                  <label class="col-md-12 form-control-label text-negrita" for="text-input">Seleccione producto</label>
                  <select class="form-control" v-model="id_producto" >
                  <option value="0">Seleccione producto</option>
                  <option v-for="informeee in  ListararrayArticulo" :key="informeee.id" :value="informeee.id" v-text="informeee.nombre"></option>
                  </select>
              </div>

              <div class="col-md-4">
                  <label class="col-md-12 form-control-label text-negrita" for="text-input">Seleccione cliente</label>
                  <select class="form-control" v-model="id_cliente" >
                  <option value="0">Seleccione cliente</option>
                  <option v-for="clientesssss in  ListararrayCliente" :key="clientesssss.id" :value="clientesssss.id" v-text="clientesssss.nombre+'        '+clientesssss.tipo_documento+'  '+clientesssss.num_documento"></option>
                  </select>
              </div>
              <div class="col-md-4">
            <!--  @click="list_cupones(1,buscar,criterio)" -->
            <label class="col-md-12 form-control-label text-negrita" for="text-input"></label>
               <br>
              <button type="submit" @click="ventaPorProducto(id_cliente,id_producto)"  class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
              </div>


            </div>

           
           </div>
          </div>



          <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>venta</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Descuento</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                
                    <tr v-for="prod in arrayDetalleProductoPorCliente" :key="prod.id">
                        
                            <td v-text="prod.id_venta"></td>
                            <td v-text="prod.articulo__detalle__venta.nombre"></td>
                            <td v-text="prod.cantidad"></td>
                            <td v-text="prod.descuento"></td>
                            <td v-text="prod.precio"></td>
                            
                    </tr>
                    </tbody>
            </table>
            </div>

            <div class="alert alert-primary" role="alert">
              Cantidad:  {{cantProd}}
            </div>

            <div class="alert alert-dark" role="alert">
               Total en compra:  {{Intl.NumberFormat().format(sumProd)}}
            </div>



        </template>

        <template v-if="itempage==2">

          <div class="card-header">
             <h4><b>Venta rango de fechas</b></h4>
              <div class="card-header">
                        <p><i class="fa fa-align-justify"></i> 
                        Desde  <input type="date" v-model="datee.start">       Hasta  <input type="date" v-model="datee.endd">
                        &nbsp;<button type="submit"   @click="ventaPorFechas(datee.start,datee.endd)"   class="btn btn-primary">
                        <i class="fa fa-search"></i> Buscar</button></p>
              </div>
          </div>



          <div class="alert alert-primary" role="alert">
           Total Ventas Anulada:  {{Intl.NumberFormat().format(informe.InformVentaAnulada)}}
          </div>

          <div class="alert alert-dark" role="alert">
            Total en venta: {{Intl.NumberFormat().format(informe.InformVentaActiva)}}
          </div>



          <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>venta</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Descuento</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                
                    <tr v-for="mar in arraydetallePorFecha" :key="mar.id">
                        
                            <td v-text="mar.id_venta"></td>
                            <td v-text="mar.articulo__detalle__venta.nombre"></td>
                            <td v-text="mar.cantidad"></td>
                            <td v-text="mar.descuento"></td>
                            <td v-text="mar.precio"></td>
                            
                    </tr>
                    </tbody>
            </table>
            </div>






        </template>


        
        <template v-if="itempage==3">

        <div class="col-md-4">

        <label class="col-md-12 form-control-label text-negrita" for="text-input"><i class="fa fa-align-justify"></i>&nbsp;Seleccione producto</label>
        <select class="form-control" v-model="id_productothree" >
        <option value="0">Seleccione producto</option>
        <option v-for="informeee in  ListararrayArticulo" :key="informeee.id" :value="informeee.id" v-text="informeee.nombre"></option>
        </select>
    </div>
    

    
        <div class="card-header">
        <h4><b>Venta rango de fechas</b></h4>
         <div class="card-header">
                   <p><i class="fa fa-align-justify"></i> 
                   Desde  <input type="date"  v-model="dateethree.start">       Hasta  <input type="date" v-model="dateethree.endd" >
                   &nbsp;<button type="submit" @click="consultarVentaProductDate(dateethree.start,dateethree.endd,id_productothree)"      class="btn btn-primary">
                   <i class="fa fa-search"></i> Buscar</button></p>
         </div>
       </div>
        </template>

   
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
             
            arrayVentaProducto:[],
            arrayDetalleProductoPorCliente:[],
            cantProd:0,
            sumProd:0,
            idProducto:0,

            InformVentaActivaa:'',
            InformVentaAnuladaa:'',
            arrayVentaa:[],
            ListararrayArticulo:[],
            ListararrayCliente:[],
            id_producto:0, 
            id_cliente:0,
            itempage:1,

            datee:{
              start:'',
              endd:''
           },
           informe:{
            InformVentaActiva:0,
            InformVentaAnulada:0,
           },
           arrayVentaFecha:[],
           arraydetallePorFecha:[],


           // paginate 3
           dateethree:{
            start:'',
            endd:''
            },
            id_productothree:0,
            arrayproductoThree:[],

            
           

                
          }
        },


        computed :{
           

        },

        methods: {

         ventaPorFechas(star, endl){

          if(star=='' || endl==''){
            Swal.fire(
                'Advertencia!',
                'Las fechas no pueden estar vacias!',
                'warning'
            )
            return ;
          }
            let me=this;

            me.arraydetallePorFecha=[];
            me.informe.InformVentaActiva=0;
             var url= '/informe/ventaPorFecha?star=' + star + '&endl=' + endl;
               axios.get(url).then(function (response) {
                 var respuesta = response.data;
                 console.log('====================================');
                 console.log(respuesta);
                 console.log('====================================');

                 me.informe.InformVentaAnulada=respuesta.InformVentaAnulada;
                 me.arrayVentaFecha = respuesta.arrayVenta;

                 me.arrayVentaFecha.map(function(x){
                  x.detalle_venta.map(function(y){
                        me.arraydetallePorFecha.push(y);
                        me.informe.InformVentaActiva+=((y.precio-y.descuento)*y.cantidad);
                     
                  });
                });


                 
                 

               })
               .catch(function (error) {
                   console.log(error);
               });
         },

         ventaPorProducto(idcliente,idproducto){

          if(idcliente==0){
            Swal.fire(
                'Advertencia!',
                'Campos cliente  esta vacio!',
                'warning'
            )

            return ;
          }

            let me=this;
            me.arrayDetalleProductoPorCliente=[];
            me.cantProd=0;
            me.sumProd=0;
            me.idProducto=0;

             var url= '/informe/ventasPorProducto?idcliente=' + idcliente + '&idproducto=' + idproducto;
             axios.get(url).then(function (response) {

               var respuesta = response.data;
               me.arrayVentaProducto = respuesta.ventadetalle.data;
               me.idProducto=respuesta.idProducto;

               if(me.idProducto==0){
                me.arrayVentaProducto.map(function(x){
                  x.detalle_venta.map(function(y){
                        me.arrayDetalleProductoPorCliente.push(y);
                        me.cantProd+=y.cantidad;
                        me.sumProd+=((y.precio-y.descuento)*y.cantidad);
                     
                  });
                });
                
               }else{

                me.arrayVentaProducto.map(function(x){
                  x.detalle_venta.map(function(y){
                     if(y.id_articulo==me.idProducto){
                        me.arrayDetalleProductoPorCliente.push(y);
                        me.cantProd+=y.cantidad;
                        me.sumProd+=((y.precio-y.descuento)*y.cantidad);
                     }
                  });
                });

               }

               })
               .catch(function (error) {
                   console.log(error);
               });
            },


            itemm(modelo, accion){
             
                    switch(accion){
                
                        case '1':
                        {
                          this.itempage=1;
                         break;
                        } 
                        case '2':
                        {
                        this.itempage=2;
                        break;
                        }  
                        case '3':
                          this.itempage=3;
                        break;
                       
                            
                    } 
            },


            listarArticulo(){
              let me=this;
               var url= '/informe/ListarArticuloVenta';
               axios.get(url).then(function (response) {
                 var respuesta = response.data;
                 console.log(respuesta);
                 //todo lo que retorne esta funcion se almacene en este array
                 me.ListararrayArticulo = respuesta.articulos;
                 me.ListararrayCliente  = respuesta.clietes;
                 })
                 .catch(function (error) {
                     console.log(error);
                 });

              },


              vaciarVariable(){
                arrayVentaProducto=[];
                arrayDetalleProductoPorCliente=[];
                cantProd=0;
                sumProd=0;
                idProducto=0;
    
                InformVentaActivaa='';
                InformVentaAnuladaa='';
                arrayVentaa=[];
                id_producto=0; 
                id_cliente=0;
              },


              //tercera paginate
              consultarVentaProductDate(fromm, to, idProduct){
                let me=this;
                
                var url= '/informe/venta_product_date?fromm=' + me.dateethree.start + '&tooomar=' + me.dateethree.endd+ '&idProduct=' + idProduct;

                axios.get(url).then(function (response) {
                  var respuesta = response.data;
                  console.log(respuesta);

                  })
                  .catch(function (error) {
                      console.log(error);
                  });                return ;
              }


         },
        mounted() {
                this.listarArticulo();
                
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
