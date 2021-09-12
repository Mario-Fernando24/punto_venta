
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de artículos</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.875rem;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;           
        }s
        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }
        .table-bordered {
            border: 1px solid #c2cfd6;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }
    </style>
</head>
<body>
    <div>
        <h3>Lista de Artículos <span class="derecha">{{now()}}</span></h3>
    </div>
    <div>
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio compra</th>
                    <th>Precio venta</th>
                    <th>Stock</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                </tr>
            </thead>

                @php
                   $acumuladorventa=0;
                   $acumuladorcompra=0;

                @endphp
            <tbody>
                @foreach ($inventariopdf as $a)
                <tr>
              
                        @if($a->comprashas!=null)
                        @php
                        
                                $acumuladorventa+=$a->comprashas->precio*$a->stock;
                                $acumuladorcompra+=$a->comprashas->preciocompra*$a->stock;
                        @endphp
                        @endif
                    

                    <td>{{$a->codigo}}</td>
                    <td>{{$a->nombre}}</td>
                    <td>{{$a->categoria->nombre}}</td>
                    @if($a->comprashas!=null)
                    <td>{{$a->comprashas->preciocompra}}</td>
                    <td>{{$a->comprashas->precio}}</td>
                    @else
                    <td>No Ingresado</td>
                    <td>No Ingresado</td>

                    @endif

                    @if($a->stock>=1)
                    <td>{{$a->stock}}</td>
                    @elseif($a->stock==0)
                    <td style="color:red">{{$a->stock}}</td>
                    @endif
                    <td>{{$a->descripcion}}</td>
                    <td>{{$a->condicion?'Activo':'Desactivado'}}</td>
                </tr>

                @endforeach                                
            </tbody>
        </table>
    </div>

    <div class="izquierda">
        <p><strong># de registros: </strong>{{$cantidad}}<br>
        <p><strong>compra $</strong> {{ number_format($acumuladorcompra)  }}   <br>
        <p><strong>venta $</strong> {{ number_format($acumuladorventa)  }}   <br>
        <p><strong>Ganancias: </strong> {{ number_format($acumuladorventa-$acumuladorcompra)  }}   <br>
        <strong>Impreso: </strong>{{Auth::user()->usuario}}</p>
    </div>    
    
</body>
</html>
