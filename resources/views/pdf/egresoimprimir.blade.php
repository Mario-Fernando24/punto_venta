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
                <p>ID<br>
                # {{ $egreso->idegreso }}</p>
            </div>
        </header>

        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">CONCEPTO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th><p id="cliente">{{ $egreso->tipo_egreso }}</p></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section>
            <div>
                <table id="facvendedor">
                    <thead>
                        <tr id="fv">
                            <th>VALOR</th>
                            <th>MOTIVO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $egreso->valor_egreso }}</td>
                            <td>{{ $egreso->motivo_egreso }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        
        
        <footer>
            <div id="gracias">
                <p><b>IMPRESO POR TENDERPOS {{ Auth::user()->usuario }}  </b></p>
            </div>
        </footer>
    </body>
</html>