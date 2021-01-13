<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    
    protected $table = 'creditos';
    protected $primaryKey = 'idCredito';
    
    protected $fillable = [
        'idCredito',
        'idVenta',
        'idCliente',
        'deuda',
        'observacion',
        'estado',
    ];
}
