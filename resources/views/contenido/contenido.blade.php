@extends('principal')
@section('contenido')

<template v-if="menu==0">
<h1>Escritorio</1>
</template>


@if(Auth::check())
      
      @if(Auth::user()->idrol==1)

                    <template v-if="menu==1">
                    <Categoria></Categoria>
                    </template>


                    <template v-if="menu==2">
                    <Articulo></Articulo>
                    </template>

                    <template v-if="menu==3">
                    <h1>Ingresos</1>
                    </template>

                    <template v-if="menu==4">
                    <Proveedor></Proveedor>
                    </template>

                    <template v-if="menu==5">
                    <h1>Ventas</1>
                    </template>

                    <template v-if="menu==6">
                    <Cliente></Cliente>
                    </template>


                    <template v-if="menu==7">
                    <User></User>
                    </template>

                    <template v-if="menu==8">
                    <Roles></Roles>
                    </template>

                    <template v-if="menu==9">
                    <h1>Reporte de ingreso</1>
                    </template>

                    <template v-if="menu==10">
                    <h1>Reporte de venta</1>
                    </template>

                    <template v-if="menu==11">
                    <h1>aYUDA</1>
                    </template>

                    <template v-if="menu==12">
                    <h1>Acerca de</1>
                    </template>


                @elseif(Auth::user()->idrol==2)
                
                <template v-if="menu==5">
                <h1>Ventas</1>
                </template>

                <template v-if="menu==6">
                <Cliente></Cliente>
                </template>

                <template v-if="menu==10">
                <h1>Reporte de venta</1>
                </template>

                <template v-if="menu==11">
                <h1>aYUDA</1>
                </template>

                <template v-if="menu==12">
                <h1>Acerca de</1>
                </template>

                @elseif(Auth::user()->idrol==3)


                <template v-if="menu==1">
                <Categoria></Categoria>
                </template>


                <template v-if="menu==2">
                <Articulo></Articulo>
                </template>

                <template v-if="menu==3">
                <h1>Ingresos</1>
                </template>

                <template v-if="menu==4">
                <Proveedor></Proveedor>
                </template>

                <template v-if="menu==10">
                <h1>Reporte de venta</1>
                </template>


                <template v-if="menu==11">
                <h1>aYUDA</1>
                </template>

                <template v-if="menu==12">
                <h1>Acerca de</1>
                </template>



    


         @endif

                    
@endif


           
@endsection