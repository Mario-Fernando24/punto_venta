<?php

namespace App\ModelInventario;

use Illuminate\Database\Eloquent\Model;

class AjusteVenta extends Model
{
    protected $table = 'ajuste_venta';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_venta',
        'id_caja',
        'id_users',
        'efectivo',
        'credito',
        'datafono',
        'tranferencia',
        'datafonoobservacion',
        'tranferenciaobservacion',
        'estado',

    ];
}
