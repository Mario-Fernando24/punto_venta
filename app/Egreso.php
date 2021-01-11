<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    protected $table = 'egreso';
    protected $primaryKey = 'idegreso';
    
    protected $fillable = [
        'idegreso',
        'id_caja',
        'id_users',
        'tipo_egreso',
        'valor_egreso',
        'motivo_egreso',
    ];


    public function GetCaja(){
        return $this->belongsTo(Caja::class,'id_caja','idcaja');
    }

    public function GetUser(){
        return $this->belongsTo(User::class,'id_users','id');
    }
    

}
