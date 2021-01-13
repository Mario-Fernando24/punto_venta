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

    public function ventaCredito()
    {
        return $this->belongsTo(Venta::class,'idVenta');
        
    }

    public function clienteCredito()
    {
        return $this->belongsTo(Persona::class,'idCliente');
        
    }
}
