<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Compra</title>
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
                <img src="https://10619-2.s.cdn12.com/rests/original/107_507022930.jpg" alt="incanatoIT" id="imagen">
            </div>
            <div id="datos">
                <p id="encabezado">
                    <b>LICOMAHELA</b><br>MIGUEL ALFONSO ROMERO, MONTERIA - CORDOBA, COLOMBIA<br>Telefono:(+51)931742904<br>Email:licomahela7@gmail.com
                </p>
            </div>
            <div id="fact">
                <p>Factura<br>
                # 00{{ $ObjetoDetalleIngreso->id }}</p>
            </div>
        </header>
        <br>
        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">PROVEEDOR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th><p id="cliente">Sr(a). {{ $ObjetoDetalleIngreso->proveedoress->nombre }} <br>
                            {{ $ObjetoDetalleIngreso->proveedoress->tipo_documento }}: {{ $ObjetoDetalleIngreso->proveedoress->num_documento }}<br>
                            Dirección: {{ $ObjetoDetalleIngreso->proveedoress->direccion }}<br>
                            Teléfono: {{ $ObjetoDetalleIngreso->proveedoress->telefono }}<br>
                            Email: {{ $ObjetoDetalleIngreso->proveedoress->email }}</p></th>
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
                            <th>INGRESO LA COMPRA</th>
                            <th>FECHA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $ObjetoDetalleIngreso->usuario->usuario }}</td>
                            <td>{{ $ObjetoDetalleIngreso->created_at }}</td>
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
                            <th>CANT</th>
                            <th>DESCRIPCION</th>
                            <th>PREC COMPRA</th>
                            <th>PREC VENTA</th>
                            <th>SUBTOTAL</th>
                            <th>GANANCIA</th>

                        </tr>
                    </thead>
                    <tbody>
                    <?php $gananciaAcumulada = 0; ?>

                    @foreach($ArrayDetalleIng as $detallevent)

                        <tr>
                            <td>{{ $detallevent->cantidad }}</td>
                            <td>{{ $detallevent->articulodetalle->nombre }}</td>
                            <td>{{ $detallevent->preciocompra }}</td>
                            <td>{{ $detallevent->precio }}</td>
                            <td>{{ number_format(($detallevent->preciocompra*$detallevent->cantidad),0,',','.') }}</td>
                            <td>{{ number_format(($detallevent->precio*$detallevent->cantidad-($detallevent->preciocompra*$detallevent->cantidad)),0,',','.') }}</td>

                            @php
                        $gananciaAcumulada+=($detallevent->precio*$detallevent->cantidad-($detallevent->preciocompra*$detallevent->cantidad));
                        @endphp
                        </tr>
                        @endforeach

                    </tbody>
                    <br><br>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>SUBTOTAL</th>
                            <td>{{ number_format((($ObjetoDetalleIngreso->total)-(($ObjetoDetalleIngreso->total*$ObjetoDetalleIngreso->impuesto)/100)),0,',','.')  }}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>IMPUESTO</th>
                            <td>{{ number_format((($ObjetoDetalleIngreso->total*$ObjetoDetalleIngreso->impuesto)/100),0,',','.') }}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>TOTAL</th>
                            <td>{{ number_format(($ObjetoDetalleIngreso->total),0,',','.')}}</td>
                        </tr>

                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>GANANCIA</th>
                            <td><?php echo number_format($gananciaAcumulada,0,',','.') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
        <br>
        <br>
        <footer>
            <div id="gracias">
                <p><b>compra ingresada por {{ $ObjetoDetalleIngreso->usuario->usuario }}</b></p>
            </div>
        </footer>
    </body>
</html>