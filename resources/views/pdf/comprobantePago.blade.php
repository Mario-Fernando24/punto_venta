<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de venta</title>
    <style>
        body {
        /*position: relative;*/
        /*width: 16cm;  */
        /*height: 29.7cm; */
        /*margin: 0 auto; */
        /*color: #555555;*/
        /*background: #FFFFFF; */
        font-family: Arial, sans-serif; 
        font-size: 14px;
        /*font-family: SourceSansPro;*/
        }

        #logo{
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
        }

        #imagen{
        width: 100px;
        }

        #datos{
        float: left;
        margin-top: 0%;
        margin-left: 2%;
        margin-right: 2%;
        /*text-align: justify;*/
        }

        #encabezado{
        text-align: center;
        margin-left: 10%;
        margin-right: 35%;
        font-size: 15px;
        }

        #fact{
        /*position: relative;*/
        float: right;
        margin-top: 2%;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 20px;
        }

        section{
        clear: left;
        }

        #cliente{
        text-align: left;
        }

        #facliente{
        width: 40%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #fac, #fv, #fa{
        color: #FFFFFF;
        font-size: 15px;
        }

        #facliente thead{
        padding: 20px;
        background: #2183E3;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;  
        }

        #facvendedor{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #facvendedor thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }


        #pagooooooooooo{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #pagooooooooooo thead{
        padding: 20px;
        background: #21e381;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

        #facarticulo{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #facarticulo thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

        #gracias{
        text-align: center; 
        }
    </style>
    <body>
        <header>
            <div id="logo">
                <img src="img/logo2.png" alt="incanatoIT" id="imagen">
            </div>
            <div id="datos">
            <p id="encabezado">
                    <b> {{$Perfil->razon_social}}</b><br> {{$Perfil->propietario}}<br>Nit: {{$Perfil->nit}}
                    <br>Telefono:{{$Perfil->telefono}}<br>Email:{{$Perfil->correo}}<br>Ciudad: {{$Perfil->ciudad}}
                    <br>Dirección: {{$Perfil->direccion}}
                </p>
            </div>
            <div id="fact">
                <p>COMPRA<br>
                # {{ $showDeudaCompra->id }}</p>
            </div>
        </header>
        <br>
        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Proveedor</th>
                        </tr>
                    </thead>
                    <tbody>
                         
                    <tr>
                            <th><p id="cliente">Sr(a). {{ $proveedoress->nombre }} <br>
                            {{ $proveedoress->tipo_documento }}: {{ $proveedoress->num_documento }}<br>
                            Dirección: {{ $proveedoress->direccion }}<br>
                            Teléfono: {{ $proveedoress->telefono }}<br>
                            Email: {{ $proveedoress->email }}</p></th>
                    </tr>


                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <section>
            <div>
                <table id="facvendedor">
                    <thead>
                        <tr id="fv">
                            <th>FORMA DE PAGO</th>
                            <th>COMPROBANTE</th>
                            <th>FECHA</th>
                            

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $showDeudaCompra->forma_pago}}</td>
                            <td>{{ $showDeudaCompra->num_comprobante}} </td>
                            <td>{{ $showDeudaCompra->fecha_hora}} </td>

                        </tr>
                    </tbody>
                </table>
                
            </div>
        </section>









                <section>
                    <div>
                        <table id="facarticulo">
                            <thead>
                        <tr id="fa">
                            <th>ID</th>
                            <th>ARTICULO</th>
                            <th>CANTIDAD</th>
                            <th>PRECIO COMPRA</th>
                            <th>PRECIO VENTA</th>
                        </tr>
                    </thead>
                    <tbody>

                      @foreach($ArrayDetalleIng as $ArrayDetalleIng)

                        <tr>
                            <td>{{ $ArrayDetalleIng->articulodetalle->id }}</td>
                            <td>{{ $ArrayDetalleIng->articulodetalle->nombre }}</td>
                            <td>{{ $ArrayDetalleIng->cantidad }}</td>
                            <td>{{ number_format(($ArrayDetalleIng->preciocompra),0,',','.') }}</td>
                            <td>{{ number_format(($ArrayDetalleIng->precio),0,',','.') }}</td>

                            

                        </tr>
                        @endforeach
                    </tbody>
            </table>



            <table id="pagooooooooooo">
                    <thead>
                        <tr id="fv">
                            <th>EFECTIVO</th>
                            <th>CREDITO</th>
                            <th>TOTAL COMPRA</th>
                            

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ number_format(($arrayAbonooooo[0]['efectivo']),0,',','.') }}</td>
                            <td>{{ number_format(($arrayAbonooooo[0]['credito']),0,',','.') }} </td>
                            <td>{{ number_format(($arrayAbonooooo[0]['credito']+$arrayAbonooooo[0]['efectivo']),0,',','.') }} </td>

                        </tr>
                    </tbody>
                </table>

                
            </div>
        </section>   







        
        <br>
        <section>
            <div>
                <table id="facarticulo">
                    <thead>
                        <tr id="fa">
                            <th>ID</th>
                            <th>ABONO</th>
                            <th>OBSERVACIÓN</th>
                            <th>FECHA</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $acumulador = 0; ?>

                      @foreach($arrayAbonooooo as $detallevent)

                        <tr>
                            <td>{{ $detallevent->id }}</td>
                            <td>{{ number_format(($detallevent->abono),0,',','.') }}</td>
                            <td>{{ $detallevent->observacionFormaPago }}</td>
                            <td>{{ $detallevent->created_at }}</td>

                            @php
                        $acumulador+=$detallevent->abono;
                        @endphp
                        </tr>
                        @endforeach
                    </tbody>
                    
                    
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>CREDITO</th>
                            <td>{{ number_format(($arrayAbonooooo[0]['credito']),0,',','.') }}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>TOTAL ABONADO</th>
                            <td>{{ number_format(($acumulador),0,',','.') }}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>      
                            <th></th>
                            <th>DEUDA</th>
                            <td>{{ number_format(($arrayAbonooooo[0]['credito']-$acumulador),0,',','.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
        <br>
        <br>

        <p>firma</p><br>

        _________________________________<br>{{ $mytime }}

        
        
        <footer>
            <div id="gracias">
                <p><b>IMPRESO POR TENDERPOS {{ Auth::user()->usuario }}  </b></p>
            </div>
        </footer>

        
    </body>
</html>