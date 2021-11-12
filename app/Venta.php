<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ModelInventario\AjusteVenta;
use App\DetalleVenta;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_cliente',
        'id_usuario',
        'id_anulo_venta',
        'id_apertura_caja_usuario',
        'tipo_comprobante',
        'forma_pago',
        'num_comprobante_pago',
        'fecha_hora',
        'impuesto',
        'total',
        'estado',
        'caba',
        'fechaentregacaba',
    ];

     //una venta puede tener un cliente
     public function cliente_persona(){
        return $this->belongsTo(Persona::class,'id_cliente');
    }

    public function usuario_hizola_venta(){
        return $this->belongsTo(User::class,'id_usuario');
    }

    public function usuario_anulo_venta(){
        return $this->belongsTo(User::class,'id_anulo_venta');
    }

    public function formaspago(){
        return $this->belongsTo(AjusteVenta::class,'id','id_venta');
    }

    public function DetalleVenta(){
        return $this->hasMany(DetalleVenta::class,'id_venta','id');
    }


}
