<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    
    protected $table = 'ingresos';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'idproveedor',
        'idusuario',
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante',
        'fecha_hora',
        'impuesto',
        'total',
        'estado',
    ];


     //un ingreso pertenece a una proveedor
     public function proveedor(){
        return $this->belongsTo(Proveedor::class,'idproveedor');
    }

     //un ingreso pertenece a un usuario
     public function proveedoress(){
        return $this->belongsTo(Persona::class,'idproveedor');
    }


     //un ingreso pertenece a un usuario
     public function usuario(){
        return $this->belongsTo(User::class,'idusuario');
    }

    //un ingreso pertenece a un usuario
    public function persona(){
        return $this->belongsTo(Persona::class,'idusuario');
    }


}
