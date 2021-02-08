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
        font-size: 10px;
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
        font-size: 12px;
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
        font-size: 10px;
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
            <div id="datos">
                <p id="encabezado">
                   <b>Arqueo: # {{ $cajaOpen->idcaja }}</b>
                </p>
            </div>
           
        </header>
        <br>



        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Apertura</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th><p id="cliente">Usuario: {{ $cajaOpen->apertura_vendedor->usuario }} 
                                <br>Fecha apertura: {{ $cajaOpen->Fecha }}
                                @if($cajaOpen->Cajaactual=='abierto')
                                <br>Fecha de cierre: NO CERRADO
                                @else  
                                <br>Fecha de cierre:  {{ $cajaOpen->updated_at }}
                                @endif
                                <br># facturas registrada: {{ $numFacArqueosRegistrado->total }}  
                                <br># facturas anuladas: {{ $numFacArqueosAnulado->total }} 
                                <br>Caja Actual: {{ $cajaOpen->Cajaactual }}
                             </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>






        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Egreso</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th><p id="cliente">Nomina: {{ number_format($nomina,0,',','.') }}
                                            <br>Cortesia: {{ number_format($Cortesia,0,',','.') }}
                                            <br>Gasto administrativo: {{ number_format($GastoAdministrativo,0,',','.') }}   </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>


        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Abono de creditos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th><p id="cliente">Valor : {{ number_format($IngresoAbonoCredito,0,',','.') }}  </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>







        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Credito</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th><p id="cliente">Valor : {{ number_format($Credito,0,',','.') }} </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>








        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Ventas</th>
                        </tr>
                    </thead>
                    <tbody>

                    
                        <tr>
                            <th><p id="cliente">Venta efectivo: {{ number_format($efectivo_de_Ventas,0,',','.') }}
                            <br>Venta en datafono: {{ number_format($datafono_Ventas,0,',','.') }} 
                            <br>Venta: en transferencia:  {{ number_format($transferencia_ventas,0,',','.') }} 
                            <br>Venta por credito: {{ number_format($Credito,0,',','.') }}
                            <br>Venta total:  {{ number_format(($transferencia_ventas+$datafono_Ventas+$efectivo_de_Ventas+$Credito),0,',','.') }}
                        </th>
                            

                        </tr>
                    </tbody>
                </table>
            </div>
        </section>







        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Datafono:</th>
                            <th id="fac">compr</th>
                            <th id="fac">valor</th>
                            <th id="fac">fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($Datafono as $dat)
                        <tr>
                            <th>#{{ $dat->id }}</th>
                            <th>{{ $dat->num_comprobante_pago }}</th>
                            <th>{{ number_format($dat->total,0,',','.') }}</th>
                            <th>{{ $dat->created_at }}</th>
                        </tr>
                    @endforeach  
                    </tbody>
                </table>
            </div>
        </section>


        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Tranferencia:</th>
                            <th id="fac">compr</th>
                            <th id="fac">valor</th>
                            <th id="fac">fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($Transferencia as $tran)
                        <tr>
                            <th>#{{ $tran->id }}</th>
                            <th>{{ $tran->num_comprobante_pago }}</th>
                            <th>{{ number_format($tran->total,0,',','.') }}</th>
                            <th>{{ $tran->created_at }}</th>
                        </tr>
                    @endforeach        
                    </tbody>
                </table>
            </div>
        </section>

        
        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Total a entregar:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th><p id="cliente">Total venta: {{ number_format(($transferencia_ventas+$datafono_Ventas+$efectivo_de_Ventas+$Credito),0,',','.') }}
                                <br>------------------------------------------------
                                <br>Transferencia: (-) {{ number_format(($transferencia_ventas),0,',','.') }}
                                <br>Datafono: (-) {{ number_format(($datafono_Ventas),0,',','.') }}

                                <br>------------------------------------------------

                                <br>Egreso: (-) {{ number_format(($Egreso),0,',','.') }}
                                <br>Credito: (-) {{ number_format(($Credito),0,',','.') }}
                                <br>Ingreso: (+) {{ number_format($IngresoAbonoCredito,0,',','.') }}
                                <br>------------------------------------------------
                                <br>$$$ _________________________________________
                                </th>

                        </tr>
                    </tbody>
                </table>
            </div>
        </section>


        <br><br>
        <p>firma</p><br>

        _________________________________




        
    </body>
</html>