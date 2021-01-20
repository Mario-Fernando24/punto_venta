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

    public function detallesVentaCredito()
    {
        return $this->hasMany(DetalleVenta::class,'id_venta','idVenta');
        
    }

    public function AbonoCredito()
    {
        return $this->hasMany(AbonoCredito::class,'id_Credito','idCredito');

    }

}
