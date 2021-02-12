<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                
            </div>
            <div class="car-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4>Compras por meses</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="ingresos">                                                
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Compras de los últimos meses.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4>Ventas por meses</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="ventas">                                                
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Ventas de los últimos meses.</p>
                            </div>
                        </div>
                    </div>
                </div>



                 <div class="row">
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4>Los 5 productos más vendidos</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="productosMasVendido">                                                
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Los 5 productos más vendidos</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4>Los 5 productos más vendidos por unid</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="productoTotal">                                                
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Los 5 productos más vendidos por unid.</p>
                            </div>
                        </div>
                    </div>
                </div>
                

            </div>
        </div>
    </div>

</main>
</template>
<script>
    export default {
        data (){
            return {
                varIngreso:null,
                charIngreso:null,
                ingresos:[],
                varTotalIngreso:[],
                varMesIngreso:[], 
                
                varVenta:null,
                charVenta:null,
                ventas:[],
                varTotalVenta:[],
                varMesVenta:[],


                varproductosMasVendidoss:null,
                charproductosMasVendidos:null,
                varproductosMasVendidos:[],
                TotalproductosMasVendidos:[],
                productosMasVendidos:[],

                varproductos:null,
                charproductos:null,
                productos:[],
                totalproductos:[],
                nombreproductos:[],
             
                
            }
        },
        methods : {
            getIngresos(){
                let me=this;
                var url= '/dashboard';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.ingresos = respuesta.ingresos;
                    //cargamos los datos del chart
                    me.loadIngresos();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getVentas(){
                let me=this;
                var url= '/dashboard';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.ventas = respuesta.ventas;
                    //cargamos los datos del chart
                    me.loadVentas();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getProductosMasVendidos(){
                let me=this;
                var url= '/dashboard';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.productosMasVendidos = respuesta.TotalProductosVendidos;
                    //cargamos los datos del chart
                    me.loadProductoMasVendidos();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            getProductos(){
                let me=this;
                var url= '/dashboard';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.productos = respuesta.totallPorProductos;
                    //cargamos los datos del chart
                    me.loadProducto();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadIngresos(){
                let me=this;
                let mesIngreso='';
                me.ingresos.map(function(x){


                    switch(x.mes){
                        case 1:
                        mesIngreso='Enero '+x.anio;
                        break;
                        case 2:
                        mesIngreso='Febrero '+x.anio;
                        break;
                        case 3:
                        mesIngreso='Marzo '+x.anio;
                        break;
                        case 4:
                        mesIngreso='Abril '+x.anio;
                        break;
                        case 5:
                        mesIngreso='Mayo '+x.anio;
                        break;
                        case 6:
                        mesIngreso='Junior '+x.anio;
                        break;
                        case 7:
                        mesIngreso='Julio '+x.anio;
                        break;
                        case 8:
                        mesIngreso='Agosto '+x.anio;
                        break;
                        case 9:
                        mesIngreso='Septiembre '+x.anio;
                        break;
                        case 10:
                        mesIngreso='Octubre '+x.anio;
                        break;
                        case 11:
                        mesIngreso='Noviembre '+x.anio;
                        break;
                        case 12:
                        mesIngreso='Diciembre ';
                        break;
                    }
                    
                    me.varMesIngreso.push(mesIngreso);
                    me.varTotalIngreso.push(x.total);
                });
                me.varIngreso=document.getElementById('ingresos').getContext('2d');

                me.charIngreso = new Chart(me.varIngreso, {
                    type: 'bar',
                    data: {
                        labels: me.varMesIngreso,
                        datasets: [{
                            label: 'Ingresos',
                            data: me.varTotalIngreso,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            },
            loadVentas(){
                let me=this;
                let mes_venta='';
                me.ventas.map(function(x){

                    switch(x.mes){
                        case 1:
                        mes_venta='Enero'+x.anio;
                        break;
                        case 2:
                        mes_venta='Febrero '+x.anio;
                        break;
                        case 3:
                        mes_venta='Marzo '+x.anio;
                        break;
                        case 4:
                        mes_venta='Abril '+x.anio;
                        break;
                        case 5:
                        mes_venta='Mayo '+x.anio;
                        break;
                        case 6:
                        mes_venta='Junior '+x.anio;
                        break;
                        case 7:
                        mes_venta='Julio '+x.anio;
                        break;
                        case 8:
                        mes_venta='Agosto '+x.anio;
                        break;
                        case 9:
                        mes_venta='Septiembre '+x.anio;
                        break;
                        case 10:
                        mes_venta='Octubre '+x.anio;
                        break;
                        case 11:
                        mes_venta='Noviembre '+x.anio;
                        break;
                        case 12:
                        mes_venta='Diciembre '+x.anio;
                        break;
                    }
                    me.varMesVenta.push(mes_venta);
                    me.varTotalVenta.push(x.total);
                });
                me.varVenta=document.getElementById('ventas').getContext('2d');

                me.charVenta = new Chart(me.varVenta, {
                    type: 'bar',
                    data: {
                        labels: me.varMesVenta,
                        datasets: [{
                            label: 'Ventas',
                            data: me.varTotalVenta,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            },

            loadProductoMasVendidos(){
                let me=this;
                let mes_venta='';
                me.productosMasVendidos.map(function(x){
                    console.log(x.nombre);

                    me.varproductosMasVendidos.push(x.nombre);
                    me.TotalproductosMasVendidos.push(x.Dinero);
                });
                me.varproductosMasVendidoss=document.getElementById('productosMasVendido').getContext('2d');

                me.charproductosMasVendidos = new Chart(me.varproductosMasVendidoss, {
                    type: 'bar',
                    data: {
                        labels: me.varproductosMasVendidos,
                        datasets: [{
                            label: 'Productos mas vendidos',
                            data: me.TotalproductosMasVendidos,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],

                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            },

            loadProducto(){

                  let me=this;
                let mes_venta='';
                me.productos.map(function(x){
                    console.log(x.total);

                    me.nombreproductos.push(x.nombre);
                    me.totalproductos.push(x.total);
                });
                me.varproductos=document.getElementById('productoTotal').getContext('2d');

                me.charproductos = new Chart(me.varproductos, {
                    type: 'bar',
                    data: {
                        labels: me.nombreproductos,
                        datasets: [{
                            label: 'Productos mas vendidos',
                            data: me.totalproductos,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],

                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });

            }
        },
        mounted() {
            this.getIngresos();
            this.getVentas();
            this.getProductosMasVendidos();
            this.getProductos();
        }
    }
</script>
