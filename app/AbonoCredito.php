<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbonoCredito extends Model
{
    
    protected $table = 'abono_creditos';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_Credito',
        'idusers',
        'montoAbonar',
        'observacion',
        'estado',
    ];


    public function Credito()
    {
        return $this->belongsTo(Credito::class,'id_Credito');
        
    }

    public function UserIngresado()
    {
        return $this->belongsTo(User::class,'idusers');
    }
}
