<?php

namespace App\ModelInventario;

use Illuminate\Database\Eloquent\Model;

class AjusteInventario extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_usuario',
        'id_anulo_venta',
        'id_apertura_caja_usuario',
        'tipo_ajuste',
        'motivo',
        'impuesto',
        'total',
        'estado',
    ];


    public function usuario_hizo_el_ajuste(){
        return $this->belongsTo(User::class,'id_usuario');
    }

    public function usuario_anulo_el_ajuste(){
        return $this->belongsTo(User::class,'id_anulo_venta');
    }

}
