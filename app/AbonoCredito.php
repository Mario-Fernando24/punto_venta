<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbonoCredito extends Model
{
    
    protected $table = 'abono_creditos';
    protected $primaryKey = 'idCredito';
    
    protected $fillable = [
        'id',
        'id_Credito',
        'idusers',
        'montoAbonar',
        'observacion',
        'estado',
    ];
}
