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
                <img src="{{$image}}" alt="incanatoIT" id="imagen">
            </div>
            <div id="datos">
                <p id="encabezado">
                    <b> {{$Perfil->razon_social}}</b><br> {{$Perfil->propietario}}<br>Nit: {{$Perfil->nit}}
                    <br>Telefono:{{$Perfil->telefono}}<br>Email:{{$Perfil->correo}}<br>Ciudad: {{$Perfil->ciudad}}
                    <br>Dirección: {{$Perfil->direccion}}
                </p>
            </div>
            <div id="fact">
                <p>{{ $ObjetoDetalleVent->tipo_comprobante }}<br>
                # 00{{ $ObjetoDetalleVent->id }}<br>
                {{ $ObjetoDetalleVent->forma_pago }}</p>
            </div>
        </header>
        <br>
        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th><p id="cliente">Sr(a). {{ $ObjetoDetalleVent->cliente_persona->nombre }} <br>
                            Documento: {{ $ObjetoDetalleVent->cliente_persona->tipo_documento }} : {{ $ObjetoDetalleVent->cliente_persona->num_documento }}<br>
                            Dirección: {{ $ObjetoDetalleVent->cliente_persona->direccion }}<br>
                            Teléfono: {{ $ObjetoDetalleVent->cliente_persona->telefono }}<br>
                            Email: {{ $ObjetoDetalleVent->cliente_persona->email }}</p></th>
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
                            <th>VENDEDOR</th>
                            <th>FECHA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $ObjetoDetalleVent->usuario_hizola_venta->usuario }} </td>
                            <td>{{ $ObjetoDetalleVent->created_at }} </td>
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
                            <th>PRECIO UNIT</th>
                            <th>DESC.</th>
                            <th>SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($ArrayDetalleVenta as $detalle)

                        <tr>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>{{ $detalle->articulo_Detalle_Venta->nombre }}</td>
                            <td>{{ $detalle->precio }}</td>
                            <td>{{ $detalle->descuento }}</td>
                            <td>{{ number_format(($detalle->precio*$detalle->cantidad)-$detalle->descuento,0,',','.') }}</td>

                        </tr>
                        @endforeach

                    </tbody>
                    <br>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>SUBTOTAL</th>
                            <td>{{number_format((($ObjetoDetalleVent->total)-(($ObjetoDetalleVent->total*$ObjetoDetalleVent->impuesto)/100)),0,',','.')   }}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>IVA</th>
                            <td>{{ number_format(($ObjetoDetalleVent->total*$ObjetoDetalleVent->impuesto)/100,0,',','.') }}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th> 
                            <th>TOTAL</th>
                            <td>{{ number_format($ObjetoDetalleVent->total,0,',','.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
        <br>
        <br>
        <footer>
            <div id="gracias">
                <p><b>Gracias por su compra!</b></p>
            </div>
        </footer>
    </body>
</html>