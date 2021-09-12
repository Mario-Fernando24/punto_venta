<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ModelInventario\AjusteInventario;
use App\ModelInventario\AjusteCompra;

class Ingreso extends Model
{
    
    protected $table = 'ingresos';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'idproveedor',
        'idusuario',
        'id_anulo_ingreso',
        'id_apertura_caja_usuario',
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante',
        'fecha_hora',
        'impuesto',
        'forma_pago',
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

    public function usuario_anulo_ingreso(){
        return $this->belongsTo(User::class,'id_anulo_ingreso');
    }

    public function AjusteCompra()
    {
        return $this->hasMany(AjusteCompra::class,'id_compra','id');
    }

    public function detalleCompraArticulos()
    {
        return $this->hasMany(DetalleIngreso::class,'idingreso','id');
    }

}







