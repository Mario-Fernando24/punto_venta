<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'caja';
    protected $primaryKey = 'idcaja';
    
    protected $fillable = [
        'idcaja',
        'id_vendedor',
        'Cajainicial',
        'Fecha',
        'Cajaactual',
        'obs_apertura',
        'obs_final',
        'dinero_inicial',
        'dinero_final',
        'updated_at',
    ];


    public function apertura_vendedor()
    {
        return $this->belongsTo(User::class,'id_vendedor','id');
        
    }

}
