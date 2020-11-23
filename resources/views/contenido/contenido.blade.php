@extends('principal')
@section('contenido')

<template v-if="menu==0">
<h1>Contenido del menu 0</1>
</template>

<template v-if="menu==1">
<Categoria></Categoria>
</template>


<template v-if="menu==2">
<Articulo></Articulo>
</template>

<template v-if="menu==3">
<h1>Contenido del menu 3</1>
</template>

<template v-if="menu==4">
<Proveedor></Proveedor>
</template>

<template v-if="menu==5">
<h1>Contenido del menu 5</1>
</template>

<template v-if="menu==6">
<Cliente></Cliente>
</template>hhh


<template v-if="menu==7">
<h1>Contenido del menu 7</1>
</template>

<template v-if="menu==8">
<Roles></Roles>
</template>

<template v-if="menu==9">
<h1>Contenido del menu 9</1>
</template>

<template v-if="menu==10">
<h1>Contenido del menu 10</1>
</template>

<template v-if="menu==11">
<h1>Contenido del menu 11</1>
</template>

<template v-if="menu==12">
<h1>Contenido del menu Mario Muñoz</1>
</template>
@endsection