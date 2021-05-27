<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajuste de Inventario</title>
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
                    <br><b>AJUSTE DE INVENTARIO</b>
                </p>
            </div>
            <div id="fact">
                <b>Tipo de ajuste</b><br>
                <b>{{ $ObjetoDetalleAjuste->tipo_ajuste }}</b>
            </div>
        </header>
        

        <br>
        <section>
            <div>

            
                <div class="col-md-4">
                   <p><b>#</b> {{ $ObjetoDetalleAjuste->id }} &nbsp;&nbsp; <b>USUARIO: </b>&nbsp;&nbsp;{{ $ObjetoDetalleAjuste->usuario_hizo_el_ajuste->usuario }}</p>
                
                    <p><b>CAJA: </b> {{ $ObjetoDetalleAjuste->id_apertura_caja_usuario }} &nbsp;&nbsp;<b>FECHA: </b> &nbsp;&nbsp;{{ $ObjetoDetalleAjuste->created_at }}</p>
                
                    <p><b>MOTIVO: </b> &nbsp;&nbsp;{{ $ObjetoDetalleAjuste->motivo }}</p>
                </div>

            </div>
        </section>
        <br>
        <section>
            <div>
                <table id="facarticulo">
                    <thead>
                        <tr id="fa">

                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            @if($ObjetoDetalleAjuste->tipo_ajuste=='ENTRA')
                            <th>Entra(+)</th>
                            @else
                            <th>Sale(-)</th>
                            @endif
                            <th>Quedan</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($DetalleAjusteArray as $ajuste)
                            <tr>
                                <td>{{$ajuste->id}}</td>
                                <td>{{$ajuste->articulo_detalle_ajuste->nombre}}</td>
                                <td>{{$ajuste->cantidad_existencia}}</td>
                                <td>{{$ajuste->cantidad_entran}}</td>
                                <td>{{$ajuste->cantidad_quedan}}</td>
                                <td>{{number_format(($ajuste->precio),0,',','.')}}</td>


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
                            <td>{{ number_format(($ObjetoDetalleAjuste->total-$ObjetoDetalleAjuste->impuesto),0,',','.')}}</td>

                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>IVA</th>
                            <td>{{ number_format(($ObjetoDetalleAjuste->impuesto),0,',','.')}}</td>

                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th> 
                            <th>TOTAL</th>
                            <td>{{ number_format(($ObjetoDetalleAjuste->total),0,',','.')}}</td>

                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
        <br><br>
        <p>firma</p><br>

        _________________________________<br>{{ $mytime }}

        <footer>
            <div id="gracias">
                <p><b>Ajuste de inventario</b></p>
            </div>
        </footer>
    </body>
</html>