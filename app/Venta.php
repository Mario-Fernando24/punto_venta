<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_cliente',
        'id_usuario',
        'tipo_comprobante',
        'forma_pago',
        'num_comprobante_pago',
        'fecha_hora',
        'impuesto',
        'total',
        'estado',
    ];

     //una venta puede tener un cliente
     public function cliente_persona(){
        return $this->belongsTo(Persona::class,'id_cliente');
    }

    public function usuario_hizola_venta(){
        return $this->belongsTo(User::class,'id_usuario');
    }

}