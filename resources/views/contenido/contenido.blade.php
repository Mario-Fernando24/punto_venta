@extends('principal')
@section('contenido')

<template v-if="menu==0">
<Dashboard></Dashboard>
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
                    <Ingreso></Ingreso>
                    </template>

                    <template v-if="menu==4">
                    <Proveedor></Proveedor>
                    </template>

                    <template v-if="menu==5">
                    <Venta></Venta>
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


                    <template v-if="menu==12">
                    <Caja></Caja>
                    </template>

                    <template v-if="menu==9">
                    <Egreso></Egreso>
                    </template>

                    <template v-if="menu==10">
                    <Credito></Credito>
                    </template>

                    <template v-if="menu==16">
                    <Anuladas></Anuladas>
                    </template>



                    <template v-if="menu==17">
                    <Ajusteinventario></Ajusteinventario>
                    </template>


                    <template v-if="menu==15">
                    <Perfil></Perfil>
                    </template>


                    <template v-if="menu==30">
                    <AjusteComprasss></AjusteComprasss>

                    </template>


                <template v-if="menu==24">
                <Caba></Caba>
                </template>

                <template v-if="menu==25">
                <Informes></Informes>
                </template>

                @elseif(Auth::user()->idrol==2)
                
                <template v-if="menu==5">
                <Venta></Venta>
                </template>

                <template v-if="menu==6">
                <Cliente></Cliente>
                </template>


                   <template v-if="menu==12">
                    <Caja></Caja>
                    </template>

                    <template v-if="menu==9">
                    <Egreso></Egreso>
                    </template>

                    <template v-if="menu==10">
                    <Credito></Credito>
                    </template>


                <template v-if="menu==24">
                <Caba></Caba>
                </template>



                @elseif(Auth::user()->idrol==3)


                <template v-if="menu==1">
                <Categoria></Categoria>
                </template>


                <template v-if="menu==2">
                <Articulo></Articulo>
                </template>

                <template v-if="menu==3">
                <Ingreso></Ingreso>
                </template>

                <template v-if="menu==4">
                <Proveedor></Proveedor>
                </template>

                <template v-if="menu==10">
                <h1>Reporte de ventaSSSSSS</H1>
                </template>


                <template v-if="menu==11">
                <h1>aYUDA aYUDA aYUDA</H1>
                </template>

                <template v-if="menu==12">
                <h1>Acerca de Acerca de</H1>
                </template>



    


         @endif

                    
@endif


           
@endsection